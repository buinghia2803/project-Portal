@extends('layouts.admin')
@section('content')
    @can('team_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.teams.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.teams.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.teams.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (count($teams) > 0)
                    <table class=" table table-bordered table-striped table-hover datatable datatable-New">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.teams.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.teams.fields.team_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.teams.fields.status') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($teams as $key => $team)
                                <tr data-entry-id="{{ $team->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $team->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $team['team_name'] ?? '' }}
                                    </td>
                                    <td>
                                        @if ($team['status'] == 0)
                                            <span class="badge badge-danger">{{ $listStatus[0] }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $listStatus[1] }}</span>
                                        @endif
                                    </td>
                                    <td>

                                        @can('team_show')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.teams.show', $team->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('team_edit')
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.teams.edit', $team->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('team_delete')
                                            <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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
                    {{ $teams->links('pagination::bootstrap-4') }}
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
