<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RequestsAdminResource;
use App\Models\BaseModel;
use App\Models\RequestModel;
use App\Models\Worksheets;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestAdmin\CreateRequestAdmin;

class RequestsAdminApiController extends Controller
{
    public function index(Request $requestAdmin)
    {
        abort_if(Gate::denies('request_admin_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $sort = $requestAdmin->sort ?? 'asc';
            $status = $requestAdmin->status ?? 0;
            $perPage = $requestAdmin->per_page ?? BaseModel::PER_PAGE;
            $selectType = $requestAdmin->select_type ?? 1;
            $listSelected = $requestAdmin->list_selected ?? 1;
            $startDate = $requestAdmin->start_date ?? '';
            $endDate = $requestAdmin->end_date ?? '';

            // 
            $requests = RequestModel::select([
                'requests.*',
                'worksheets.checkin_original',
                'worksheets.checkout_original',
                'members.full_name as member_full_name',
                'manager.full_name as manager_full_name',
                'admin.full_name as admin_full_name'
            ])
                ->join('worksheets', 'work_date', 'request_for_date')
                ->leftJoin('members', 'requests.member_id', 'members.id')
                ->leftJoin('members as admin', 'requests.manager_id', 'admin.id')
                ->leftJoin('members as manager', 'requests.admin_id', 'manager.id');

            if ($selectType == 1) {
                if ($listSelected == 1) {
                    $requests->when($listSelected, function ($requests) {
                        $requests->whereYear('request_for_date', date('Y'))->whereMonth('request_for_date', date('m'));
                    });
                } else {
                    $requests->when($listSelected, function ($requests) {
                        $requests->whereYear('request_for_date', date('Y'))->whereMonth('request_for_date', date('m', strtotime('-1 month')));
                    });
                }
            } else {
                // tổng thời gian $startDate - $endDate không quá 90 ngày
                $dateDiff = date_diff(date_create($startDate), date_create($endDate));
                $dateDiff = $dateDiff->format("%a");
                if ($dateDiff > 90) {
                    return response()->json([
                        'message' => 'Total search time should not exceed 90 days',
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }
                $requests->when($startDate, function ($requests) use ($startDate) {
                    $requests->whereDate('request_for_date', '>=', $startDate);
                });
                $requests->when($endDate, function ($requests) use ($endDate) {
                    $requests->whereDate('request_for_date', '<=',  $endDate);
                });
            };
            $requests->when($sort, function ($requests) use ($sort) {
                $requests->orderBy('request_for_date', $sort);
            });
            $requests->when(isset($status), function ($requests) use ($status) {
                $requests->where('requests.status', $status);
            });
            $requests = $requests->paginate($perPage);
            $data = [];
            if ($requests) {
                $data = $requests->toArray();
                foreach ($data['data'] as $key => $row) {
                    $data['data'][$key]['request_for_date'] = date('Y/m/d|D', strtotime($row['request_for_date']));
                    $data['data'][$key]['checkin_original'] = date('H:m', strtotime($row['checkin_original']));
                    $data['data'][$key]['checkout_original'] = date('H:m', strtotime($row['checkout_original']));
                    unset($data['data'][$key]['members']);
                }
            }

            return response()->json($data, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(["error" => $e], 401);
        }
    }
 
    public function show(RequestModel $request)
    {
        abort_if(Gate::denies('request_admin_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request = RequestModel::with('members:full_name,id')
            ->where('id', $request->id)
            ->first();

        return response()->json($request, Response::HTTP_OK);
    }

    public function update(CreateRequestAdmin $requestAdmin, RequestModel $request, Worksheets $worksheets)
    {
        abort_if(Gate::denies('request_admin_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $request->update([
                'status' => ($requestAdmin->admin_approved_status == 1) ? 2 : $requestAdmin->admin_approved_status,
                'admin_id' => Auth::id(),
                'admin_approved_status' => $requestAdmin->admin_approved_status,
                'admin_approved_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'admin_approved_comment' => $requestAdmin->admin_approved_comment,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ], $requestAdmin->all());

            // 
            $worksheets = Worksheets::where('member_id', $request->member_id)->whereDate('work_date', $request->request_for_date);
            $checkIn = Carbon::parse($request->check_in)->format('H:i');
            $checkOut = Carbon::parse($request->check_out)->format('H:i');
            $workTime = Carbon::parse($checkOut)->diffInSeconds(Carbon::parse($checkIn)) - 3600;
            $late = Carbon::parse($checkIn)->diffInSeconds(Carbon::parse('08:00'));
            $early = Carbon::parse($checkOut)->diffInSeconds(Carbon::parse('17:00'));

            //
            if ($late > 0 && $early > 0) {
                $lack = $late + $early;
            } elseif ($late > 0 && $early == 0) {
                $lack = $late;
            } elseif ($late == 0 && $early > 0) {
                $lack = $early;
            } else {
                $lack = 8 * 3600;
            };

            // 
            if ($request->status == 0) {
                $status = "Leave:Sent";
            } else if ($request->status == 1) {
                $status = "Leave:Confirmed";
            } else {
                $status = "Leave:Approved";
            };

            //
            if ($request->request_type == 1) {
                $worksheets->update([
                    'lack' => gmdate('H:i', $lack),
                    'checkin' => $request->check_in ?? '',
                    'checkout' => $request->check_out ?? '',
                    'work_time' => gmdate('H:i', $workTime) ?? '',
                    'note' => $status,
                ]);
            } else if ($request->request_type == 2) {
                $worksheets->update([
                    'paid_leave' => $request->leave_time ?? $request->leave_all_day,
                    'work_time' => gmdate('H:i', $workTime) ?? '',
                    'note' => $status,
                ]);
            } else if ($request->request_type == 3) {
                $worksheets->update([
                    'unpaid_leave' => $request->leave_time ?? $request->leave_all_day,
                    'work_time' => gmdate('H:i', $workTime) ?? '',
                    'note' => $status,
                ]);
            } else if ($request->request_type == 4) {
                $worksheets->update([
                    'late' => gmdate('H:i:s', $late) ?? '',
                    'early' => gmdate('H:i:s', $early) ?? '',
                    'compensation' => $request->compensation_time ?? '',
                    'work_time' => gmdate('H:i', $workTime) ?? '',
                    'note' => $status,
                ]);
            } else {
                $worksheets->update([
                    'ot_time' => $request->request_ot_time ?? '',
                    'compensation' => $request->compensation_time ?? '',
                    'work_time' => gmdate('H:i', $workTime) ?? '',
                    'note' => $status,
                ]);
            }

            return (new RequestsAdminResource($request))
                ->response()
                ->setStatusCode(Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy(RequestModel $request)
    {
        abort_if(Gate::denies('request_admin_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
