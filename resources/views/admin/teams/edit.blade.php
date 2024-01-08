@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.teams.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.teams.update", [$team->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="team_name">{{ trans('cruds.teams.fields.team_name') }}</label>
                <input class="form-control {{ $errors->has('team_name') ? 'is-invalid' : '' }}" type="text"
                    name="team_name" id="team_name" value="{{ old('team_name', $team['team_name']) }}" required>
                @if($errors->has('team_name'))
                <div class="invalid-feedback">
                    {{ $errors->first('team_name') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.teams.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="teamMembers">{{ trans('cruds.teams.fields.members') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all"
                        style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all"
                        style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select onchange="validateSelectBox(this)"
                    class="form-control select2 {{ $errors->has('teamMembers') ? 'is-invalid' : '' }}"
                    name="teamMembers[]" id="teamMembers" multiple required>
                    @foreach($members as $id => $member)
                        @if(old('teamMembers') != null))))
                        <option value="{{ $member['id'] }}"
                            {{ in_array($member['id'], old('teamMembers', [])) ? 'selected' : '' }}>
                            {{ $member['full_name'] }}</option>
                        @else
                        <option value="{{ $member['id'] }}" {{ $team->members->contains($member['id']) ? 'selected' : '' }}>
                            {{ $member['full_name'] }}</option>
                        @endif
                    @endforeach
                </select>
                @if($errors->has('teamMembers'))
                <div class="invalid-feedback">
                    {{ $errors->first('teamMembers') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.teams.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="members">{{ trans('cruds.teams.fields.leader_id') }}</label>
                <select id="result" class="form-control select" name="leader_id">
                    @foreach($team->members as $id => $member)
                    <option value="{{ $member->id }}" {{ $team['leader_id'] == $member->id ? 'selected' : '' }}>
                        {{ $member->full_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('leader_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('leader_id') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.teams.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="members">{{ trans('cruds.teams.fields.status') }}</label>
                <select class="form-control select" name="status">
                    @foreach($listStatus as $id => $listStatus)
                    <option value="{{ $id }}" {{ (collect(old('status'))->contains($id)) ? 'selected':'' }}>
                        {{ $listStatus }}</option>
                    @endforeach
                </select>
                <span class="help-block">{{ trans('cruds.teams.fields.title_helper') }}</span>
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
@section('scripts')
<script>
function validateSelectBox(obj) {
    // Lấy danh sách các options
    var options = obj.children;

    // lưu dạng object
    var obj = {};

    var html = '';

    // Lặp qua từng option
    for (var i = 0; i < options.length; i++) {
        // Nếu option đang được chọn
        if (options[i].selected) {
            // Thêm vào biến lưu trữ object
            obj[options[i].value] = options[i].text;
            html += '<option value=" ' + options[i].value + ' "> ' + options[i].text + ' </option>';

        }
    }
    // lưu dữ liệu vào storage
    localStorage.setItem('obj', JSON.stringify(obj));

    // Hiển thị lên select box đa chọn
    document.getElementById('result').innerHTML = html;
};

// check xem storage có dữ liệu không
if (localStorage.getItem('obj')) {

    // Biến lưu trữ các chuyên mục đa chọn
    var html = '';

    // Lấy dữ liệu từ storage 
    var retrievedObject = localStorage.getItem('obj');

    // Chuyển dữ liệu từ storage thành object
    var obj = JSON.parse(retrievedObject);

    // Lặp qua từng option
    for (var key in obj) {
        // Nếu dữ liệu đã tồn tại
        if (obj.hasOwnProperty(key)) {
            // Thêm vào html
            html += '<option value="' + key + '">' + obj[key] + '</option>';
        }
    }

    // Hiển thị lên select box đa chọn
    document.getElementById('result').innerHTML = html;
}
</script>

@endsection