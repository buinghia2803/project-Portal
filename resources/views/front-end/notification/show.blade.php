@extends('layouts.fe')
@section('content')
@can('member_create')
@endcan
<div class="card">
    <div class="card-header">
        Thông báo chính thức
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.id') }}
                        </th>
                        <th>
                            Subject
                        </th>
                        <th>
                            Published_date
                        </th>
                        <th>
                            Published To
                        </th>
                        <th>
                            Attachment
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-entry-id="{{ $notification->id }}">
                        <td>
                            {{ $notification->id ?? '' }}
                        </td>
                        <td>
                            {{ $notification->subject ?? '' }}
                        </td>
                        <td>
                            {{ $notification->published_date ?? '' }}
                        </td>
                        <td>
                            @if($notification->published_to == null)
                                <p>All</p>
                            @endif  
                        </td>
                        <td>
                            <a href="{{asset('/storage/uploads/'. $notification->attachment)}}" target="_blank">{{ $notification["attachment"] ?? '' }}</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            
        </div>
    </div>
</div>

@endsection