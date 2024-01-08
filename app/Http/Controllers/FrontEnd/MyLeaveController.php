<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\LeaveQuota;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myleaves = LeaveRequest::all();

        return view('front-end.my_leave.index', compact('myleaves'));
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
        $leaveQuota = LeaveQuota::where('member_id', Auth::id())->first();

        $paid_leave_reduce = $leaveQuota->paid_leave - 1;
        if ($paid_leave_reduce > 0) {
            if ($leaveQuota->member_id == Auth::id()) {
                $request->merge([
                    'member_id' => Auth::id(),
                    'year'  =>  date('Y'),
                    'type'  => 1,
                    'quota' => $paid_leave_reduce,
                    'created_by'  => Auth::id()
                ]);
                $leaveQuota = $leaveQuota->update([
                    'paid_leave' => $paid_leave_reduce
                ]);
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Het Luot',
            ]);
        }

        LeaveRequest::create($request->all());

        return redirect()->route('user.myleave.index');
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
