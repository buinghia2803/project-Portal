@extends('layouts.fe')
@section('content')
    <fieldset class="border p-2 mb-3">
        <legend class="float-none w-auto p-2">My Timesheet</legend>
        <div class="container">
            <div class="row">
                <form action="" class="row col-8">
                    <div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <label for="" class="col-6">Filter by month</label>
                                <input class="form-control" name="month" type="month" min="2016-01" style="width: 180px"
                                    value="{{ Request::get('month') }}">
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center">
                            <label class="col-6" for="">Sort by work date</label>
                            <select name="sort" class="form-select col-6" style="width: 150px">
                                <option>Choose Sort</option>
                                <option value="asc">Asc</option>
                                <option value="desc">Desc</option>
                            </select>
                        </div>
                        <div style="margin-left: 130px; margin-top: 10px">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
                <div class="col-4">
                    <div class="row">
                        <span class="col-8">Late time on month:</span>
                        <div class="col-4">{{ $totalLateTime }}</div>
                    </div>
                    <div class="row">
                        <span class="col-8">Late day on month:</span>
                        <div class="col-4">{{ $totalLateDay }}</div>
                    </div>
                    <div class="row">
                        <span class="col-8">Early time on month:</span>
                        <div class="col-4">{{ $totalEarlyTime }}</div>
                    </div>
                    <div class="row">
                        <span class="col-8">Early day on month:</span>
                        <div class="col-4">{{ $totalEarlyDay }}</div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="container" style="padding: 0">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Date</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Late</th>
                    <th scope="col">Early</th>
                    <th scope="col">In Office</th>
                    <th scope="col">Ot</th>
                    <th scope="col">Work Time</th>
                    <th scope="col">Lack</th>
                    <th scope="col">Note</th>
                    <th scope="col" class="d-flex justify-content-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($timeSheets as $key => $item)
                    <tr>
                        <th>{{ $item['id'] }}
                        </th>
                        <td>{{ $item['work_date'] }}</td>
                        <td>{{ isset($item['checkin']) ? date('H:i', strtotime($item['checkin'])) : date('H:i', strtotime($item['checkin_original'])) ?? '' }}
                        </td>
                        <td>{{ isset($item['checkout']) ? date('H:i', strtotime($item['checkout'])) : date('H:i', strtotime($item['checkout_original'])) ?? '' }}
                        </td>
                        <th>{{ $item['late'] }}</th>
                        <td>{{ $item['early'] }}</td>
                        <td>{{ $item['in_office'] }}</td>
                        <td>{{ $item['ot_time'] }}</td>
                        <td>{{ $item['work_time'] }}</td>
                        <td>{{ $item['lack'] }}</td>
                        <td>{{ $item['note'] }}</td>
                        <td style="width: 100px">
                            <div>
                                <button style="border: none; background-color: white; color: #0a97e0;"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal-Forgot-{{ $item['id'] }}"
                                    id="forgot">Forgot</button>
                                <button style="border: none; background-color: white; color: #0a97e0;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-LateEarly-{{ $item['id'] }}">Late/Early</button>
                            </div>
                            <div>
                                <button style="border: none; background-color: white; color: #0a97e0;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-Leave-{{ $item['id'] }}">Leave</button>
                                <br>
                                <button style="border: none; background-color: white; color: #0a97e0;"
                                    data-bs-toggle="modal" data-bs-target="#exampleModal-OT-{{ $item['id'] }}"
                                    id="requestOtBtn">OT</button>
                            </div>
                        </td>
                        @php
                            $dataRequestForgot = collect($item->request)
                                ->where('request_type', 1)
                                ->first();
                            $dataRequestLate = collect($item->request)
                                ->where('request_type', 4)
                                ->first();
                            $dataLeave = collect($item->request)
                                ->whereBetween('request_type', [2, 3])
                                ->first();
                            $dataOT = collect($item->request)
                                ->where('request_type', 5)
                                ->first();
                            
                            // dd($dataLeave);
                            // cal late early
                            $timeCheckIn = date('H:i', strtotime($item['checkin_original']));
                            $timeCheckOut = date('H:i', strtotime($item['checkout_original']));
                            
                            $explodeTimeLate = explode(':', $item['late'] ?? '00:00');
                            $explodeTimeEarly = explode(':', $item['early'] ?? '00:00');
                            
                            $totalHour = $explodeTimeEarly[0] + $explodeTimeLate[0];
                            $totalMinute = $explodeTimeEarly[1] + $explodeTimeLate[1];
                            
                            if ($totalMinute > 60 && isset($totalMinute)) {
                                $totalHour += 1;
                                $totalMinute = $totalMinute - 60;
                                $timeRequest = ($totalHour < 10 ? '0' . $totalHour : $totalHour) . ':' . ($totalMinute < 10 ? '0' . $totalMinute : $totalMinute);
                            }
                            $timeRequest = ($totalHour < 10 ? '0' . $totalHour : $totalHour) . ':' . ($totalMinute < 10 ? '0' . $totalMinute : $totalMinute);
                            $d = strtotime('18:00');
                            $timeOt = date('H:i', $d);
                            $explodeTimeCheckOut = explode(':', $timeCheckOut);
                            $explodeTimeOt = explode(':', $timeOt);
                            $actualTime = '00:00';
                            $explodeActualTime = explode(':', $actualTime);
                            
                            if ($explodeTimeCheckOut[0] >= 18) {
                                $totalHourOt = $explodeTimeCheckOut[0] - $explodeTimeOt[0];
                                $totalMinuteOt = $explodeTimeCheckOut[1] - $explodeTimeOt[1];
                                $actualTime = ($totalHourOt < 10 ? '0' . $totalHourOt : $totalHourOt) . ':' . ($totalMinuteOt < 10 ? '0' . $totalMinuteOt : $totalMinuteOt);
                                $explodeActualTime = explode(':', $actualTime);
                            }
                            
                        @endphp
                        @include('front-end.timesheet.ModalForgot', [
                            'request' => $dataRequestForgot,
                        ])
                        @include('front-end.timesheet.ModalLateEarly', [
                            'work_sheet' => $item,
                            'request' => $dataRequestLate,
                            'check_in' => $timeCheckIn,
                            'check_out' => $timeCheckOut,
                            'late' => $item['late'],
                            'early' => $item['early'],
                            'timeRequest' => $timeRequest,
                        ])
                        @include('front-end.timesheet.ModalLeave', [
                            'request' => $dataLeave,
                            'check_in' => $timeCheckIn,
                            'check_out' => $timeCheckOut,
                            'work_time' => $item['work_time'],
                            'lack_time' => $item['lack'],
                        ])
                        @include('front-end.timesheet.ModalOT', [
                            'request' => $dataOT,
                            'check_in' => $timeCheckIn,
                            'check_out' => $timeCheckOut,
                            'ot_time' => $item['ot_time'],
                            'actualTime' => $actualTime,
                            'explodeActualTime' => $explodeActualTime,
                        ])
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $timeSheets->appends(Request::all())->links('pagination::bootstrap-4') !!}
    </div>
