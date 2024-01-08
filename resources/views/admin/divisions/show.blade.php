@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.divisions.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.divisions.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.divisions.fields.id') }}
                        </th>
                        <td>
                            {{ $division->id  ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.divisions.fields.division_name') }}
                        </th>
                        <td>
                            {{ $division["division_name"] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.divisions.fields.dm_id') }}
                        </th>
                        <td>
                            <span class="badge badge-dark">{{ $division->divisionManager->full_name ?? '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.divisions.fields.status') }}
                        </th>
                        <td>
                            @if( $division["status"] == 0 )
                                <span class="badge badge-danger">{{ $listStatus[0] ?? '' }}</span>
                            @else
                                <span class="badge badge-success">{{ $listStatus[1] ?? '' }}</span>
                            @endif                        
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.divisions.fields.members') }}
                        </th>
                        <td>
                            @foreach( $division->members as $member )
                                <span class="badge badge-dark">{{ $member->full_name ?? '' }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.divisions.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
