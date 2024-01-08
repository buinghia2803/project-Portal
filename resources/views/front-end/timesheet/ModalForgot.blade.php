 <!-- Modal Forgot-->
 <div class="modal fade" id="exampleModal-Forgot-{{ $item['id'] }}" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">

     <div class="modal-dialog" style="max-width: 700px;">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Register Forgot
                     Checkin/Checkout
                 </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>

             <form
                 action="{{ isset($request['id']) && $request['id'] ? route('user.timesheet.update', $request['id']) : route('user.timesheet.store') }}"
                 method="POST" id="create_request_form">
                 @if (isset($request['id']))
                     @method('PUT')
                 @endif
                 @csrf
                 <div class="modal-body">
                     @if ($errors->count() > 0)
                         <div class="alert alert-danger">
                             <ul class="list-unstyled">
                                 @foreach ($errors->all() as $error)
                                     <li>{{ $error }}</li>
                                 @endforeach
                             </ul>
                         </div>
                     @endif
                     <ul>
                         <li class="d-flex mb-3">
                             <label class="form-label col-4" for="">Registration date:</label>
                             <span>{{ date('Y-m-d') }}</span>
                             {{-- <input class="form-control col-8" type="text" disabled style="width: 250px"
                                 value=""> --}}
                         </li>
                         <li class="d-flex mb-3">
                             <label class="form-label col-4" for="">Register for date:</label>
                             <span>{{ $item->work_date }}</span>
                             {{-- <input class="form-control col-8" type="text" style="width: 250px" disabled
                                 value="{{ $item->work_date }}"> --}}
                         </li>
                         <li class="row mb-3">
                             <label class="form-label col-4" for="">Check-in:(*)</label>
                             @if (isset($request['request_for_date']) && $request['request_for_date'] != null)
                                 <input class="form-control col-8" type="time" style="width: 250px" name="check_in"
                                     value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_in'])) : '' }}"
                                     {{ isset($request['status']) && $request['status'] == 2 ? 'disabled' : '' }}>
                             @else
                                 <input type="time" name="check_in" id="" class="form-control col-8" type="text"
                                     style="width: 250px"
                                     value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_in'])) : '' }}">
                             @endif
                             @if ($errors->has('check_in'))
                                 <div class="invalid-feedback">
                                     {{ $errors->first('check_in') }}
                                 </div>
                             @endif
                         </li>
                         <li class="row mb-3">
                             <label class="form-label col-4" for="">Check-out:(*)</label>
                             @if (isset($request['request_for_date']) && $request['request_for_date'] != null)
                                 <input class="form-control col-8" type="time" style="width: 250px" name="check_out"
                                     value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_out'])) : '' }}"
                                     {{ isset($request['status']) && $request['status'] == 2 ? 'disabled' : '' }}>
                             @else
                                 <input type="time" name="check_out" id="" class="form-control col-8" type="text"
                                     style="width: 250px"
                                     value="{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? date('H:i', strtotime($request['check_out'])) : '' }}">
                             @endif
                             @if ($errors->has('check_out'))
                                 <div class="invalid-feedback">
                                     {{ $errors->first('check_out') }}
                                 </div>
                             @endif
                         </li>
                         <li class="mb-3">
                             <label class="form-label col-4" for="">Special reason</label>
                             <input type="checkbox" id="checkbox"
                                 {{ isset($request['error_count']) && $request['error_count'] == 0 ? 'checked' : '' }}>
                             <input type="hidden" name="error_count" id="error_count" value="">
                             <label for="">Not counted as an error</label>
                         </li>
                         <li class="row mb-3">
                             <label class="form-label col-4" for="">Reason:</label>
                             <textarea class="form-control col-8" name="reason" id="" cols="20" rows="5"
                                 {{ isset($request['status']) && $request['status'] == 2 ? 'disabled' : '' }} style="width: 250px">{{ isset($request['request_for_date']) && $request['request_for_date'] != null ? $request['reason'] : '' }}</textarea>
                             @if ($errors->has('reason'))
                                 <div class="invalid-feedback">
                                     {{ $errors->first('reason') }}
                                 </div>
                             @endif
                         </li>
                         @if (isset($request['status']) && $request['status'] == 2)
                             <li class="d-flex mb-3">
                                 <label class="form-label col-4" for="">Status:</label>
                                 <span>Approved</span>
                             </li>
                         @endif
                         <input type="hidden" value="1" name="request_type">
                         <input type="hidden" value="{{ $item->work_date }}" name="request_for_date">
                     </ul>
                 </div>
                 <div class="modal-footer d-flex justify-content-center">
                     @if (empty($request['status']))
                         <button type="submit" id=""
                             class="btn btn-primary">{{ isset($request['id']) && $request['id'] ? 'Update' : 'Register' }}</button>
                     @endif
                 </div>
             </form>
             @if (isset($request['status']) && $request['status'] == 2)
                 <button type=" button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
             @endif

         </div>
     </div>
 </div>
