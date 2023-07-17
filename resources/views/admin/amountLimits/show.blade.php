@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.amountLimit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.amount-limits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.amountLimit.fields.id') }}
                        </th>
                        <td>
                            {{ $amountLimit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amountLimit.fields.royalties') }}
                        </th>
                        <td>
                            {{ $amountLimit->royalties }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amountLimit.fields.advance_limit') }}
                        </th>
                        <td>
                            {{ $amountLimit->advance_limit }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.amountLimit.fields.artist') }}
                        </th>
                        <td>
                            {{ $amountLimit->artist->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.amount-limits.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection