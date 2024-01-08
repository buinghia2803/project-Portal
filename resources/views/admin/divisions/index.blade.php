@extends('layouts.admin')
@section('content')
    @can('division_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.divisions.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.divisions.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.divisions.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (count($divisions) > 0)
                    <table class=" table table-bordered table-striped table-hover datatable datatable-New">
                        <thead>
                            <tr>
                                <th>
                                    {{ trans('cruds.divisions.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.divisions.fields.division_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.divisions.fields.status') }}
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($divisions as $key => $division)
                                <tr data-entry-id="{{ $division->id }}">
                                    <td>
                                        {{ $division->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $division['division_name'] ?? '' }}
                                    </td>
                                    <td>
                                        @if ($division['status'] == 0)
                                            <span class="badge badge-danger">{{ $listStatus[0] }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $listStatus[1] }}</span>
                                        @endif
                                    </td>
                                    <td>

                                        @can('division_show')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.divisions.show', $division->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('division_edit')
                                            <a class="btn btn-xs btn-info"
                                                href="{{ route('admin.divisions.edit', $division->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('division_delete')
                                            <form action="{{ route('admin.divisions.destroy', $division->id) }}"
                                                method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger"
                                                    value="{{ trans('global.delete') }}">
                                            </form>
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
                <div class="text-center">
                    {{ $divisions->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script>
        // khi chuyển trang thì xoá dữ liệu trong storage
        localStorage.removeItem('obj');
    </script>
@endsection
