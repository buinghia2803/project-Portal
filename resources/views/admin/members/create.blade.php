@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.members.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.members.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class='required' for="member_code">{{ trans('cruds.members.fields.member_code') }}</label>
                <input class="form-control {{ $errors->has('member_code') ? 'is-invalid' : '' }}" type="number" name="member_code" id="member_code" value="{{ old('member_code', '') }}" required>
                @if($errors->has('member_code'))
                <div class="invalid-feedback">
                    {{ $errors->first('member_code') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="full_name">{{ trans('cruds.members.fields.full_name') }}</label>
                <input class="form-control {{ $errors->has('full_name') ? 'is-invalid' : '' }}" type="text" name="full_name" id="full_name" value="{{ old('full_name', '') }}" required>
                @if($errors->has('full_name'))
                <div class="invalid-feedback">
                    {{ $errors->first('full_name') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="email">{{ trans('cruds.members.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}" required>
                @if($errors->has('email'))
                <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.members.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="other_email">{{ trans('cruds.members.fields.other_email') }}</label>
                <input class="form-control {{ $errors->has('other_email') ? 'is-invalid' : '' }}" type="email" name="other_email" id="other_email" value="{{ old('other_email', '') }}" required>
                @if($errors->has('other_email'))
                <div class="invalid-feedback">
                    {{ $errors->first('other_email') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="phone">{{ trans('cruds.members.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="tel" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                @if($errors->has('phone'))
                <div class="invalid-feedback">
                    {{ $errors->first('phone') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="gender">{{ trans('cruds.members.fields.gender') }}</label>
                <div>
                    <input class="form-check form-check-inline {{ $errors->has('gender') ? 'is-invalid' : '' }}" type="radio" name="gender" id="male" value="0">Male
                    <input class="form-check form-check-inline {{ $errors->has('gender') ? 'is-invalid' : '' }}" type="radio" name="gender" id="female" value="1">Female
                </div>
                @if($errors->has('gender'))
                <div class="invalid-feedback">
                    {{ $errors->first('gender') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="marital_status">{{ trans('cruds.members.fields.marital_status') }}</label>
                <select class="form-control {{ $errors->has('marital_status') ? 'is-invalid' : '' }}" name="marital_status" id="marital_status" required>
                    @foreach ($maritalStatus as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('marital_status'))
                <div class="invalid-feedback">
                    {{ $errors->first('marital_status') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="avatar">{{ trans('cruds.members.fields.avatar') }}</label>
                <input class="form-control {{ $errors->has('avatar') ? 'is-invalid' : '' }}" type="file" name="file_avatar" id="avatar" value="{{ old('avatar', '') }}" >
                @if($errors->has('avatar'))
                <div class="invalid-feedback">
                    {{ $errors->first('avatar') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="birth_date">{{ trans('cruds.members.fields.birth_date') }}</label>
                <input class="form-control {{ $errors->has('birth_date') ? 'is-invalid' : '' }}" type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', '') }}" required>
                @if($errors->has('birth_date'))
                <div class="invalid-feedback">
                    {{ $errors->first('birth_date') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="permanent_address">{{ trans('cruds.members.fields.permanent_address') }}</label>
                <input class="form-control {{ $errors->has('permanent_address') ? 'is-invalid' : '' }}" type="text" name="permanent_address" id="permanent_address" value="{{ old('permanent_address', '') }}" required>
                @if($errors->has('permanent_address'))
                <div class="invalid-feedback">
                    {{ $errors->first('permanent_address') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="temporary_address">{{ trans('cruds.members.fields.temporary_address') }}</label>
                <input class="form-control {{ $errors->has('temporary_address') ? 'is-invalid' : '' }}" type="text" name="temporary_address" id="temporary_address" value="{{ old('temporary_address', '') }}" required>
                @if($errors->has('temporary_address'))
                <div class="invalid-feedback">
                    {{ $errors->first('temporary_address') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="identity_number">{{ trans('cruds.members.fields.identity_number') }}</label>
                <input class="form-control {{ $errors->has('identity_number') ? 'is-invalid' : '' }}" type="number" name="identity_number" id="identity_number" value="{{ old('identity_number', '') }}" required>
                @if($errors->has('identity_number'))
                <div class="invalid-feedback">
                    {{ $errors->first('identity_number') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="identity_card_date">{{ trans('cruds.members.fields.identity_card_date') }}</label>
                <input class="form-control {{ $errors->has('identity_card_date') ? 'is-invalid' : '' }}" type="date" name="identity_card_date" id="identity_card_date" value="{{ old('identity_card_date', '') }}" required>
                @if($errors->has('identity_card_date'))
                <div class="invalid-feedback">
                    {{ $errors->first('identity_card_date') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="identity_card_place">{{ trans('cruds.members.fields.identity_card_place') }}</label>
                <input class="form-control {{ $errors->has('identity_card_place') ? 'is-invalid' : '' }}" type="text" name="identity_card_place" id="identity_card_place" value="{{ old('identity_card_place', '') }}" required>
                @if($errors->has('identity_card_place'))
                <div class="invalid-feedback">
                    {{ $errors->first('identity_card_place') }}
                </div>
                @endif
            </div>
          
            <div class="form-group">
                <label class='required' for="nationality">{{ trans('cruds.members.fields.nationality') }}</label>
                <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', '') }}" required>
                @if($errors->has('nationality'))
                <div class="invalid-feedback">
                    {{ $errors->first('nationality') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="emergency_contact_name">{{ trans('cruds.members.fields.emergency_contact_name') }}</label>
                <input class="form-control {{ $errors->has('emergency_contact_name') ? 'is-invalid' : '' }}" type="text" name="emergency_contact_name" id="emergency_contact_name" value="{{ old('emergency_contact_name', '') }}" required>
                @if($errors->has('emergency_contact_name'))
                <div class="invalid-feedback">
                    {{ $errors->first('emergency_contact_name') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="emergency_contact_relationship">{{ trans('cruds.members.fields.emergency_contact_relationship') }}</label>
                <input class="form-control {{ $errors->has('emergency_contact_relationship') ? 'is-invalid' : '' }}" type="text" name="emergency_contact_relationship" id="emergency_contact_relationship" value="{{ old('emergency_contact_relationship', '') }}" required>
                @if($errors->has('emergency_contact_relationship'))
                <div class="invalid-feedback">
                    {{ $errors->first('emergency_contact_relationship') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="emergency_contact_number">{{ trans('cruds.members.fields.emergency_contact_number') }}</label>
                <input class="form-control {{ $errors->has('emergency_contact_number') ? 'is-invalid' : '' }}" type="tel" name="emergency_contact_number" id="emergency_contact_number" value="{{ old('emergency_contact_number', '') }}" required>
                @if($errors->has('emergency_contact_number'))
                <div class="invalid-feedback">
                    {{ $errors->first('emergency_contact_number') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="academic_level">{{ trans('cruds.members.fields.academic_level') }}</label>
                <input class="form-control {{ $errors->has('academic_level') ? 'is-invalid' : '' }}" type="text" name="academic_level" id="academic_level" value="{{ old('academic_level', '') }}">
                @if($errors->has('academic_level'))
                <div class="invalid-feedback">
                    {{ $errors->first('academic_level') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="bank_name">{{ trans('cruds.members.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', '') }}" required>
                @if($errors->has('bank_name'))
                <div class="invalid-feedback">
                    {{ $errors->first('bank_name') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="bank_account">{{ trans('cruds.members.fields.bank_account') }}</label>
                <input class="form-control {{ $errors->has('bank_account') ? 'is-invalid' : '' }}" type="number" name="bank_account" id="bank_account" value="{{ old('bank_account', '') }}" required>
                @if($errors->has('bank_account'))
                <div class="invalid-feedback">
                    {{ $errors->first('bank_account') }}
                </div>
                @endif
            </div>
            
            <div class="form-group">
                <label for="tax_place">{{ trans('cruds.members.fields.tax_place') }}</label>
                <input class="form-control {{ $errors->has('tax_place') ? 'is-invalid' : '' }}" type="text" name="tax_place" id="tax_place" value="{{ old('tax_place', '') }}">
                @if($errors->has('tax_place'))
                <div class="invalid-feedback">
                    {{ $errors->first('tax_place') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="start_date_official">{{ trans('cruds.members.fields.start_date_official') }}</label>
                <input class="form-control {{ $errors->has('start_date_official') ? 'is-invalid' : '' }}" type="date" name="start_date_official" id="start_date_official" value="{{ old('start_date_official', '') }}">
                @if($errors->has('start_date_official'))
                <div class="invalid-feedback">
                    {{ $errors->first('start_date_official') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class='required' for="status">{{ trans('cruds.members.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    @foreach ($status as $key => $item)
                    <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                <div class="invalid-feedback">
                    {{ $errors->first('status') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.members.fields.note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{!! old('note') !!}</textarea>
                @if($errors->has('note'))
                <div class="invalid-feedback">
                    {{ $errors->first('note') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.members.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                    <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                <div class="invalid-feedback">
                    {{ $errors->first('roles') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="division">{{ trans('cruds.members.fields.division') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('division') ? 'is-invalid' : '' }}" name="division[]" id="division" required>
                    @foreach($divisions as $id => $item)
                    <option value="{{ $id }}" {{ in_array($id, old('division', [])) ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('division'))
                <div class="invalid-feedback">
                    {{ $errors->first('division') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="team">{{ trans('cruds.members.fields.team') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('team') ? 'is-invalid' : '' }}" name="teams[]" id="team" required>
                    @foreach($teams as $id => $item)
                    <option value="{{ $id }}" {{ in_array($id, old('team', [])) ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('team'))
                <div class="invalid-feedback">
                    {{ $errors->first('team') }}
                </div>
                @endif
            </div>
            <div class="form-group">
                <label class="required" for="shift">{{ trans('cruds.members.fields.shift') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('shift') ? 'is-invalid' : '' }}" name="shift[]" id="shift" required>
                    @foreach($shifts as $id => $item)
                    <option value="{{ $id }}" {{ in_array($id, old('shift', [])) ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
                @if($errors->has('shift'))
                <div class="invalid-feedback">
                    {{ $errors->first('shift') }}
                </div>
                @endif
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection