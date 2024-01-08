@extends('layouts.admin')
@section('content')
    @can('leave_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.addAllLeave') }}">
                    {{ trans('global.add') }} {{ trans('cruds.leave.add_all') }}
                </a>
                <a class="btn btn-success" href="{{ route('admin.leaves.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.leave.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.leave.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if (count($leaves) > 0)
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                        <thead>
                            <tr>
                                <th width="10">

                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.id') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.member') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.original') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.addition') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.remain') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.paid_leave') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.unpaid_leave') }}
                                </th>
                                <th>
                                    {{ trans('cruds.leave.fields.total_leave') }}
                                </th>
                                <th>
                                    {{ trans('global.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $key => $leave)
                                <tr data-entry-id="{{ $leave->id }}">
                                    <td>

                                    </td>
                                    <td>
                                        {{ $leave->id ?? '' }}
                                    </td>
                                    <td>
                                        {{ $leave->member->full_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $original }} day(s)
                                    </td>
                                    <td>
                                        {{ $leave->quota - $original ?? 0 }} day(s)
                                    </td>
                                    <td>
                                        {{ $leave->remain ?? 0 }} day(s)
                                    </td>
                                    <td>
                                        {{ $leave->paid_leave ?? 0 }} day(s)
                                    </td>
                                    <td>
                                        {{ $leave->unpaid_leave ?? 0 }} day(s)
                                    </td>
                                    <td>
                                        {{ $leave->paid_leave + $leave->unpaid_leave ?? 0 }} day(s)
                                    </td>
                                    <td>
                                        @can('leave_show')
                                            <button class="request btn btn-xs btn-primary" data-year="{{ $leave->year }}"
                                                data-member-id="{{ $leave->member_id }}" data-toggle="modal"
                                                data-target="#request">
                                                @php
                                                    echo \App\Models\LeaveRequest::where('year', $leave->year)
                                                        ->where('member_id', $leave->member_id)
                                                        ->count();
                                                @endphp
                                                {{ trans('cruds.leave.request') }}
                                            </button>
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
                {{ $leaves->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="request" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td scope="col">ID</td>
                                <td scope="col">Member</td>
                                <td scope="col">Year</td>
                                <td scope="col">Type</td>
                                <td scope="col">Quota</td>
                                <td scope="col">Note</td>
                                <td scope="col">Status</td>
                            </tr>
                        </thead>
                        <tbody class="foreach_request">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#request').on('hidden.bs.modal', function(e) {
            $('#requset .foreach_request').html('')
        })
        $('.request').on('click', function() {
            var year = $(this).data('year')
            var member_id = $(this).data('member-id')
            $.ajax({
                'type': 'get',
                'url': "{{ route('admin.showRequest') }}",
                'data': {
                    year,
                    member_id
                },
                'success': (req) => {
                    let html = ''
                    req.data.forEach(element => {
                        var type = ''

                        if (element.type) {
                            type = 'Addition'
                        } else {
                            type = 'Original'
                        }

                        var status = ''

                        if (element.status == 2) {
                            status = 'Approved'
                        } else if (element.status == 1) {
                            status = 'Confirmed'
                        } else {
                            status = 'Sending'
                        }
                        html += `
                        <tr>
                            <td><p>${element.id}</p></td>
                            <td><p>${element.full_name}</p></td>
                            <td><p>${element.year}</p></td>
                            <td><p>${type}</p></td>
                            <td><p>${element.quota}</p></td>
                            <td><p>${element.note}</p></td>
                            <td><p>${status}</p></td>
                        </tr>
                    `
                    });
                    $('#request .foreach_request').html(html)
                }
            })
        })
    </script>
@endsection
