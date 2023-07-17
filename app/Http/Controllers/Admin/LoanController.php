<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLoanRequest;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Artist;
use App\Models\Loan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoanController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('loan_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loans = Loan::with(['artist'])->get();

        return view('admin.loans.index', compact('loans'));
    }

    public function create()
    {
        abort_if(Gate::denies('loan_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artists = Artist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.loans.create', compact('artists'));
    }

    public function store(StoreLoanRequest $request)
    {
        $loan = Loan::create($request->all());

        return redirect()->route('admin.loans.index');
    }

    public function edit(Loan $loan)
    {
        abort_if(Gate::denies('loan_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artists = Artist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $loan->load('artist');

        return view('admin.loans.edit', compact('artists', 'loan'));
    }

    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        $loan->update($request->all());

        return redirect()->route('admin.loans.index');
    }

    public function show(Loan $loan)
    {
        abort_if(Gate::denies('loan_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loan->load('artist');

        return view('admin.loans.show', compact('loan'));
    }

    public function destroy(Loan $loan)
    {
        abort_if(Gate::denies('loan_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loan->delete();

        return back();
    }

    public function massDestroy(MassDestroyLoanRequest $request)
    {
        $loans = Loan::find(request('ids'));

        foreach ($loans as $loan) {
            $loan->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
