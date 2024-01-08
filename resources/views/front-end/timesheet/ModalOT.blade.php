<div class="modal fade" id="exampleModal-OT-{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register OT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form
                action="{{ isset($request['id']) && $request['id'] ? route('user.timesheet.update', $request['id']) : route('user.timesheet.store') }}"
                method="post" id="create_request_form">
                @if (isset($request['id']))
                    @method('PUT')
                @endif
                @csrf
                @if($errors->count() > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach($errors->all() as $error)
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
                        </li>
                        <li class="d-flex mb-3">
                            <label class="form-label col-3" for="">Register for date:</label>
                            <span>{{ $item->work_date }}</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <div class="d-flex" style="width: 50%; height: 38px;">
                                <label class="form-label " style="width: 159px" for="">Check-in:(*)</label>
                                <span>{{ $check_in }}</span>
                                {{-- <input class="form-control" type="text" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? $checkin : '' }}"> --}}
                            </div>
                            <div class="d-flex" style="width: 50%;margin-left: 40px; height: 38px;">
                                <label class="form-label" style="width: 120px" for="">Check-out:(*)</label>
                                <span>{{ $check_out }}</span>
                                {{-- <input class="form-control" type="text" style="width: 70px"
                                    value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? $checkout : '' }}"> --}}
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="row" style="width: 50%; height: 38px;">
                                <label class="form-label " style="width: 159px" for="">Request
                                    OT:</label>
                                <input class="form-control" type="time" style="width: 135px" id="timeOt"
                                    name="request_ot_time"
                                    value="{{ isset($request['request_type']) && $request['request_type'] == 5 ? $request['request_ot_time'] : '' }}">
                            </div>
                            <div id="filter-time-error-ot" class="error-valid text-danger" style="margin-left: 145px;margin-top: 10px;" ></div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex">
                                <label class="form-label col-3" for="">Actual Overtime:</label>
                                <span>{{ $actualTime }}</span>
                                <input type="hidden" name="" id="actualTime" value="{{ $actualTime }}">
                            </div>
                        </li>
                        <li class="row mb-3">
                            <label class="form-label col-3" for="">Reason:</label>
                            <textarea class="form-control col-8" name="reason" id="" cols="20" rows="5" style="width: 375px">{{ isset($request['request_type']) && $request['request_type'] == 5 ? $request['reason'] : '' }}
                            </textarea>
                        </li>
                        <input type="hidden" name="request_for_date" value="{{ $item->work_date }}">
                        <input type="hidden" value="5" name="request_type">
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
