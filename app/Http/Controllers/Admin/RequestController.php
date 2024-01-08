<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RequestModel;
use App\Models\BaseModel;
use App\Models\Member;
use App\Models\WorkSheet;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;

class RequestController extends Controller
{
    public function index(Request $request, WorkSheet $worksheets)
    {
        abort_if(Gate::denies('request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::orderBy('id');

        $requests = RequestModel::with('members')->paginate(BaseModel::PER_PAGE);
        $condition_search = $request->search;

        if (isset($worksheets->late) && isset($worksheets->early)) {
            $worksheets->lack = $worksheets->late + $worksheets->early;
        } elseif (isset($worksheets->late)) {
            $worksheets->lack = $worksheets->late;
        } elseif (isset($worksheets->early)) {
            $worksheets->lack = $worksheets->early;
        };

        $members->when($condition_search, function ($query, $condition_search) {
            return $query->where('full_name', 'like', '%' . $condition_search . '%');
        })->get();

        return view('admin.request.index', compact('requests', 'members'));
    }

    public function update(RequestModel $request)
    {
        try {
            DB::beginTransaction();
            $worksheets = WorkSheet::where('member_id' , $request->member_id)->where('work_date', $request->request_for_date)->first();
            $request->status = RequestModel::REQUESTS_STATUS['2'];
            switch ($request->request_type) {
                case 1:
                    $worksheets->note = "Forget: Approved";
                    $worksheets->checkin = $request->check_in;
                    $worksheets->checkout = $request->check_out;
                    break;
                case 2:
                    $worksheets->note = "Leave: Approved";
                    $request->leave_time = $worksheets->paid_leave;
                    break;
                case 3:
                    $worksheets->note = "Leave: Approved";
                    $worksheets->unpaid_leave = $request->leave_time;
                    break;
                case 4:
                    $late = $worksheets->checkin->diffInMinutes($worksheets->checkin_original) > 0;
                    $early = $worksheets->checkout->diffInMinutes($worksheets->checkout_original) < 0;
                    if ($late || $early) {
                        $worksheets->note = "Leave: Approved";
                        $worksheets->compensation = $request->compensation_time;
                        $day = Carbon::parse("check_out")->format('Y m d');
                        $worksheets->note = "Cover Up: " . $day;
                        $worksheets->work_time = $request->check_out->diffInHours($request->check_in);
                        break;
                    };

                case 5:
                    $worksheets->note = "OT: Approved";
                    $worksheets->ot_time = $request->request_ot_time;

                    break;
            }
            $worksheets->update();
            $request->update();
            DB::commit();
            Session::flash('message', 'You have successfully updated request');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', 'error|There was an error...');
        } finally {
            return redirect()->back();
        }
    }

    public function show(RequestModel $request)
    {
        abort_if(Gate::denies('request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.request.show', compact('request'));
    }
}
