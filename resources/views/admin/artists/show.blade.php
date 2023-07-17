@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.artist.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.artists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.artist.fields.id') }}
                        </th>
                        <td>
                            {{ $artist->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.artist.fields.name') }}
                        </th>
                        <td>
                            {{ $artist->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.artist.fields.phone') }}
                        </th>
                        <td>
                            {{ $artist->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.artist.fields.pin_reset') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $artist->pin_reset ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.artist.fields.enabled') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $artist->enabled ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.artist.fields.created_at') }}
                        </th>
                        <td>
                            {{ $artist->created_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.artists.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#artist_loans" role="tab" data-toggle="tab">
                {{ trans('cruds.loan.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="artist_loans">
            @includeIf('admin.artists.relationships.artistLoans', ['loans' => $artist->artistLoans])
        </div>
    </div>
</div>

@endsection