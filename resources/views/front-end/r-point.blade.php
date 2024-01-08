@extends('layouts.fe')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="d-flex">
            <div class="me-5">R-Point</div>
            <div class="me-2">
                <p>Total Point: {{$point->current_point}}</p>
            </div>
            <div>
                <p>This Month: {{$point->month_point}}</p>
            </div>
        </div>
        <div>
            {{-- <form action="" class="d-flex">
                <select name="period" id="" class="form-control">
                    <option value="1">1 Tháng</option>
                    <option value="3">3 Tháng</option>
                    <option value="6">6 Tháng</option>
                </select>
                <button class="btn btn-success">Search</button>
            </form> --}}

        </div>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $point_action)
                    <tr data-entry-id="{{ $point_action->id }}">
                        <td>
                            {{ $point_action->id ?? '' }}
                        </td>
                        <td>
                            {{ $point_action->full_name ?? '' }}
                        </td>
                        <td>
                            {{ $point_action["date"] ?? '' }}
                        </td>
                        <td>
                            {{ $point_action["action"] ?? '' }}
                        </td>
                        <td>
                            {{ $point_action["point"] ?? '' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $data->links("pagination::bootstrap-4") !!}
        </div>
    </div>
</div>

@endsection