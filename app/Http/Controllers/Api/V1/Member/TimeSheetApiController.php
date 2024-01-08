<?php

namespace App\Http\Controllers\Api\V1\Member;

use App\Http\Controllers\Controller;
use App\Http\Resources\Member\TimeSheetResource;
use App\Models\BaseModel;
use App\Models\WorkSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestModel;
use App\Models\CheckLogs;

class TimeSheetApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selectType = isset($request->select_type) ? (int)$request->select_type : 1;
        $listSelected = isset($request->list_selected) ? (int)$request->list_selected : 1;
        $startDate = $request->start_date ?? '';
        $endDate = $request->end_date ?? '';

        $order = 'desc';
        $order_by = 'work_date';

        if (!empty($request->sort)) {
            $order = $request->sort;
            if (!in_array($order, ['asc', 'desc'])) {
                $order = 'desc';
            }
        }

        if (!empty($request->per_page)) {
            $per_page = $request->per_page;
        } else {
            $per_page = 30;
        }

        if (!empty($request->page)) {
            $pageNumber = $request->page;
        } else {
            $pageNumber = null;
        }

        $timeSheets = WorkSheet::where('member_id', Auth::user()->id);
        $requests = RequestModel::select(['id', 'request_type', 'status', 'request_for_date'])->where('member_id', Auth::user()->id);
        // check tổng thời gian $startDate - $endDate không quá 90 ngày
        $dateDiff = date_diff(date_create($startDate), date_create($endDate));
        $dateDiff = $dateDiff->format("%a");
        if ($dateDiff > 90) {
            return response()->json([
                'message' => 'Total search time should not exceed 90 days',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($selectType == 1) {
            if ($listSelected == 1) {
                $timeSheets->where('work_date', '>=', date('Y-m-01'));
                $requests->where('request_for_date', '>=', date('Y-m-01'));
            } else {
                $timeSheets->where('work_date', '>=', date('Y-m-d', strtotime(date('Y-m-01') . " -1 months")))
                    ->where('work_date', '<=', date('Y-m-t', strtotime(date('Y-m-01') . " -1 months")));
                $requests->where('request_for_date', '>=', date('Y-m-d', strtotime(date('Y-m-01') . " -1 months")))
                    ->where('request_for_date', '<=', date('Y-m-t', strtotime(date('Y-m-01') . " -1 months")));
            }
        } else {
            $timeSheets->where('work_date', '<=', $endDate)->where('work_date', '>=', $startDate);
            $requests->where('request_for_date', '<=', $endDate)->where('request_for_date', '>=', $startDate);
        }

        $data_requests = $requests->get();
        
        if (!empty($data_requests)) {
            $data_requests = $data_requests->groupBy('request_for_date')->toArray();
            // dd($data_requests['2022-04-14']);
        }

        $data_timeSheets = $timeSheets->orderBy($order_by, $order)->paginate($per_page, ['*'], 'page', $pageNumber);

        $data_timeSheets = $data_timeSheets->toArray();
        if (!empty($data_timeSheets['data'])) {
            foreach ($data_timeSheets['data'] as $key => $day_timeSheet) {
                $data_timeSheets['data'][$key]['work_date'] = date('Y/m/d|D', strtotime($day_timeSheet['work_date']));
                $data_timeSheets['data'][$key]['checkin_original'] = date('H:m', strtotime($day_timeSheet['checkin_original']));
                $data_timeSheets['data'][$key]['checkout_original'] = date('H:m', strtotime($day_timeSheet['checkout_original']));
                $data_timeSheets['data'][$key]['checkin'] = isset($day_timeSheet['checkin']) ? date('H:m', strtotime($day_timeSheet['checkin'])) : null;
                $data_timeSheets['data'][$key]['checkout'] = isset($day_timeSheet['checkout']) ? date('H:m', strtotime($day_timeSheet['checkout'])) : null;
                if (array_key_exists($day_timeSheet['work_date'], $data_requests)) {
                    $data_timeSheets['data'][$key]['requests'] = $data_requests[$day_timeSheet['work_date']];
                } else {
                    $data_timeSheets['data'][$key]['requests'] = [];
                }
            }
        }

        return response()->json($data_timeSheets, 200);
    }

    public function detail($work_day)
    {
        try {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $work_day)) {
                return response()->json([
                    'message' => 'work_day is not invalid',
                ], Response::HTTP_BAD_REQUEST);
            }

            $timeSheets = WorkSheet::select('*')->where('member_id', Auth::user()->id)->where('work_date', $work_day)->first();

            $requests = RequestModel::select(['id', 'request_type', 'status', 'request_for_date'])->where('member_id', Auth::user()->id)->where('request_for_date', $work_day)->get();

            if ($timeSheets) {
                $timeSheets = $timeSheets->toArray();
                $timeSheets['work_date'] = date('Y/m/d|D', strtotime($timeSheets['work_date']));
                $timeSheets['checkin_original'] = date('H:m', strtotime($timeSheets['checkin_original']));
                $timeSheets['checkout_original'] = date('H:m', strtotime($timeSheets['checkout_original']));
                $timeSheets['checkin'] = isset($timeSheets['checkin']) ? date('H:m', strtotime($timeSheets['checkin'])) : null;
                $timeSheets['checkout'] = isset($timeSheets['checkout']) ? date('H:m', strtotime($timeSheets['checkout'])) : null;

                if ($requests) {
                    $timeSheets['requests'] = $requests->toArray();
                } else {
                    $timeSheets['requests'] = [];
                }
            } else {
                $timeSheets = [];
            }
            return response()->json($timeSheets, 200);
        } catch (NotFoundHttpException $exception) {
            return response()->json(["error" => $exception], 401);
        }
    }

    public function checklogs($work_day)
    {
        try {
            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $work_day)) {
                return response()->json([
                    'message' => 'work_day is not invalid',
                ], Response::HTTP_BAD_REQUEST);
            }

            $checkLogs = CheckLogs::select(['check_log.id', 'check_log.checktime', 'check_log.date as work_date'])
                ->join('members', 'check_log.member_code', 'members.member_code')
                ->where('members.id', Auth::user()->id)->where('check_log.date', $work_day)->get();

            $data = [];
            if ($checkLogs) {
                $checkLogs = $checkLogs->toArray();
                if (!empty($checkLogs)) {
                    foreach ($checkLogs as $checklog) {
                        $data[] = [
                            'id'    => $checklog['id'],
                            'work_date' => date('Y/m/d|D', strtotime($checklog['work_date'])),
                            'checktime' => date('H:m', strtotime($checklog['checktime'])),
                        ];
                    }
                }
            }
            return response()->json($data, 200);
        } catch (NotFoundHttpException $exception) {
            return response()->json(["error" => $exception], 401);
        }
    }
}
