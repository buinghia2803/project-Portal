<?php

namespace App\Http\Controllers\Api\V1\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PointActionsResource;
use App\Models\Point;
use App\Models\PointActions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PointsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $paginate = PointActions::PAGINATE;

        $data = PointActions::select(
            'id',
            'date',
            'action',
            'point'
        )
        ->where('member_id', Auth::user()->id);

        //start sắp xếp
        if (!empty($request->sort)) {
            [$order, $order_by] = explode(",", $request->sort);
            if (!in_array($order, ['asc', 'desc'])) {
                $order = 'asc';
            }
            if (!in_array($order_by, ['date', 'action'])) {
                $order_by = 'date';
            }
          } else {
            $order = 'asc';
            $order_by = 'date';
        }
        //end sắp xếp

        //search tháng
        if (!empty($request->period)) {
            $dateS = Carbon::now('Asia/Ho_Chi_Minh')->subMonth($request->period)->startOfMonth()->toDateString();
            $dateE = Carbon::now('Asia/Ho_Chi_Minh');
            $data->whereBetween('date',[$dateS,$dateE]);
        }
        //end search tháng

        return new PointActionsResource($data->orderBy($order_by, $order)->paginate($request->per_page ?? $paginate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request, $id)
    {
        //
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
