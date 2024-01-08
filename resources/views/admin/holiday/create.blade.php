@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.holidays.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.holidays.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.holidays.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}">
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.holidays.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="note">{{ trans('cruds.holidays.fields.note') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{!! old('note') !!}</textarea>
                    @if($errors->has('note'))
                        <div class="invalid-feedback">
                            {{ $errors->first('note') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.holidays.fields.note_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="date">{{ trans('cruds.holidays.fields.date') }}</label>
                    <input class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" type="date" name="date" id="date" value="{{ old('date', '') }}">
                    @if($errors->has('date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.holidays.fields.date_helper') }}</span>
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
