@extends('layouts.admin')
@section('content')
    @can('holiday_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.holidays.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.holidays.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.holidays.title_singular') }} {{ trans('global.list') }}
        </div>
        @if (count($holidays))
            <div class="card-body">
                <div class="table-responsive">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.holidays.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.holidays.fields.title') }}
                                </th>
                                <th>
                                    {{ trans('cruds.holidays.fields.note') }}
                                </th>
                                <th>
                                    {{ trans('cruds.holidays.fields.date') }}
                                </th>
                                <th>
                                    &nbsp;
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidays as $key => $holiday)
                                <tr data-entry-id="{{ $holiday->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $holiday->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $holiday->title ?? '' }}
                                    </td>
                                    <td>
                                        {{ $holiday->note ?? '' }}
                                    </td>
                                    <td>
                                        {{ $holiday->date ? Carbon\Carbon::parse($holiday->date)->format('d/m/Y') : '' }}
                                    </td>
                                    <td>
                                        @can('holiday_show')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.holidays.show', $holiday->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('holiday_edit')
                                            <a class="btn btn-xs btn-info"
                                                href="{{ route('admin.holidays.edit', $holiday->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan

                                        @can('holiday_delete')
                                            <form action="{{ route('admin.holidays.destroy', $holiday->id) }}" method="POST"
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
        {{ $holidays->links('pagination::bootstrap-4') }}
    </div>
    </div>
    </div>
@endsection
