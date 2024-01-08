@extends('layouts.fe')
@section('content')
    <style>
        li {
            margin-bottom: 10px;
        }

    </style>
    <fieldset class="border p-2">
        <legend class="float-none w-auto p-2">My profile</legend>
        <div class="container">
            <div class="row">
                <form action="{{ route('user.profile.update', [$member->id]) }}" method="Post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('Put')
                    <div class="row">
                        <div class="col-6">
                            <label class="mr-2">Avatar</label>
                            <input type="file" name="file_avatar" id="files" class="mb-3">
                            <br>
                            <img src="{{ asset('uploads/' . $member->avatar) }}" alt="" id="preview-img"
                                style="width: 150px; margin-bottom: 10px">
                            {{-- <img src="{{ asset('/storage/uploads/'.$member->avatar_offical) }}" alt="" style="width: 150px;"> --}}
                        </div>
                        <ul class="col-4">
                            <li class="row">
                                <label class="col-6" for="">Member Code:</label>
                                <input class="col-6" type="text" name="member_code" id="member_code"
                                    value="{{ old('member_code', $member['member_code']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Email: *</label>
                                <input class="col-6" type="text" name="email" id="email"
                                    value="{{ old('email', $member['email']) }}">
                            </li>
                            <li class="row"><label class="col-6" for="">Name *</label>
                                <input class="col-6" type="text" name="full_name" id="full_name"
                                    value="{{ old('full_name', $member['full_name']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Phone number: *</label>
                                <input class="col-6" type="text" name="phone" id="phone"
                                    value="{{ old('phone', $member['phone']) }}">
                            </li>
                        </ul>
                        <div class="col-2">
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <ul class="col-6">
                            <li class="row"> <label class="col-6" for="">Gender: *</label>
                                @if ($member['gender'] == 1)
                                    <input class="col-6" type="text" value="male">
                                    <input type="text" name="gender" id="gender" value="1" hidden>
                                @else
                                    <input class="col-6" type="text" value="female">
                                    <input type="text" name="gender" id="gender" value="0" hidden>
                                @endif
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Birth Date: *</label>
                                <input class="col-6" type="text" name="birth_date" id="birth_date"
                                    value="{{ old('birth_date', $member['birth_date']) }}" disabled>
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Identity Number: *</label>
                                <input class="col-6" type="text" name="identity_number" id="identity_number"
                                    value="{{ old('identity_number', $member['identity_number']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Date of issue Identity: *</label>
                                <input class="col-6" type="text" name="identity_card_date" id="identity_card_date"
                                    value="{{ old('identity_card_date', $member['identity_card_date']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Place of issue Identity: *</label>
                                <input class="col-6" type="text" name="identity_card_place"
                                    id="identity_card_place"
                                    value="{{ old('identity_card_place', $member['identity_card_place']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Nationality: *</label>
                                <input class="col-6" type="text" name="nationality" id="nationality"
                                    value="{{ old('nationality', $member['nationality']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Permanent Address: *</label>
                                <input class="col-6" type="text" name="permanent_address" id="permanent_address"
                                    value="{{ old('permanent_address', $member['permanent_address']) }}">
                            </li>
                            <li class="row">
                                <label class="col-6" for="">Temporary Address: *</label>
                                <input class="col-6" type="text" name="temporary_address" id="temporary_address"
                                    value="{{ old('temporary_address', $member['temporary_address']) }}">
                            </li>

                        </ul>
                        <div class="col-6">
                            <ul>
                                <li class="row">
                                    <label class="col-6" for="">Bank Name: *</label>
                                    <input class="col-6" type="text" name="bank_name" id="bank_name"
                                        value="{{ old('bank_name', $member['bank_name']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Bank Account: *</label>
                                    <input class="col-6" type="text" name="bank_account" id="bank_account"
                                        value="{{ old('bank_account', $member['bank_account']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Marital Status: *</label>
                                    <input class="col-6" type="text" name="marital_status" id="marital_status"
                                        value="{{ old('marital_status', $member['marital_status']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Academic Level:</label>
                                    <input class="col-6" type="text" name="academic_level" id="academic_level"
                                        value="{{ old('academic_level', $member['academic_level']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Emergency Contact Name: *</label>
                                    <input class="col-6" type="text" name="emergency_contact_name"
                                        id="emergency_contact_name"
                                        value="{{ old('emergency_contact_name', $member['emergency_contact_name']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Emergency Contact Relationship: *</label>
                                    <input class="col-6" type="text" name="emergency_contact_relationship"
                                        id="emergency_contact_relationship"
                                        value="{{ old('emergency_contact_relationship', $member['emergency_contact_relationship']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Emergency Contact Number: *</label>
                                    <input class="col-6" type="text" name="emergency_contact_number"
                                        id="emergency_contact_number"
                                        value="{{ old('emergency_contact_number', $member['emergency_contact_number']) }}">
                                </li>
                                <li class="row">
                                    <label class="col-6" for="">Start Date:</label>
                                    <input class="col-6" type="text" name="start_date_official"
                                        id="start_date_official"
                                        value="{{ old('start_date_official', $member['start_date_official']) }}">
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
@endsection
@section('scripts')
    <script>
        $("#files").change(function() {
            const [file] = this.files
            var src = URL.createObjectURL(file)
            $('#preview-img').attr("src", src);
        });

        $('#cancel').click(function() {
            $('#files').val(null);
            $('#preview-img').attr("src", src);
        });
    </script>
@endsection

