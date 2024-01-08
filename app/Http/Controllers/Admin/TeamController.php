<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Http\Requests\Teams\StoreTeamRequest;
use App\Http\Requests\Teams\UpdateTeamRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Exception;

class TeamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 
        $teams = Team::paginate(Team::PER_PAGE);
        $listStatus = Team::LIST_STATUS;

        return view('admin.teams.index', compact('teams','listStatus'));
    }

    public function create()
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::all();

        return view('admin.teams.create', compact('members'));    
    }

    public function store(StoreTeamRequest $request)
    {
        abort_if(Gate::denies('team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();
        try {
            $request->merge([
                'created_by' => Auth::id(),
                'status' => Team::NEW_STATUS,
            ]);
            $teams = Team::create($request->all());
            $teams->members()->sync($request->input('teamMembers', []));
            DB::commit();
            Session::flash('message', 'You have successfully added teams!'); 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.teams.index');
        }
    }

    public function show(Team $team)
    {
        abort_if(Gate::denies('team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listStatus = Team::LIST_STATUS;
        $team->load('members','teamLeader');

        return view('admin.teams.show', compact('team','listStatus'));
    }

    public function edit(Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listStatus = Team::LIST_STATUS;
        $members = Member::all();
        $team->load('members','teamLeader');

        return view('admin.teams.edit', compact('team','listStatus','members'));
    }

    public function update(UpdateTeamRequest $request, Team $team)
    {
        abort_if(Gate::denies('team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();
        try {
            $request->merge([
                'created_by' => Auth::id(),
            ]);
            $team->update($request->all());
            $team->members()->sync($request->input('teamMembers', []));

            DB::commit();
            Session::flash('message', 'you have successfully updated team!'); 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.teams.index');
        }
    }

    public function destroy(Team $team)
    {
        try {
            $team->delete(); 
            Session::flash('message', 'You have successfully deleted team!'); 
        } catch (\Exception $e) {
            Session::flash('error', 'Delete failed');
        } finally {
            return redirect()->route('admin.teams.index');
        }
    }
}