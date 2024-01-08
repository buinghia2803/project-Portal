@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.requests.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.requests.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.id') }}
                            </th>
                            <td>
                                {{ $request->id ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.member') }}
                            </th>
                            <td>
                                {{ $request->members->full_name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.manager') }}
                            </th>
                            <td>
                                {{ $request->manager->full_name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.date') }}
                            </th>
                            <td>
                                {{ $request->request_for_date ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.request_type') }}
                            </th>
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
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.ot') }}
                            </th>
                            <td>
                                {{ $request->request_ot_time ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.lack') }}
                            </th>
                            <td>
                                {{ $request->leave_time ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.comp') }}
                            </th>
                            <td>
                                @if ($request->request_type == 5)
                                    {{ $request->compensation_time ?? '' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.pleave') }}
                            </th>
                            <td>
                                @if ($request->request_type == 2)
                                    {{ $request->leave_time ?? '' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.uleave') }}
                            </th>
                            <td>
                                @if ($request->request_type == 3)
                                    {{ $request->leave_time ?? '' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.status') }}
                            </th>
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
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.request_date') }}
                            </th>
                            <td>
                                {{ $request->created_at ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.requests.fields.reason') }}
                            </th>
                            <td>
                                {{ $request->reason ?? '' }}
                            </td>
                        </tr>

                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.requests.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
