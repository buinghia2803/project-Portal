<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\LeaveQuotaResource;
use App\Models\LeaveQuota;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Http\Requests\RegisterLeaveQuota\CreateRegisterLeaveQuota;

class LeaveQuotaApiController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('leave_quota_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $year = $request->year ?? Carbon::now()->format('Y');
        $leaveQuota = LeaveQuota::with(['requests' => function ($query) use ($year) {
            $query->where('year', $year);
        }]);
        $leaveQuota->when($year, function ($query, $year) {
            $query->where('year', $year);
        });
        $leaveQuota->where('member_id', Auth::id());
        $leaveQuota = $leaveQuota->get();

        return LeaveQuotaResource::collection($leaveQuota)[0]; 
    }

    public function show(LeaveQuota $leaveQuota)
    {
        abort_if(Gate::denies('leave_quota_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new LeaveQuotaResource($leaveQuota);
    }


    public function store(CreateRegisterLeaveQuota $request, LeaveQuota $leaveQuota)
    {
        abort_if(Gate::denies('leave_quota_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $year = $request->year ?? '';
            $leaveQuota = LeaveQuota::where('member_id', Auth::id())->where('year', $year)->first();
            if($leaveQuota->year){
                $leaveRequest = LeaveRequest::where('member_id', Auth::id())->where('year', $year)->first();
                $request -> merge([
                    'member_id' => Auth::id(),
                    'year' => $year,
                    'created_by' => Auth::user()->id,
                    'type' => LeaveRequest::TYPE['addition'],
                    'status' => LeaveRequest::STATUS['sending'],
                ]);
                $leaveRequest = LeaveRequest::create($request->all());

                return response()->json($leaveRequest, Response::HTTP_OK);
            }
            
            return response()->json(['message' => 'year does not exist',], Response::HTTP_UNPROCESSABLE_ENTITY);            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);        
        }
    }
}