<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterCheckInOut\CreateRegisterCheckInOut;
use App\Http\Requests\RegisterCheckInOut\UpdateRegisterCheckInOut;
use App\Http\Resources\Admin\CreatedRegisterCheckInOutResource;
use App\Models\RequestModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RegisterCheckInCheckOut extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRegisterCheckInOut $request)
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['check_in'] = Carbon::parse($data['request_for_date'] . $data['check_in'])->format('Y-m-d H:i:s');
        $data['check_out'] = Carbon::parse($data['request_for_date'] . $data['check_out'])->format('Y-m-d H:i:s');

        $check = RequestModel::create($data);

        return (new CreatedRegisterCheckInOutResource($check))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RequestModel $registerCheckinCheckout)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CreatedRegisterCheckInOutResource($registerCheckinCheckout);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegisterCheckInOut $request, RequestModel $registerCheckinCheckout)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['check_in'] = Carbon::parse($data['request_for_date'] . $data['check_in'])->format('Y-m-d H:i:s');
        $data['check_out'] = Carbon::parse($data['request_for_date'] . $data['check_out'])->format('Y-m-d H:i:s');

        $registerCheckinCheckout->update($data);

        return (new CreatedRegisterCheckInOutResource($registerCheckinCheckout))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
