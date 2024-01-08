<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\Point;
use App\Models\PointAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = PointAction::PAGINATE;

        $data = PointAction::select(
            'point_actions.id',
            'date',
            'action',
            'point',
            'full_name'
        )
            ->join('members', 'point_actions.member_id', 'members.id')
            ->where('point_actions.member_id', Auth::user()->id);

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
            $data->whereBetween('date', [$dateS, $dateE]);
        }
        //end search tháng
        $point = Point::select('current_point', 'month_point')
            ->where('member_id', Auth::id())
            ->first();

        $data = $data->paginate(BaseModel::PER_PAGE);

        return view('front-end.r-point', compact('data', 'point'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
