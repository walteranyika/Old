@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.amountLimit.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.amount-limits.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="royalties">{{ trans('cruds.amountLimit.fields.royalties') }}</label>
                <input class="form-control {{ $errors->has('royalties') ? 'is-invalid' : '' }}" type="number" name="royalties" id="royalties" value="{{ old('royalties', '') }}" step="0.01" required>
                @if($errors->has('royalties'))
                <div class="invalid-feedback">
                    {{ $errors->first('royalties') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.amountLimit.fields.royalties_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="advance_limit">{{ trans('cruds.amountLimit.fields.advance_limit') }}</label>
                <input class="form-control {{ $errors->has('advance_limit') ? 'is-invalid' : '' }}" type="number" name="advance_limit" id="advance_limit" value="{{ old('advance_limit', '') }}" step="0.01" required>
                @if($errors->has('advance_limit'))
                <div class="invalid-feedback">
                    {{ $errors->first('advance_limit') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.amountLimit.fields.advance_limit_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="artist_id">{{ trans('cruds.amountLimit.fields.artist') }}</label>
                <select class="form-control select2 {{ $errors->has('artist') ? 'is-invalid' : '' }}" name="artist_id" id="artist_id" required>
                    @foreach($artists as $id => $entry)
                    <option value="{{ $id }}" {{ old('artist_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('artist'))
                <div class="invalid-feedback">
                    {{ $errors->first('artist') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.amountLimit.fields.artist_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection