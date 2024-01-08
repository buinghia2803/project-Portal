<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterOt\CreateRegisterOt;
use App\Http\Requests\RegisterOt\UpdateRegisterOt;
use App\Http\Resources\Admin\CreateRegisterOtResource;
use App\Models\RequestModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RegisterOtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function store(CreateRegisterOt $request)
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['check_in'] = Carbon::parse($data['request_for_date'] . $data['check_in'])->format('Y-m-d H:i:s');
        $data['check_out'] = Carbon::parse($data['request_for_date'] . $data['check_out'])->format('Y-m-d H:i:s');
        
        $registerOt = RequestModel::create($data);

        return (new CreateRegisterOtResource($registerOt))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RequestModel $registerOt)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CreateRegisterOtResource($registerOt);
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
    public function update(UpdateRegisterOt $request, RequestModel $registerOt)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['check_in'] = Carbon::parse($data['request_for_date'] . $data['check_in'])->format('Y-m-d H:i:s');
        $data['check_out'] = Carbon::parse($data['request_for_date'] . $data['check_out'])->format('Y-m-d H:i:s');

        $registerOt->update($data);

        return (new CreateRegisterOtResource($registerOt))
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
