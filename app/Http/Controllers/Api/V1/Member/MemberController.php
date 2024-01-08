<?php

namespace App\Http\Controllers\Api\V1\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Member\UpdateApiMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Http\Resources\Member\MemberResource;
use App\Models\Member;
use App\Models\MemberShift;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $member = Member::findOrFail(Auth::id());
            if($member->avatar){
                $member->avatar = url('storage/uploads/'.$member->avatar);
            }
            if($member->avatar_official){
                $member->avatar_official = url('storage/uploads/'.$member->avatar_official);
            }
            
            return response($member, 200)->header('Content-Type', 'application/json');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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
    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MemberResource($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            if ($request->hasFile('file_avatar')) {
                $file = $request->file_avatar;
                $fileName = time() . '.' . $file->getClientOriginalName();
                $request->merge([
                    'avatar'    =>  $fileName,
                ]);
                
                Storage::disk('public')->put('uploads/' . $fileName, File::get($file));
            } 
            if ($request->hasFile('file_avatar_official')) {
                $file = $request->file_avatar_official;
                $fileName = time() . '.' . $file->getClientOriginalName();
                $request->merge([
                    'avatar_official'    =>  $fileName,
                ]);

                Storage::disk('public')->put('uploads/' . $fileName, File::get($file));
            }
            $data = $request->all();
            unset($data['_method']);
            unset($data['file_avatar']);
            unset($data['file_avatar_official']);
            Member::where('id', Auth::user()->id)->update($data);

            return response([
                'mesage' => 'success',
            ], 202)->header('Content-Type', 'multipart/form-data');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
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

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|string|confirmed'
        ]);

        $user = $request->user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return response()->json([
                'message' => 'Password successfully updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Old password does not matched'
            ], 400);
        }
    }

    public function memberShiftDetail()
    {
        try {
            $fields = [
                'shifts.shift_name',
                'shifts.check_in',
                'shifts.check_out',
                'shifts.work_time',
                'shifts.lunch_break',
                'member_shift.free_check',
                'member_shift.part_time'
            ];
            $member_shift =
                MemberShift::select($fields)->join('shifts', 'shifts.id', 'member_shift.shift_id')
                ->where('member_id', Auth::user()->id)
                ->first();
            return response()->json($member_shift, 200);
        } catch (NotFoundHttpException $exception) {
            return response()->json(["error" => $exception], 401);
        }
    }
}
