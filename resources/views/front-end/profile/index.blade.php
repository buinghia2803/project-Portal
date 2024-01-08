@extends('layouts.fe')
@section('content')
    <fieldset class="border p-2">
        <legend class="float-none w-auto p-2">My profile</legend>
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-6">
                        <img src="{{ asset('uploads/' . $item->avatar) }}" alt="" style="width: 150px; margin-bottom: 10px; margin-left: 20px">
                    </div>
                    <div class="col-4">
                        <ul>
                            <li class="row">Member Code: {{ $item->member_code }}</li>
                            <li class="row">Email: {{ $item->email }}</li>
                            <li class="row">Name: {{ $item->full_name }}</li>
                            <li class="row">Phone number: {{ $item->phone }}</li>
                        </ul>
                    </div>
                    <div class="col-2">
                        <a href="{{ route('user.profile.edit', [$item->id]) }}" class="btn btn-success">Edit Profile</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <ul>
                            @if ($item->gender == 0)
                                <li class="row">
                                    Gender: Female
                                </li>
                            @else
                                <li class="row">
                                    Gender: Male
                                </li>
                            @endif
                            <li class="row">Birth Date: {{ $item->birth_date }}</li>
                            <li class="row">Identity Number: {{ $item->identity_number }}</li>
                            <li class="row">Date of issue Identity: {{ $item->identity_card_date }}</li>
                            <li class="row">Place of issue Identity: {{ $item->identity_card_place }}</li>
                            <li class="row">Nationality: {{ $item->nationality }}</li>
                            <li class="row">Permanent Address: {{ $item->permanent_address }}</li>
                            <li class="row">Temporary Address: {{ $item->temporary_address }}</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul>
                            <li class="row">Bank Name: {{ $item->bank_name }}</li>
                            <li class="row">Bank Account: {{ $item->bank_account }}</li>
                            <li class="row">Marital Status: {{ $item->marital_status }}</li>
                            <li class="row">Academic Level: {{ $item->academic_level }}</li>
                            <li class="row">Emergency Contact Name: {{ $item->emergency_contact_name }}</li>
                            <li class="row">Emergency Contact Relationship:
                                {{ $item->emergency_contact_relationship }}</li>
                            <li class="row">Emergency Contact Number: {{ $item->emergency_contact_number }}</li>
                            <li class="row">Start Date: {{ $item->start_date_official }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
@endsection
