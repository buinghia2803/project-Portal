<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Notification\StoreNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Models\BaseModel;
use App\Models\Division;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class NotificationController extends Controller
{
    use MediaUploadingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('notification_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $notification = Notification::orderBy('created_at', 'desc');
        $notification = $notification->paginate(BaseModel::PER_PAGE);
        $divisions = Division::all();
        return view('notification.index', compact('notification', 'divisions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('notification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = Notification::STATUS;
        $divisions = Division::all();

        return view('notification.create', compact('status', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationRequest $request)
    {
        try {
            abort_if(Gate::denies('notification_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $request->merge([
                'created_by'    => Auth::id(),
                'published_to'  => $request->published_to ?  $request->published_to : null,

            ]);
            Notification::create($request->all());
            Session::flash('message', 'You have successfully added notification!'); 
        } catch (Exception  $e) {
            throw new Exception($e->getMessage());
            Session::flash('error', 'There was an error...'); 
        } finally {
            return redirect()->route('admin.notification.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        abort_if(Gate::denies('notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $status = Notification::STATUS;
        $divisions = Division::all();

        return view('notification.edit', compact('notification', 'status', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        try {
            abort_if(Gate::denies('notification_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $notification->update($request->all());
            Session::flash('message', 'You have successfully updated notification!');
        } catch (Exception  $e) {
            throw new Exception($e->getMessage());
            Session::flash('error', 'There was an error...'); 
        } finally {
            return redirect()->route('admin.notification.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        try {
            $notification->delete();
            Session::flash('message', 'You have successfully deleted notification!'); 
        } catch (\Exception $e) {
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.notification.index');
        }
    }
}
