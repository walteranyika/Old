@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.artist.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.artists.update", [$artist->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.artist.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $artist->name) }}" required>
                @if($errors->has('name'))
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.artist.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.artist.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $artist->phone) }}" required>
                @if($errors->has('phone'))
                <div class="invalid-feedback">
                    {{ $errors->first('phone') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.artist.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('pin_reset') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="pin_reset" value="0">
                    <input class="form-check-input" type="checkbox" name="pin_reset" id="pin_reset" value="1" {{ $artist->pin_reset || old('pin_reset', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="pin_reset">{{ trans('cruds.artist.fields.pin_reset') }}</label>
                </div>
                @if($errors->has('pin_reset'))
                <div class="invalid-feedback">
                    {{ $errors->first('pin_reset') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.artist.fields.pin_reset_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('enabled') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="enabled" value="0">
                    <input class="form-check-input" type="checkbox" name="enabled" id="enabled" value="1" {{ $artist->enabled || old('enabled', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="enabled">{{ trans('cruds.artist.fields.enabled') }}</label>
                </div>
                @if($errors->has('enabled'))
                <div class="invalid-feedback">
                    {{ $errors->first('enabled') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.artist.fields.enabled_helper') }}</span>
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