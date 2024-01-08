<?php

namespace App\Http\Controllers\Api\V1\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest\RegisterRequest;
use App\Http\Resources\Admin\RequestResource;
use App\Models\MemberRequestQuota;
use App\Models\RequestModel;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class RequestApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        //check request không gửi quá 3 lần trong 1 tháng
        $requestQuota = MemberRequestQuota::where('member_id', Auth::id())->where('month', date('Y-m'))->first();
        if (empty($requestQuota) && ($request->request_type == 1 || $request->request_type == 4)) {
            MemberRequestQuota::create([
                'member_id' => Auth::id(),
                'month' => date('Y-m'),
                'quota' => MemberRequestQuota::QUOTA,
                'remain' => MemberRequestQuota::REMAIN,
            ]);
            
            $requestQuotaRemain = MemberRequestQuota::where('member_id', Auth::id())->where('month', date('Y-m'))->firstOrFail();

            $requestQuotaRemain->update([
                'remain' => $requestQuotaRemain->remain - 1
            ]);
        } else if($request->request_type == 1 || $request->request_type == 4){
            $requestQuotaRemain = MemberRequestQuota::where('member_id', Auth::id())->where('month', date('Y-m'))->firstOrFail();

            if ($requestQuotaRemain->remain > 0 && ($request->request_type == 1 || $request->request_type == 4)) {

                $requestQuotaRemain->update([
                    'remain' => $requestQuotaRemain->remain - 1
                ]);
            } else {
                return response()->json([
                    'message' => 'Heet luot !!!'
                ]);
            }
        }
        //end check request không gửi quá 3 lần trong 1 tháng

        //thêm request
        $request->merge([
            'member_id' => Auth::id()
        ]);
        if ($request->request_type == 1) {
            $request->merge([
                'check_in' => Carbon::parse($request->request_for_date.$request->check_in)->format('Y-m-d H:i:s'),
                'check_out' => Carbon::parse($request->request_for_date.$request->check_out)->format('Y-m-d H:i:s'),
            ]);
        }

        $data = RequestModel::create($request->all());
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $requests = RequestModel::where('member_id', Auth::user()->id)->where('id', $id)->first();

        return new RequestResource($requests);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = RequestModel::find($id);
        if ($update->request_type == 1) {
            $request->validate([
                'check_in' => 'required',
                'check_out' => 'required',
                'error_count' => 'required',
                'reason' => 'required'
            ]);
        }
        if ($update->request_type == 2 || $update->request_type == 3) {
            $request->validate([
                'leave_all_day' => 'required',
                'leave_start' => 'required',
                'leave_end' => 'required',
                'leave_time' => 'required',
                'reason' => 'required'
            ]);
        }
        if ($update->request_type == 4) {
            $request->validate([
                'compensation_time' => 'required',
                'compensation_date' => 'required',
                'reason' => 'required'
            ]);
        }
        if ($update->request_type == 5) {
            $request->validate([
                'request_ot_time' => 'required',
                'reason' => 'required'
            ]);
        }
        if ($update->request_type == 1) {
            $request->merge([
                'check_in' => Carbon::parse($update->request_for_date.$request->check_in)->format('Y-m-d H:i:s'),
                'check_out' => Carbon::parse($update->request_for_date.$request->check_out)->format('Y-m-d H:i:s'),
            ]);
        }
        $update->update($request->all());

        return response()->json($update, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $requests = RequestModel::findOrFail($id);
            if ($requests->request_type == 1 || $requests->request_type == 4) {
                $remainQuota = MemberRequestQuota::where('member_id', Auth::id())->where('month', date('Y-m'))->first();
                $remainQuota->update([
                    'remain' => $remainQuota->remain + 1,
                ]);
            }
            $requests->delete();

            DB::commit();
            return response()->json(
                ['mesage' => 'Delete successfully']    
            , 200);
        } catch (Exception $e) { 
            DB::rollBack();
            return response()->json(
                ['mesage' => 'Error']    
            , 400);
        }
    }

}
