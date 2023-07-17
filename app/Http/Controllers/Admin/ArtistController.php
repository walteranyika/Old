<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyArtistRequest;
use App\Http\Requests\StoreArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Models\Artist;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArtistController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('artist_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artists = Artist::all();

        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        abort_if(Gate::denies('artist_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.artists.create');
    }

    public function store(StoreArtistRequest $request)
    {
        $artist = Artist::create($request->all());

        return redirect()->route('admin.artists.index');
    }

    public function edit(Artist $artist)
    {
        abort_if(Gate::denies('artist_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.artists.edit', compact('artist'));
    }

    public function update(UpdateArtistRequest $request, Artist $artist)
    {
        $artist->update($request->all());

        return redirect()->route('admin.artists.index');
    }

    public function show(Artist $artist)
    {
        abort_if(Gate::denies('artist_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artist->load('artistLoans');

        return view('admin.artists.show', compact('artist'));
    }

    public function destroy(Artist $artist)
    {
        abort_if(Gate::denies('artist_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $artist->delete();

        return back();
    }

    public function massDestroy(MassDestroyArtistRequest $request)
    {
        $artists = Artist::find(request('ids'));

        foreach ($artists as $artist) {
            $artist->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
