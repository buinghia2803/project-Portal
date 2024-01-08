<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\BaseModel;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $division_of_user = DB::table('division_member')->where('member_id', Auth::user()->id)->pluck('division_id');

        $notification = Notification::select(
            'notifications.id as notificationId',
            'notifications.subject',
            'members.full_name as author',
            'divisions.division_name as published_to',
            'notifications.published_date',
            'notifications.attachment',
            'divisions.id as divisionId',
        )
            ->leftJoin('divisions', 'notifications.published_to', 'divisions.id')
            ->join('members', 'notifications.created_by', 'members.id')
            ->whereIn('notifications.published_to', $division_of_user)
            ->orWhereNull('published_to')->get();

        return view('front-end.notification.index', compact('notification'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(Notification $notification)
    {
        return view('front-end.notification.show', compact('notification'));
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