@endsection
@section('scripts')
    <script>
        // Late Early
        $("#compensation_date").change(function() {
            var token = $('meta[name="csrf-token"]').attr('content');
            const compensation_date = $(this).val()
            $.ajax({
                type: "POST",
                url: "{{ route('user.getOverTime') }}",
                data: {
                    compensation_date,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(res) {
                    if (res.overTime) {
                        const overTime = res.overTime;
                        $('#over_time').html(overTime);
                        const compensationTime = $('#compensation_time').val(overTime);
                        const timeRequest = $('#time_request').val();
                        const convertTimeRequest = timeRequest.split(":");
                        const convertCompensationTime = overTime.split(":");
                        if (convertCompensationTime[1] < convertTimeRequest[1]) {
                            $('.removeClass').addClass('d-none')
                        } else {
                            $('.removeClass').removeClass('d-none')
                        }
                    }
                }
            });
        });
        $('#leave_end').attr('disabled', true);
        // Leave
        $('#leave_end').on('blur', function(e) {
            let inputLeaveEnd = e.target.value;
            var startTime = $('#leave_start').val();
            $('#filter-time-error').text('');

            const convertInputLeaveEnd = inputLeaveEnd.split(":");
            const convertStartTime = startTime.split(":");

            if (inputLeaveEnd && startTime && startTime > inputLeaveEnd) {
                $('#filter-time-error').text('thoi gian bat dau phai nho hon thoi gian ket thuc');
                $('#leave_end').val('');
                $('#leave_start').val('');
                $('#timeCount').html('');
                $('#leave_time').val('');
            }
            if (convertInputLeaveEnd[0] > convertStartTime[0]) {

                const totalTimeCountHour = convertInputLeaveEnd[0] - convertStartTime[0];

                const totalTimeCountMinutes = convertInputLeaveEnd[1] - convertStartTime[1];

                if (totalTimeCountMinutes < 0) {
                    totalTimeCountMinutes = 0
                }

                if (totalTimeCountHour > 8) {
                    $('#checkAllDay').attr('checked', 'checked')
                    $('#timeCount').html('08:00')
                    $('#leave_end').val('');
                    $('#leave_start').val('');
                    $('#leave_end , #leave_start').attr('disabled', true);
                } else {
                    let totalTimeCount = '0' + totalTimeCountHour + ':' + (totalTimeCountMinutes < 10 ?
                        '0' + totalTimeCountMinutes : totalTimeCountMinutes);
                    $('#timeCount').html(totalTimeCount)
                    $('#leave_time').val(totalTimeCount)
                }
            }
        });

        $('#leave_start').on('blur', function(e) {
            $('#leave_end').removeAttr('disabled');
        });

        $('#checkAllDay').change(function() {
            if ($('#checkAllDay').is(":checked")) {
                $('#leave_end , #leave_start').attr('disabled', true);
                $('#timeCount').html('08:00')
                $('#leave_time').val('08:00')
            } else {
                $('#leave_start').removeAttr('disabled');
                $('#leave_end').attr('disabled', true);
                $('#timeCount').html('')
            };
        })

        if ($('#checkbox').is(':checked')) {
            $('#error_count').val('0')
        } else {
            $('#error_count').val('1')
        }

        $('#checkbox').change(function() {
            if ($('#checkbox').is(':checked')) {
                $('#error_count').val('0')
            } else {
                $('#error_count').val('1')
            }
        })

        $('#requestOtBtn').click(function() {
            const timeOt = $('#timeOt').val();
            const actualTime = $('#actualTime').val();
            const convertTimeOt = timeOt.split(":");
            const convertActualTime = actualTime.split(":");
            console.log(convertTimeOt[1])
            console.log(convertActualTime[1])
            if (convertTimeOt[0] >= convertActualTime[0] && convertTimeOt[1] > convertActualTime[1]) {
                console.log('abbab');
                $('#timeOt').val('');
                $('#filter-time-error-ot').html('Request Ot Time Not Bigger Actual Time');
            }
        });

        $('#timeOt').change(function() {
            const timeOt = $('#timeOt').val();
            const actualTime = $('#actualTime').val();
            const convertTimeOt = timeOt.split(":");
            const convertActualTime = actualTime.split(":");

            if (convertTimeOt[0] > convertActualTime[0] && convertTimeOt[1] > convertActualTime[1]) {
                $('#timeOt').val('');
                $('#filter-time-error-ot').html('Request Ot Time Not Bigger Actual Time');
            } else {
                $('#filter-time-error-ot').html('');
            }
        })
        $('input[type=radio][name=request_type]').change(function() {
            if (this.value == '2') {} else if (this.value == '3') {}
        });

    </script>
@endsection
