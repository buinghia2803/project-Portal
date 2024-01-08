@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.teams.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.id') }}
                        </th>
                        <td>
                            {{ $team->id  ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.team_name') }}
                        </th>
                        <td>
                            {{ $team["team_name"] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.leader_id') }}
                        </th>
                        <td>
                            <span class="badge badge-dark">{{ $team->teamLeader->full_name ?? '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.status') }}
                        </th>
                        <td>
                            @if( $team["status"] == 0 )
                                <span class="badge badge-danger">{{ $listStatus[0] ?? '' }}</span>
                            @else
                                <span class="badge badge-success">{{ $listStatus[1] ?? '' }}</span>
                            @endif                        
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.teams.fields.members') }}
                        </th>
                        <td>
                            @foreach( $team->members as $member )
                                <span class="badge badge-dark">{{ $member->full_name ?? '' }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
