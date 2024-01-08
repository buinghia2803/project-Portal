@extends('layouts.admin')
@section('content')
@can('member_create')
<div style="margin-bottom: 10px;" class="row">
    <div class="col-lg-12">
        <a class="btn btn-success" href="{{ route('admin.notification.create') }}">
            {{ trans('global.add') }} {{ trans('cruds.notification.title_singular') }}
        </a>
    </div>
</div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.notification.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>
                            {{ trans('cruds.news.fields.id') }}
                        </th>
                        <th>
                            Subject
                        </th>
                        <th>
                            Published date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Published to
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notification as $key => $item)
                    <tr data-entry-id="{{ $item->id }}">
                        <td>
                            {{ $item->id ?? '' }}
                        </td>
                        <td>
                            {{ $item->subject ?? '' }}
                        </td>
                        <td>
                            {{ $item["published_date"] ?? '' }}
                        </td>
                        <td>
                            @if ($item["status"] == 1)
                                Published
                            @else
                                Draft
                            @endif
                        </td>
                        <td>
                            @foreach ($divisions as $division)
                                @if ($item["published_to"] == $division['id'])
                                    {{$division['division_name']}}
                                @endif
                            @endforeach
                            @if ($item["published_to"] == '')
                                All
                            @endif
                        </td>
                        <td>
                            @can('member_edit')
                            <a class="btn btn-xs btn-info" href="{{ route('admin.notification.edit', $item->id) }}">
                                {{ trans('global.edit') }}
                            </a>
                            @endcan

                            @can('member_delete')
                            <form action="{{ route('admin.notification.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $notification->links("pagination::bootstrap-4") !!}
        </div>
    </div>
</div>

@endsection