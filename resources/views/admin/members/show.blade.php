@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.members.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.members.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.id') }}
                        </th>
                        <td>
                            {{ $member->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.member_code') }}
                        </th>
                        <td>
                            {{ $member->member_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.full_name') }}
                        </th>
                        <td>
                            {{ $member->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <td>
                            {{ $member->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.nick_name') }}
                        </th>
                        <td>
                            {{ $member->nick_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.other_email') }}
                        </th>
                        <td>
                            {{ $member->other_email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.phone') }}
                        </th>
                        <td>
                            {{ $member->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.skype') }}
                        </th>
                        <td>
                            {{ $member->skype }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.facebook') }}
                        </th>
                        <td>
                            {{ $member->facebook }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.gender') }}
                        </th>
                        <td>
                            {{ $member->gender }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.marital_status') }}
                        </th>
                        <td>
                            {{ $member->marital_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.avatar') }}
                        </th>
                        <td>
                            {{ $member->avatar }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.birth_date') }}
                        </th>
                        <td>
                            {{ $member->birth_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.permanent_address') }}
                        </th>
                        <td>
                            {{ $member->permanent_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.temporary_address') }}
                        </th>
                        <td>
                            {{ $member->temporary_address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.identity_number') }}
                        </th>
                        <td>
                            {{ $member->identity_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.identity_card_date') }}
                        </th>
                        <td>
                            {{ $member->identity_card_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.identity_card_place') }}
                        </th>
                        <td>
                            {{ $member->identity_card_place }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.passport_number') }}
                        </th>
                        <td>
                            {{ $member->passport_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.passport_expiration') }}
                        </th>
                        <td>
                            {{ $member->passport_expiration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.nationality') }}
                        </th>
                        <td>
                            {{ $member->nationality }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.emergency_contact_name') }}
                        </th>
                        <td>
                            {{ $member->emergency_contact_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.emergency_contact_relationship') }}
                        </th>
                        <td>
                            {{ $member->emergency_contact_relationship }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.emergency_contact_number') }}
                        </th>
                        <td>
                            {{ $member->emergency_contact_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.academic_level') }}
                        </th>
                        <td>
                            {{ $member->academic_level }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.graduate_year') }}
                        </th>
                        <td>
                            {{ $member->graduate_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $member->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.bank_account') }}
                        </th>
                        <td>
                            {{ $member->bank_account }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.tax_identification') }}
                        </th>
                        <td>
                            {{ $member->tax_identification }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.tax_date') }}
                        </th>
                        <td>
                            {{ $member->tax_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.tax_place') }}
                        </th>
                        <td>
                            {{ $member->tax_place }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.insurance_number') }}
                        </th>
                        <td>
                            {{ $member->insurance_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.healthcare_provider') }}
                        </th>
                        <td>
                            {{ $member->healthcare_provider }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.start_date_official') }}
                        </th>
                        <td>
                            {{ $member->start_date_official }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.start_date_probation') }}
                        </th>
                        <td>
                            {{ $member->start_date_probation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.end_date') }}
                        </th>
                        <td>
                            {{ $member->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.status') }}
                        </th>
                        <td>
                            {{ $member->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.note') }}
                        </th>
                        <td>
                            {{ $member->note }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.roles') }}
                        </th>
                        <td>
                            @foreach($member->roles as $key => $roles)
                                <span class="label label-info">{{ $roles->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.division') }}
                        </th>
                        <td>
                            @foreach($member->divisions as $key => $roles)
                                <span class="label label-info">{{ $roles->division_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.team') }}
                        </th>
                        <td>
                            @foreach($member->teams as $key => $roles)
                                <span class="label label-info">{{ $roles->team_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.members.fields.shift') }}
                        </th>
                        <td>
                            @foreach($member->shifts as $key => $roles)
                                <span class="label label-info">{{ $roles->shift_name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.members.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>



@endsection
