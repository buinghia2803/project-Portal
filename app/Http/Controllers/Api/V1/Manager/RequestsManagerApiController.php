<?php

namespace App\Http\Controllers\Api\V1\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\RequestsManagerResource;
use App\Models\BaseModel;
use App\Models\RequestModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RequestManager\CreateRequestManager;

class RequestsManagerApiController extends Controller
{
    public function index(Request $requestManager)
    {
        abort_if(Gate::denies('request_manager_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $sort = $requestManager->sort ?? 'asc';
            $status = $requestManager->status ?? 0;
            $perPage = $requestManager->per_page ?? BaseModel::PER_PAGE;
            $selectType = $requestManager->select_type ?? 1;
            $listSelected = $requestManager->list_selected ?? 1;
            $startDate = $requestManager->start_date ?? '';
            $endDate = $requestManager->end_date ?? '';
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
                // tổng thời gian $startDate - $end_date không quá 90 ngày
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
        abort_if(Gate::denies('request_manager_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request = RequestModel::with('members:full_name,id')
            ->where('id', $request->id)
            ->first();
        
        return response()->json($request, Response::HTTP_OK);
    }

    public function update(CreateRequestManager $requestManager, RequestModel $request)
    {
        abort_if(Gate::denies('request_manager_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $request->update([
                'status' => $requestManager->manager_confirmed_status,
                'manager_id' => Auth::id(),
                'manager_confirmed_status' => $requestManager->manager_confirmed_status,
                'manager_confirmed_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'manager_confirmed_comment' => $requestManager->manager_confirmed_comment,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return (new RequestsManagerResource($request))
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
        abort_if(Gate::denies('request_manager_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
