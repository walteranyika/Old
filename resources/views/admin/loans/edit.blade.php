@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.loan.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loans.update", [$loan->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.loan.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $loan->amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                <div class="invalid-feedback">
                    {{ $errors->first('amount') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.loan.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="code">{{ trans('cruds.loan.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', $loan->code) }}">
                @if($errors->has('code'))
                <div class="invalid-feedback">
                    {{ $errors->first('code') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.loan.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="duration">{{ trans('cruds.loan.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="number" name="duration" id="duration" value="{{ old('duration', $loan->duration) }}" step="1" required>
                @if($errors->has('duration'))
                <div class="invalid-feedback">
                    {{ $errors->first('duration') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.loan.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('processed') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="processed" value="0">
                    <input class="form-check-input" type="checkbox" name="processed" id="processed" value="1" {{ $loan->processed || old('processed', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="processed">{{ trans('cruds.loan.fields.processed') }}</label>
                </div>
                @if($errors->has('processed'))
                <div class="invalid-feedback">
                    {{ $errors->first('processed') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.loan.fields.processed_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('repaid') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="repaid" id="repaid" value="1" {{ $loan->repaid || old('repaid', 0) === 1 ? 'checked' : '' }} required>
                    <label class="required form-check-label" for="repaid">{{ trans('cruds.loan.fields.repaid') }}</label>
                </div>
                @if($errors->has('repaid'))
                <div class="invalid-feedback">
                    {{ $errors->first('repaid') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.loan.fields.repaid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="artist_id">{{ trans('cruds.loan.fields.artist') }}</label>
                <select class="form-control select2 {{ $errors->has('artist') ? 'is-invalid' : '' }}" name="artist_id" id="artist_id" required>
                    @foreach($artists as $id => $entry)
                    <option value="{{ $id }}" {{ (old('artist_id') ? old('artist_id') : $loan->artist->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('artist'))
                <div class="invalid-feedback">
                    {{ $errors->first('artist') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.loan.fields.artist_helper') }}</span>
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