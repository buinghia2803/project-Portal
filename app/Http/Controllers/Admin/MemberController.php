<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Models\Division;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Models\BaseModel;
use App\Models\Member;
use App\Models\Point;
use App\Models\Role;
use App\Models\Shift;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('member_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::select('members.*');

        if (!empty($request->division)) {
            $members = $members->join('division_member', 'division_member.member_id', 'members.id')
                ->join('divisions', 'division_member.division_id', 'divisions.id')
                ->where('divisions.id', $request->division);
        }
        if (!empty($request->teams)) {
            $members = $members->join('team_member', 'team_member.member_id', 'members.id')
                ->join('teams', 'team_member.team_id', 'teams.id')
                ->where('teams.id', $request->teams);
        }

        if (!empty($request->member)) {
            $members = $members->where('members.id', $request->member);
        }

        $divisions = Division::all();
        $memberAll = Member::all();
        $teams = Team::all();
        $condition_search = !empty($request->search);
        $members->when($condition_search, function ($query) use ($request) {
            return $query->where('full_name', 'like', '%' . $request->search . '%');
        })->get();
        $members = $members->orderBy('id', 'desc');
        $members = $members->paginate(BaseModel::PER_PAGE);
        $members->appends(request()->query());
        
        return view('admin.members.index', compact('members', 'teams', 'divisions' , 'memberAll'));
    }

    public function create()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');
        $divisions = Division::all()->pluck('division_name', 'id');
        $teams = Team::all()->pluck('team_name', 'id');
        $shifts = Shift::all()->pluck('shift_name', 'id');
        $maritalStatus = Member::MARITAL_STATUS;
        $status = Member::STATUS;

        return view('admin.members.create', compact('roles', 'maritalStatus', 'status', 'divisions', 'teams', 'shifts'));
    }

    public function store(StoreMemberRequest $request)
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            DB::beginTransaction();

            if ($request->hasFile('file_avatar')) {
                $file = $request->file_avatar;
                $fileName = time() . '.' . $file->getClientOriginalName('file_avatar');
                $request->merge([
                    'created_by'    => Auth::id(),
                    'avatar'    =>  $fileName,
                    'avatar_official' => $fileName
                ]);
                Storage::disk('public')->put('uploads/' . $fileName, File::get($file));
            } else {
                $request->merge([
                    'created_by'    => Auth::id(),
                ]);
            }
            
            $member = Member::create($request->all());
            $member->roles()->sync($request->input('roles', []));
            $member->teams()->sync($request->input('teams', []));
            $member->divisions()->sync($request->input('division', []));
            $member->shifts()->syncWithPivotValues($request->input('shift', []), ['created_by' => Auth::id()]);

            Point::create([
                'member_id' => $member->id,
                'current_point' => 1000,
                'month_point' => 0,
                'total_received' => 0,
                'total_spent' => 0,
            ]);
            DB::commit();
            Session::flash('message', 'You have successfully added member!');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.members.index');
        }
    }

    public function edit(Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $formatDate = [
            '1'     => date('Y-m-d', strtotime($member->birth_date)),
            '2'     => date('Y-m-d', strtotime($member->identity_card_date)),
            '3'     => date('Y-m-d', strtotime($member->passport_expiration)),
            '4'     => date('Y-m-d', strtotime($member->tax_date)),
            '5'     => date('Y-m-d', strtotime($member->start_date_official)),
            '6'     => date('Y-m-d', strtotime($member->start_date_probation)),
            '7'     => date('Y-m-d', strtotime($member->end_date)),
        ];
        $maritalStatus = Member::MARITAL_STATUS;
        $status = Member::STATUS;
        $roles = Role::all()->pluck('title', 'id');
        $divisions = Division::all()->pluck('division_name', 'id');
        $teams = Team::all()->pluck('team_name', 'id');
        $shifts = Shift::all()->pluck('shift_name', 'id');

        $member->load('roles');

        return view('admin.members.edit', compact('roles', 'member', 'maritalStatus', 'status', 'divisions', 'teams', 'shifts', 'formatDate'));
    }

    public function update(Request $request, Member $member)
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            DB::beginTransaction();

            if ($request->hasFile('file_avatar')) {
                $file = $request->file_avatar;
                $fileName = time() . '.' . $file->getClientOriginalName('file_avatar');
                if (!empty($member->avatar)) {
                    Storage::disk('public')->delete('uploads/' . $member->avatar);
                }
                $fileName = time() . '.' . $file->getClientOriginalName('file_avatar');
                Storage::disk('public')->put('uploads/' . $fileName, File::get($file));
                $request->merge([
                    'avatar'    => $fileName,
                    'avatar_official' => $fileName
                ]);
            }

            $member->update($request->all());
            $member->roles()->sync($request->input('roles', []));
            $member->teams()->sync($request->input('team', []));
            $member->divisions()->sync($request->input('division', []));
            $member->shifts()->syncWithPivotValues($request->input('shift', []), ['created_by' => Auth::id()]);

            DB::commit();
            Session::flash('message', 'You have successfully updated member!');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.members.index');
        }
    }

    public function show(Member $member)
    {
        abort_if(Gate::denies('member_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.members.show', compact('member'));
    }

    public function destroy(Member $member)
    {
        try {
            $member->delete();
            Session::flash('message', 'You have successfully deleted member!');
        } catch (\Exception $e) {
            Session::flash('error', 'Delete failed');
        } finally {
            return redirect()->route('admin.members.index');
        }
    }
}
