@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.points.title_point') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.points.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="member_id">Member_id</label> <br>
                <select class="form-control" name="member_id" style="cursor: pointer">
                    @foreach($members as $member)
                    <option value="{{$member->id}}">{{$member->full_name}}</option>
                    @endforeach
                </select>
                @if($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="date">Date</label>
                <input class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" type="date" name="date" id="date" value="{{ old('date', '') }}" style="cursor: pointer">
                @if($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="action">Action</label>
                <input class="form-control" name="action">
                @if($errors->has('action'))
                <div class="invalid-feedback">
                    {{ $errors->first('action') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="point">Point</label><br>
                <input type="number" name="point" class="form-control">
                @if($errors->has('point'))
                <div class="invalid-feedback">
                    {{ $errors->first('point') }}
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