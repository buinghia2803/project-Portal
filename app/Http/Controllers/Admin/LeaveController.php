<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveQuota;
use App\Models\LeaveRequest;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Leave\StoreLeaveRequest;
use App\Http\Requests\Leave\StoreAllLeaveRequest;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class LeaveController extends Controller
{
    public function index()
    {
            abort_if(Gate::denies('leave_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $paginate = LeaveQuota::PAGINATE;

            $original = LeaveQuota::ORIGINAL;

            $leaves = LeaveQuota::with('member')->orderByDesc('id')->paginate($paginate);

        
            return view('admin.leave.index', compact('leaves', 'original'));
    }

    public function create()
    {
            abort_if(Gate::denies('leave_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
            $members = Member::all();

            return view('admin.leave.create', compact('members'));
    }

    public function store(StoreLeaveRequest $request)
    {
        try {
            DB::beginTransaction();

            $type = LeaveRequest::TYPE;
            $status = LeaveRequest::STATUS;

            $year = Carbon::now()->year;
            LeaveRequest::create([
                'member_id' => $request->member_id,
                'year' => $year,
                'type' => $type['addition'],
                'quota' => $request->quota,
                'note' => $request->note,
                'status' => $status['approved'],
                'created_by' => Auth::user()->id,
            ]);
 
            $leaveQuota = LeaveQuota::where('year', $year)->Where('member_id', $request->member_id)->first();

            $leaveQuota->update([
                'quota' => $leaveQuota->quota + $request->quota,
                'paid_leave' => $leaveQuota->paid_leave + $request->quota,
            ]);
            

            DB::commit();
            Session::flash('message', 'You have successfully added leave!');
        } catch (Exception $e) { 
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.leaves.index');
        }
    }

    public function addAllLeave()
    {
            abort_if(Gate::denies('leave_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
            return view('admin.leave.add_all_leave');
    }

    public function storeAllLeave(StoreAllLeaveRequest $request)
    {
        try {
            DB::beginTransaction();

            $type = LeaveRequest::TYPE;
            $status = LeaveRequest::STATUS;
            $remain = LeaveRequest::REMAIN;

            $year = Carbon::now()->year;

            $members = Member::all()->pluck('id')->toArray();

            $arrLeaveQuota = [];
            $arrLeaveRequest = [];

            foreach ($members as $id) {

                $arrLeaveQuota[] = [
                    'member_id' => $id,
                    'year' => $year,
                    'quota' => $request->quota,
                    'remain' => $remain,
                    'created_at' => now()->toDateTimeString()
                ];

                $arrLeaveRequest[] = [
                    'member_id' => $id,
                    'year' => $year,
                    'type' => $type['original'],
                    'quota' => $request->quota,
                    'note' => $request->note,
                    'status' => $status['approved'],
                    'created_by' => Auth::user()->id,
                    'created_at' => now()->toDateTimeString()
                ];

            }

            LeaveQuota::insert($arrLeaveQuota);
            LeaveRequest::insert($arrLeaveRequest);
            
            DB::commit();
            Session::flash('message', 'You have successfully added leave!'); 
        } catch (Exception $e) { 
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.leaves.index');
        }
    }

    public function showRequest(Request $request)
    {
        $data = LeaveRequest::select(
            'leave_requests.id',
            'members.full_name',
            'leave_requests.type',
            'leave_requests.quota',
            'leave_requests.note',
            'leave_requests.status',
            'leave_requests.year',
        )
        ->join('members', 'leave_requests.member_id', 'members.id')
        ->where('leave_requests.year', $request->year)
        ->where('leave_requests.member_id', $request->member_id)
        ->get();
        return response()->json([
            'data' => $data
        ]);
    }
}
