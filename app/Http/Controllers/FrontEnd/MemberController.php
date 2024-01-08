<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::findOrFail(Auth::id())->get();
        foreach ($member as $key => $item) {

            return view('front-end.profile.index', compact('item'));
        }
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
    public function edit()
    {
        $members = Member::findOrFail(Auth::id())->get();

        foreach ($members as $member) {
            $member->birth_date = date('Y-m-d', strtotime($member->birth_date));

            return view('front-end.profile.edit', compact('member'));
        }
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
            $members = Member::findOrFail(Auth::id());

            if ($request->hasFile('file_avatar')) {
                $file = $request->file_avatar;
                $fileName = time() . '.' . $file->getClientOriginalName('file_avatar');
                if (!empty($members->avatar)) {
                    Storage::disk('public_uploads')->delete('uploads/' . $members->avatar);
                }
                $fileName = time() . '.' . $file->getClientOriginalName('file_avatar');

                $request->merge([
                    'avatar'    => $fileName,
                    'avatar_official' => $fileName
                ]);
                Storage::disk('public_uploads')->put($fileName, File::get($file));
            }

            $members->update($request->all());

            return redirect()->route('user.profile.index')->with([
                'success' => 'Update Profile Success'
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
            return redirect()->route('user.profile.index')->with([
                'error' => 'Update Profile Faile'
            ]);;
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
}
