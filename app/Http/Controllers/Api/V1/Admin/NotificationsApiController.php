<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Http\Resources\Admin\NotificationResource;
use App\Models\BaseModel;
use App\Models\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            if (isset($request->per_page)) {
                $per_page = (int)$request->per_page;
            } else {
                $per_page = 30;
            }

            if (isset($request->page)) {
                $pageNumber = (int)$request->page;
            } else {
                $pageNumber = null;
            }

            if (isset($request->status)) {
                $status = (int)$request->status;
            } else {
                $status = 1;
            }

            if (isset($request->published_to) && $request->published_to != '') {
                $published_to = (int)$request->published_to;
            } else {
                $published_to = null;
            }

            if (isset($request->subject)) {
                $key_word = $request->subject;
            } else {
                $key_word = null;
            }

            if (!empty($request->sort)) {
                $order = $request->sort;
                if (!in_array($order, ['asc', 'desc'])) {
                    $order = 'asc';
                }
            } else {
                $order = 'asc';
            }

            $fields = [
                'notifications.id',
                'notifications.subject',
                'notifications.status',
                'members.full_name as author',
                'divisions.division_name as published_to',
                'notifications.published_date',
                'notifications.attachment'
            ];
            $notice = Notification::leftJoin('divisions', 'notifications.published_to', 'divisions.id')
                ->join('members', 'notifications.created_by', 'members.id')
                ->where("notifications.status", $status);

            if (is_null($published_to)) {
                $notice->whereNull("published_to");
            } else {
                $notice->where("published_to", $published_to);
            }

            if (!is_null($key_word)) {
                $notice->where("subject", "LIKE", "%{$key_word}%");
            }
            
            $data = $notice->orderBy("published_date", $order)
                ->paginate($per_page, $fields, 'page', $pageNumber)->toArray();

            if (!empty($data['data'])) {
            foreach ($data['data'] as $key => $notification) {
                    if (!$notification['published_to']) {
                        $data['data'][$key]['published_to'] = "All";
                    }
                    $data['data'][$key]['published_date'] = date('d/m/Y', strtotime($notification['published_date']));
                    $data['data'][$key]['attachment'] = url('storage/uploads/'.$notification['attachment']);
                }
            }

            return response()->json($data, 200);
        } catch (NotFoundHttpException $exception) {
            return response()->json(["error" => $exception], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        $file = $request->file_attachment;          
        $fileName = time() . '.' . $file->getClientOriginalName('file_attachment');
        $request->merge([
            'attachment' => $fileName
        ]);
        Storage::disk('public')->put('uploads/'.$fileName, File::get($file));

        $notice = Notification::create($request->all());
        return (new NotificationResource($notice))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notice = Notification::select(
            'notifications.id',
            'notifications.subject',
            'notifications.status',
            'members.full_name as author',
            'divisions.division_name as published_to',
            'notifications.published_date',
            'notifications.attachment',
            'notifications.message',
        )
            ->leftJoin('divisions', 'notifications.published_to', 'divisions.id')
            ->join('members', 'notifications.created_by', 'members.id')
            ->find($id);

        return new NotificationResource($notice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        if ($request->hasFile('file_attachment')) {
            $file = $request->file_attachment;
            $fileName = time() . '.' . $file->getClientOriginalName('file_attachment');
            if (!empty($notification->attachment)) {
                Storage::disk('public')->delete('uploads/' . $notification->attachment);
            }
            $fileName = time() . '.' . $file->getClientOriginalName('file_attachment');
            Storage::disk('public')->put('uploads/' . $fileName, File::get($file));
            $request->merge([
                'attachment'    => $fileName
            ]);
        }

        $notification->update($request->all());

        return (new NotificationResource($notification))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
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
