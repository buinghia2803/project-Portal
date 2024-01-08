@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.leave.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.leaves.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group ">
                    <label class="required" for="title">{{ trans('cruds.leave.fields.register_for_year') }}</label>
                    <label class="required" for="title">
                        @php
                            echo Carbon\Carbon::now()->year;
                        @endphp
                    </label>
                </div>
                <div class="form-group">
                    <label class="required" for="quota">{{ trans('cruds.leave.fields.quota') }}</label>
                    <input class="form-control {{ $errors->has('quota') ? 'is-invalid' : '' }}" type="number" min="0" name="quota" id="quota" value="{{ old('quota', '') }}">
                    @if($errors->has('quota'))
                        <div class="invalid-feedback">
                            {{ $errors->first('quota') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.leave.fields.quota_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="note">{{ trans('cruds.leave.fields.note') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{!! old('note') !!}</textarea>
                    @if($errors->has('note'))
                        <div class="invalid-feedback">
                            {{ $errors->first('note') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.leave.fields.note_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="member_id">{{ trans('cruds.leave.fields.member') }}</label>
                    <select name="member_id" id="member_id" class="form-control {{ $errors->has('member_id') ? 'is-invalid' : '' }}">
                        <option value="">Choose Member</option>
                        @foreach($members as $member)
                            <option value="{{$member->id}}">{{$member->full_name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('note'))
                        <div class="invalid-feedback">
                            {{ $errors->first('note') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.leave.fields.member_helper') }}</span>
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
