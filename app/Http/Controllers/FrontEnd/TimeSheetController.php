<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest\RegisterRequest;
use App\Models\Member;
use App\Models\RequestModel;
use App\Models\WorkSheet;
use App\Models\Worksheets;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TimeSheetController extends Controller
{
    public function index(Request $request)
    {
        $resultStart = now()->startOfMonth();
        $resultEnd = now()->endOfMonth();

        $timeSheets = WorkSheet::where('member_id', Auth::user()->id);

        $monthRequest = $request->month;
        // dd($monthRequest);
        if (!empty($monthRequest)) {
            $resultStart = date('Y-m-01 00:00:00', strtotime($monthRequest));

            $year = date('Y', strtotime($monthRequest));
            $month = date('m', strtotime($monthRequest));
            $resultEnd = WorkSheet::lastday($month, $year);

            $timeSheets = $timeSheets->whereBetween('work_date', [$resultStart, $resultEnd]);
        } else {
            $timeSheets = $timeSheets->whereBetween('work_date', [$resultStart, $resultEnd]);
        }

        if ($request->sort == 'asc') {
            $timeSheets = $timeSheets->orderBy('work_date', 'asc');
        }
        if ($request->sort == 'desc') {
            $timeSheets = $timeSheets->orderBy('work_date', 'desc');
        }

        $timeSheets = $timeSheets->paginate(3);

        foreach ($timeSheets as $id => $value) {
            $requests = RequestModel::get_request($value->work_date);
            $timeSheets[$id]['request'] = array();
            if ($requests) {
                $timeSheets[$id]['request'] = $requests->toArray();
            } else {
                $timeSheets[$id]['request'] = [];
            }
        }

        //thong ke tong so gio nghi va di muon

        if (!empty($monthRequest)) {

            $resultStart = date('Y-m-01 00:00:00', strtotime($monthRequest));

            $year = date('Y', strtotime($monthRequest));
            $month = date('m', strtotime($monthRequest));
            $resultEnd = WorkSheet::lastday($month, $year);

            [$totalLateTime, $totalLateDay] = $this->getTotal($type = 'late', $resultStart, $resultEnd);
            [$totalEarlyTime, $totalEarlyDay] = $this->getTotal($type = 'early', $resultStart, $resultEnd);
        } else {
            [$totalLateTime, $totalLateDay] = $this->getTotal($type = 'late', $resultStart, $resultEnd);
            [$totalEarlyTime, $totalEarlyDay] = $this->getTotal($type = 'early', $resultStart, $resultEnd);
        }

        $arr = [];
        array_push($arr, ['totalLateTime', 'totalLateDay', 'totalEarlyTime', 'totalEarlyDay']);
        dd($arr);


        return view('front-end.timesheet.index', compact('timeSheets', 'totalLateTime', 'totalLateDay', 'totalEarlyTime', 'totalEarlyDay'));
    }

    public function getTotal($type, $resultStart, $resultEnd, $hourLateTotal = 0, $minuteLateTotal = 0)
    {
        $lateTotalTime = WorkSheet::where('member_id', Auth::user()->id)->whereBetween('work_date', [$resultStart, $resultEnd])->get();

        $$type = 0;

        foreach ($lateTotalTime as $value) {
            [$hour, $minute] = explode(':', ($value[$type] ?? '00:00'));
            $hourLateTotal += $hour;
            $minuteLateTotal += $minute;
            if ($minuteLateTotal >= 60) {
                $hourLateTotal += 1;
                $minuteLateTotal -= 60;
            }
            switch ($type) {
                case 'late':
                    if ($value[$type] != '00:00' && !empty($value[$type])) {
                        $$type++;
                    }
                    break;
                case 'early':
                    if ($value[$type] != '00:00'  && !empty($value[$type])) {
                        $$type++;
                    }
                    break;
                default:

                    break;
            }
        }

        $totalResults = '00:00';
        $totalResults = ($hourLateTotal < 10 ? '0' . $hourLateTotal : $hourLateTotal) . ':' . ($minuteLateTotal < 10 ? '0' . $minuteLateTotal : $minuteLateTotal);
        return [$totalResults, $$type];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request, RequestModel $requestModel)
    {
        try {
            $request->merge([
                'member_id' => Auth::id(),
            ]);
            $input = $request->all();
            // dd($input);
            switch ($request->request_type) {
                case 1:
                    if ($request->has('check_in') && $request->check_in) {
                        $input['check_in'] = now()->format('Y-m-d') . ' ' . $request->check_in;
                    }
                    if ($request->has('check_out') && $request->check_out) {
                        $input['check_out'] = now()->format('Y-m-d') . ' ' . $request->check_out;
                    }
                    if (!isset($request->error_count)) {
                        $param['error_count'] = 1;
                    }
                    break;
                case 4:
                    $requestModel->compensation_date = $request->compensation_date;
                    $requestModel->compensation_time = $request->compensation_time;
                    $requestModel->request_for_date = $request->request_for_date;
                    $requestModel->request_type = $request->request_type;
                    break;
                case 5:

                    break;
                default:

                    break;
            }
            // RequestModel::create($input);
            $requestModel->create($input);

            return redirect()->back()->with([
                'success' => 'Sent Request Success'
            ]);
        } catch (Exception $e) {

            throw new Exception($e->getMessage());
            return redirect()->back()->with([
                'error' => 'Sent Request Faile'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RegisterRequest $request, $timesheet)
    {
        $param = $request->all();
        unset($param['_method']);
        unset($param['_token']);

        $request->merge([
            'member_id' => Auth::id()
        ]);

        switch ($request->request_type) {
            case 1:
                if ($request->has('check_in') && $request->check_in) {
                    $param['check_in'] = Carbon::parse($param['request_for_date'] . $param['check_in']);
                }
                if ($request->has('check_out') && $request->check_out) {
                    $param['check_out'] = Carbon::parse($param['request_for_date'] . $param['check_out']);
                }
                break;
            default:
                break;
        }

        RequestModel::where('id', $timesheet)->update($param);

        return redirect()->back();
    }

    public function getOverTime(Request $request)
    {
        $compensation_date = $request->compensation_date;
        $timeSheets = WorkSheet::where('member_id', Auth::user()->id)->where('work_date', $compensation_date)->first();
        $checkoutOriginal = $timeSheets->checkout_original;
        $convertCheckoutOriginal = date('H:i', strtotime($checkoutOriginal));
        $timeNow = now()->format('17:00');

        $explodeCheckoutOriginal = explode(':', $convertCheckoutOriginal);
        $explodeTimeNow = explode(':', $timeNow);

        if ($explodeCheckoutOriginal[0] >= $explodeTimeNow[0] && $explodeCheckoutOriginal[1] >= $explodeTimeNow[1]) {
            $totalHour = $explodeCheckoutOriginal[0] - $explodeTimeNow[0];
            $totalMinute = $explodeCheckoutOriginal[1] - $explodeTimeNow[1];

            $overTime = ($totalHour < 10 ? '0' . $totalHour : $totalHour) . ':' . ($totalMinute < 10 ? '0' . $totalMinute : $totalMinute);
        }

        return response()->json([
            'overTime' => $overTime ?? '00:00'
        ]);
    }
}
