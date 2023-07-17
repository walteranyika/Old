<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAmountLimitRequest;
use App\Http\Requests\StoreAmountLimitRequest;
use App\Http\Requests\UpdateAmountLimitRequest;
use App\Models\AmountLimit;
use App\Models\Artist;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AmountLimitController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('amount_limit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amountLimits = AmountLimit::with(['artist'])->get();

        return view('admin.amountLimits.index', compact('amountLimits'));
    }

    public function create()
    {
        abort_if(Gate::denies('amount_limit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artists = Artist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.amountLimits.create', compact('artists'));
    }

    public function store(StoreAmountLimitRequest $request)
    {
        $amountLimit = AmountLimit::create($request->all());

        return redirect()->route('admin.amount-limits.index');
    }

    public function edit(AmountLimit $amountLimit)
    {
        abort_if(Gate::denies('amount_limit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artists = Artist::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $amountLimit->load('artist');

        return view('admin.amountLimits.edit', compact('amountLimit', 'artists'));
    }

    public function update(UpdateAmountLimitRequest $request, AmountLimit $amountLimit)
    {
        $amountLimit->update($request->all());

        return redirect()->route('admin.amount-limits.index');
    }

    public function show(AmountLimit $amountLimit)
    {
        abort_if(Gate::denies('amount_limit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amountLimit->load('artist');

        return view('admin.amountLimits.show', compact('amountLimit'));
    }

    public function destroy(AmountLimit $amountLimit)
    {
        abort_if(Gate::denies('amount_limit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $amountLimit->delete();

        return back();
    }

    public function massDestroy(MassDestroyAmountLimitRequest $request)
    {
        $amountLimits = AmountLimit::find(request('ids'));

        foreach ($amountLimits as $amountLimit) {
            $amountLimit->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
