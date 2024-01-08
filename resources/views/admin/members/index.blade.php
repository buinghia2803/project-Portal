@extends('layouts.admin')

@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-3">
            <a class="btn btn-success" href="{{ route('admin.members.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.members.title_singular') }}
            </a>
        </div>
        <style>
            .btn_search {
                margin-right: 5px;
            }
        </style>
        <div class="col-lg-9">

            <form action="" method="get" style="display: flex; justify-content: flex-end">
                <select class="form-control" aria-label="Default select example" name="member"
                    style="width: 200px; margin-right: 12px;">
                    <option value="{{ Request::get('member') }}">Choose Member</option>
                    @foreach ($memberAll as $member)
                        <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                    @endforeach
                </select>
                <select class="form-control" aria-label="Default select example" name="division"
                    style="width: 200px; margin-right: 12px;">
                    <option value="">Choose Division</option>
                    @foreach ($divisions->unique('division_name') as $division)
                        <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.members.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (count($members) > 0)
                    <table class=" table table-bordered table-striped table-hover datatable datatable-News">
                        <thead>
                            <tr>
                                <th>
                                    Action
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.division') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.full_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.email') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.phone') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.gender') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.marital_status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.birth_date') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.bank_name') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.bank_account') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.status') }}
                                </th>
                                <th>
                                    {{ trans('cruds.members.fields.note') }}
                                </th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($members as $key => $member)
                                <tr data-entry-id="{{ $member->member_code }}">
                                    <td>
                                        @can('member_show')
                                            <a class="btn btn-xs btn-primary"
                                                href="{{ route('admin.members.show', $member->id) }}">
                                                {{ trans('global.view') }}
                                            </a>
                                        @endcan

                                        @can('member_edit')
                                            <a class="btn btn-xs btn-info"
                                                href="{{ route('admin.members.edit', $member->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>
                                        @endcan
                                        @can('member_delete')
                                            <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST"
                                                onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger"
                                                    value="{{ trans('global.delete') }}">
                                            </form>
                                        @endcan
                                    </td>
                                    <td>
                                        {{ $member->id ?? '' }}
                                    </td>
                                    <td>
                                        @foreach ($member->divisions as $item)
                                            {{ $item->division_name ?? '' }}
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $member['full_name'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $member['email'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $member['phone'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $member['gender'] ? 'Female' : 'Male' }}
                                    </td>
                                    <td>
                                        @if ($member['marital_status'] == 1)
                                            <p>Single</p>
                                        @elseif($member['marital_status'] == 2)
                                            <p>Married</p>
                                        @elseif($member['marital_status'] == 3)
                                            <p>Divorced</p>
                                        @elseif($member['marital_status'] == 4)
                                            <p>Other</p>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $member['birth_date'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $member['bank_name'] ?? '' }}
                                    </td>
                                    <td>
                                        {{ $member['bank_account'] ?? '' }}
                                    </td>
                                    <td>
                                        @if ($member['status'] == -1)
                                            <p>Đã nghỉ</p>
                                        @elseif($member['status'] == 1)
                                            <p>Chính thức</p>
                                        @elseif($member['status'] == 2)
                                            <p>Thử việc</p>
                                        @elseif($member['status'] == 3)
                                            <p>Cộng tác viên/partime</p>
                                        @elseif($member['status'] == 4)
                                            <p>Lao động thời vụ</p>
                                        @elseif($member['status'] == 5)
                                            <p>Đào tạo/Fresher</p>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $member['note'] ?? '' }}
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
                {!! $members->links('pagination::bootstrap-4') !!}

            </div>
        </div>
    </div>
@endsection
