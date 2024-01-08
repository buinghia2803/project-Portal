<div class="modal fade" id="exampleModal-LateEarly-{{ $item['id'] }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register Late/Early</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ isset($request['id']) && $request['id'] ? route('user.timesheet.update', $request['id']) : route('user.timesheet.store') }}"
                method="post" id="create_request_form">
                @if (isset($request['id']))
                    @method('PUT')
                @endif
                @csrf
                @if ($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="modal-body ">
                    <ul>
                        <li class="d-flex mb-3">
                            <label class="form-label col-3" for="">Registration date:</label>
                            <span>{{ date('Y-m-d') }}</span>
                            {{-- <input class="form-control col-9" type="text" disabled style="width: 135px"
                                value="{{ date('Y-m-d') }}"> --}}
                        </li>
                        <li class="d-flex mb-3">
                            <label class="form-label col-3" for="">Register for date:</label>
                            <span>{{ $item->work_date }}</span>

                        </li>
                        <li class="mb-3 d-flex">
                            <div class="d-flex" style="width: 50%; height: 38px;">
                                <label class="form-label" style="width: 160px;" for="">Check-in:(*)</label>
                                <span>{{ $check_in }}</span>
                                {{-- <input class="form-control" type="text" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_in'])) : '' }}" hidden> --}}
                            </div>
                            <div class="d-flex" style="width: 50%;margin-left: 40px; height: 38px;">
                                <label class="form-label" style="width: 120px;" for="">Check-out:(*)</label>
                                <span>{{ $check_out }}</span>
                                {{-- <input class="form-control" type="text" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_out'])) : '' }}" hidden> --}}
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <div class="d-flex" style="width: 50%; height: 38px;">
                                <label class="form-label " style="width: 160px;" for="">Late
                                    Time</label>
                                <span>{{ $late }}</span>
                            </div>
                            <div class="d-flex" style="width: 50%;margin-left: 40px; height: 38px;">
                                <label class="form-label" style="width: 120px;" for="">Early
                                    Time</label>
                                <span>{{ $early }}</span>
                            </div>
                        </li>
                        <li class="row mb-3">
                            <label class="form-label col-3" for="">Date cover up:(*)</label>
                            <input class="form-control col-3" type="date" name="compensation_date"
                                id="compensation_date" style="width: 205px"
                                value="{{ isset($request['compensation_date']) && $request['compensation_date'] ? $request['compensation_date'] : '' }}">
                        </li>
                        <li class="d-flex mb-3">
                            <label class="form-label col-3" for="">Over Time: </label>
                            <span name=""
                                id="over_time">{{ isset($request['compensation_time']) && $request['compensation_time'] ? $request['compensation_time'] : '00:00' }}</span>
                            <input type="hidden" name="compensation_time" id="compensation_time"
                                value="{{ isset($request['compensation_time']) && $request['compensation_time'] ? $request['compensation_time'] : '00:00' }}">
                        </li>
                        <li class="d-flex mb-3">
                            <label class="form-label col-3" for="">Time Request:</label>
                            <span>{{ $timeRequest }}</span>
                            <input type="hidden" id="time_request" value="{{ $timeRequest }}">
                        </li>
                        <li class="row mb-3">
                            <label class="form-label col-3" for="">Reason:</label>
                            <textarea class="form-control col-8" name="reason" id="" cols="20" rows="5" style="width: 375px">{{ isset($request['reason']) && $request['reason'] ? $request['reason'] : '' }}</textarea>
                        </li>
                    </ul>
                    <input type="hidden" name="request_for_date" value="{{ $item->work_date }}">
                    <input type="hidden" value="4" name="request_type">
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close</button>
                    <button type="submit"
                        class="btn btn-primary removeClass">{{ isset($request['id']) && $request['id'] ? 'Update' : 'Register' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
