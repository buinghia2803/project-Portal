<?php

namespace App\Http\Controllers\Api\V1\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\NotificationsResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Gate;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\HttpFoundation\Response;

class NotificationsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = Notification::PAGINATE;
        
        $division_of_user = DB::table('division_member')->where('member_id', Auth::user()->id)->pluck('division_id');

        $notifi = Notification::select(
            'notifications.id',
            'notifications.subject',
            'members.full_name as author',
            'divisions.division_name as published_to',
            'notifications.published_date',
            'notifications.attachment',
        )
        ->leftJoin('divisions', 'notifications.published_to', 'divisions.id')
        ->join('members', 'notifications.created_by', 'members.id')
        ->whereIn('notifications.published_to', $division_of_user)
        ->orWhereNull('published_to');

        //start sắp xếp
        if (!empty($request->sort)) {
            [$order, $order_by] = explode(",", $request->sort);
            if (!in_array($order, ['asc', 'desc'])) {
                $order = 'asc';
            }
            if (!in_array($order_by, ['published_date'])) {
                $order_by = 'published_date';
            }
          } else {
            $order = 'asc';
            $order_by = 'published_date';
        }
        //end sắp xếp

        $data = $notifi->orderBy($order_by, $order)->paginate($request->per_page ?? $paginate)->toArray();
        if (!empty($data['data'])) {
            foreach ($data['data'] as $key => $notification) {
                if (!$notification['published_to']) {
                    $data['data'][$key]['published_to'] = "All";
                }
                $data['data'][$key]['published_date'] = date('d/m/Y', strtotime($notification['published_date']));
                $data['data'][$key]['attachment'] = url('storage/uploads/uploads/'.$notification['attachment']);
            }
        }
        return response()->json($data, 200);
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
        $division_of_user = DB::table('division_member')->where('member_id', Auth::user()->id)->pluck('division_id');

        $push = $division_of_user->push(null)->toArray();

        $notifications = Notification::find($id);

        abort_if(!in_array($notifications['published_to'], $push), Response::HTTP_FORBIDDEN, '403 Forbidden');
        

        $notifi = Notification::select(
            'notifications.id',
            'notifications.subject',
            'members.full_name as author',
            'divisions.division_name as published_to',
            'notifications.published_date',
            'notifications.attachment',
            'notifications.message',
        )
        ->leftJoin('divisions', 'notifications.published_to', 'divisions.id')
        ->join('members', 'notifications.created_by', 'members.id')
        ->find($id);
        
        return new NotificationsResource($notifi);
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
