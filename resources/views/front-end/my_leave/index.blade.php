@extends('layouts.fe')
@section('content')
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <span class="mb-1">{{ $message }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <fieldset class="border p-2 mb-3">
        <legend class="float-none w-auto p-2">My Leave</legend>
        <div class="container">
            <div class="row">
                <div class="col-6 ">
                    <form action="" class="mb-5">
                        <div class="col-6 d-flex align-items-center">
                            <label class="col-2" for="">Year</label>
                            <select name="sort" class="form-select col-6" style="width: 150px">
                                <option selected>Choose Year</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-6 row">
                    <div class="col-6">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal-MyLeave">Addition</button>
                        </div>
                    </div>
                    @include('front-end.my_leave.MyLeave')
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Quota</th>
                        <th scope="col">Type</th>
                        <th scope="col">Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($myleaves as $myleave)
                        <tr>
                            <th scope="row">{{ $myleave->id }}</th>
                            <td>{{ $myleave->quota }}</td>
                            <td>{{ $myleave->type == 1 ? 'addition' : 'original' }}</td>
                            <td>{{ $myleave->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </fieldset>
@endsection
