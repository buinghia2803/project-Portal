@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.notification.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.notification.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="date">Published Date</label>
                <input class="form-control {{ $errors->has('published_date') ? 'is-invalid' : '' }}" type="date" name="published_date" id="published_date" value="{{ old('published_date', '') }}" required>
                @if($errors->has('published_date'))
                <div class="invalid-feedback">
                    {{ $errors->first('published_date') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" class="form-control" id="">
                @if($errors->has('subject'))
                <div class="invalid-feedback">
                    {{ $errors->first('subject') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control ckeditor {{ $errors->has('content') ? 'is-invalid' : '' }}" name="message" id="message">{!! old('message') !!}</textarea>
                @if($errors->has('message'))
                <div class="invalid-feedback">
                    {{ $errors->first('message') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <div style="margin-bottom: 10px;" class="row">
                    <select name="status" class="form-control" aria-label="Default select example" style="width: 120px; margin-left: 12px;">
                        @foreach($status as $key => $statu)
                        <option value="{{$key}}">{{$statu}}</option>
                        @endforeach
                    </select>
                </div>
                @if($errors->has('status'))
                <div class="invalid-feedback">
                    {{ $errors->first('status') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="published_to">Published To</label>
                <select class="form-control" aria-label="Default select example" name="published_to" style="width: 200px; margin-right: 12px;">
                    <option value="">All</option>
                    @foreach($divisions as $division)
                    <option value="{{$division->id}}">{{$division->division_name}}</option>
                    @endforeach
                </select>
                @if($errors->has('published_to'))
                <div class="invalid-feedback">
                    {{ $errors->first('published_to') }}
                </div>
                @endif
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