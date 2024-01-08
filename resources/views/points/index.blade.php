@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between">
        @can('member_create')
            <div style="margin-bottom: 10px;">
                <div>
                    <a class="btn btn-success" href="{{ route('admin.points.create') }}">
                        {{ trans('global.add') }} {{ trans('cruds.points.title_point') }}
                    </a>
                </div>
            </div>
        @endcan
        <div style="margin-bottom: 10px;">
            <form action="" class="d-flex">
                <select class="form-control" aria-label="Default select example" name="member"
                    style="width: 200px; margin-right: 12px;">
                    <option value="">Choose Member</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.points.title_point') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (count($pointActions) > 0)
                    <table class=" table table-bordered table-hover datatable datatable-News">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('cruds.news.fields.id') }}
                                </th>
                                <th>
                                    Member Name
                                </th>
                                <th>
                                    Date
                                </th>
                                <th>
                                    Action
                                </th>
                                <th>
                                    Point
                                </th>
                                <th>
                                    Current Point
                                </th>
                                <th>
                                    Month Point
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pointActions as $key => $point_action)
                                <tr data-entry-id="{{ $point_action->id }}">
                                    <td>
                                        {{ $point_action->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $point_action->member->full_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $point_action['date'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $point_action['action'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $point_action['point'] ?? '' }}
                                    </td>
                                    <td>
                                        @php
                                            $point = App\Models\Point::where('member_id', $point_action->member->id)->first();
                                            echo $point->current_point;
                                        @endphp
                                    </td>
                                    <td>
                                        @php
                                            echo $point->month_point;
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="card rounded border-0">
                        <div class="card-body p-4">
                            <div class="text-center text-muted mb-4 h5">
                                No Data</div>
                        </div>
                    </div>
                @endif
                {!! $pointActions->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>

@endsection
