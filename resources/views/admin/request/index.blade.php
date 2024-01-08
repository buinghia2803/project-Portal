@extends('layouts.admin')
@section('content')
    @can('permission_access')
        <div style="margin-bottom: 10px;" class="row">
            <style>
                .btn_search {
                    margin-right: 5px;
                }
            </style>
            <div class="col-lg-12">
                <div class="d-flex justify-content-end">

                    <form action="" method="get" style="display: flex; justify-content: flex-end">
                        <td>
                            <input type="text" name="search" placeholder="Search full_name" class="btn_search form-control">
                        </td>
                        <button class="btn btn-primary">Search</button>
                    </form>

                </div>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.requests.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if ($requests->count() > 0)
                    <table class=" table table-bordered table-striped table-hover datatable datatable-New">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('cruds.requests.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.requests.fields.member') }}
                                </th>
                                <th>
                                    {{ trans('cruds.requests.fields.date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.requests.fields.request_type') }}
                                </th>
                                <th>
                                    {{ trans('cruds.requests.fields.status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.requests.fields.request_date') }}
                                </th>
                                <th>
                                    {{ trans('global.actions') }}
                                </th>
                            </tr>

                        </thead>

                        <tbody>
                            @foreach ($requests as $request)
                                <tr data-entry-id="{{ $request->id }}">
                                    <td>
                                        {{ $request->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $request->members->full_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $request->request_for_date ?? '' }}
                                    </td>
                                    <td>
                                        @if ($request->request_type == 1)
                                            <p>forget check-in/check-out</p>
                                        @elseif ($request->request_type == 2)
                                            <p>paid leave</p>
                                        @elseif ($request->request_type == 3)
                                            <p>unpaid leave</p>
                                        @elseif ($request->request_type == 4)
                                            <p>late/early</p>
                                        @elseif ($request->request_type == 5)
                                            <p>ot</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($request->status == -1)
                                            <p>reject</p>
                                        @elseif ($request->status == 0)
                                            <p>sent</p>
                                        @elseif ($request->status == 1)
                                            <p>confirmed</p>
                                        @elseif ($request->status == 2)
                                            <p>approved</p>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $request->created_at ?? '' }}
                                    </td>
                                    <td>
                                        @can('request_approved')
                                            <form action="{{ route('admin.requests.update', $request->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="submit" class="btn btn-xs btn-danger"
                                                    value="{{ trans('cruds.requests.approved') }}">
                                            </form>
                                        @endcan

                                        @can('request_show')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.requests.show', $request->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan
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
                {!! $requests->links('pagination::bootstrap-4') !!}
            </div>
        </div>
    </div>
@endsection
