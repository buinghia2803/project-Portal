<div class="modal fade" id="exampleModal-Leave-{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register Leave</h5>
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
                            <input class="form-control col-9" type="hidden" disabled style="width: 135px"
                                value="{{ date('Y-m-d') }}">
                        </li>
                        <li class="d-flex mb-3">
                            <label class="form-label col-3" for="">Register for date:</label>
                            <span>{{ $item->work_date }}</span>
                            <input class="form-control col-9" type="hidden" style="width: 135px"
                                value="{{ $item->work_date }}">
                        </li>
                        <li class="mb-3 d-flex">
                            <div class="d-flex" style="width: 50%; height: 38px;">
                                <label class="form-label " style="width: 159px" for="">Check-in:(*)</label>
                                <span>{{ $check_in }}</span>
                                {{-- <input class="form-control" type="text" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_in'])) : '' }}"> --}}
                            </div>
                            <div class="d-flex" style="width: 50%;margin-left: 40px; height: 38px;">
                                <label class="form-label" style="width: 120px" for="">Check-out:(*)</label>
                                <span>{{ $check_out }}</span>
                                {{-- <input class="form-control" type="text" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_out'])) : '' }}"> --}}
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <div class="d-flex" style="width: 50%; height: 38px;">
                                <label class="form-label " style="width: 159px" for="">Work
                                    Time</label>
                                <span>{{ $work_time }}</span>
                                <input class="form-control" type="hidden" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? $work_time : '' }}">
                            </div>
                            <div class="d-flex" style="width: 50%;margin-left: 40px; height: 38px;">
                                <label class="form-label" style="width: 120px" for="">Lack
                                    Time</label>
                                <span>{{ $lack_time }}</span>
                                <input class="form-control" type="hidden" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? $lack_time : '' }}">
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <input type="checkbox" id="checkAllDay" class="px-2" name="leave_all_day"
                                        value="1"
                                        {{ isset($request['id']) && $request['leave_all_day'] == 1 ? 'checked' : '' }}>
                                    <span for="" class="px-2">Leave All Day</span>
                                </div>
                                <div>
                                    <input type="radio" class="radio-input" name="request_type" value="2"
                                        class="px-2"
                                        {{ isset($request['request_type']) && $request['request_type'] == 2 ? 'checked' : '' }}>
                                    <span class="px-2">Paid</span>
                                    <input type="radio" class="radio-input" name="request_type" value="3" checked
                                        class="px-2">
                                    <span class="px-2">Unpaid</span>
                                    <span class="px-2">|</span>
                                    <span class="px-2">Time count:</span>
                                    <span class="px-2 text-danger"
                                        id="timeCount">{{ isset($request['leave_time']) && $request['leave_time'] ? $request['leave_time'] : '00:00' }}</span>
                                    <input type="hidden" name="leave_time" id="leave_time">
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <label class="form-label col-3" for="" style="width: 152px">Range</label>
                                <input class="form-control col-3" id="leave_start" name="leave_start" type="time"
                                    style="width: 135px"
                                    {{ isset($request['leave_all_day']) && $request['leave_all_day'] == 1 ? 'disabled' : '' }}
                                    value="{{ isset($request['leave_start']) && $request['leave_start'] ? $request['leave_start'] : '' }}">
                                <span style="display: flex; align-items: center; padding: 0px 5px">~</span>
                                <input class="form-control col-3" id="leave_end" name="leave_end" type="time"
                                    style="width: 135px"
                                    value="{{ isset($request['leave_end']) && $request['leave_end'] ? $request['leave_end'] : '' }}">
                            </div>
                            <div class="error-valid text-danger" id="filter-time-error"></div>
                        </li>
                        <li class="row mb-3">
                            <label class="form-label col-3" for="">Reason:</label>
                            <textarea class="form-control col-8" name="reason" id="" cols="20" rows="5" style="width: 375px">{{ isset($request['reason']) && $request['reason'] ? $request['reason'] : '' }}</textarea>
                        </li>
                        <input type="hidden" name="request_for_date" value="{{ $item->work_date }}">
                    </ul>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type=" button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close</button>
                    <button type="submit"
                        class="btn btn-primary">{{ isset($request['id']) && $request['id'] ? 'Update' : 'Register' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
