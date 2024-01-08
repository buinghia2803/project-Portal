<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PointAction\PointActionRequest;
use App\Models\BaseModel;
use App\Models\Division;
use App\Models\Member;
use App\Models\Point;
use App\Models\PointAction;
use App\Models\Team;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class PointActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('point_action_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pointActions = PointAction::with('member')->select('point_actions.*');
        $members = Member::all();
        $divisions = Division::all();
        $teams = Team::all();
        $conditionMember = !empty($request->member);
        $conditionDivision = !empty($request->division);
        $conditionTeam = !empty($request->teams);

        $pointActions->when($conditionMember, function ($pointActions) use ($request) {
            return  $pointActions->where('point_actions.member_id', $request->member);
        })->when($conditionDivision, function ($pointActions) use ($request) {
            return $pointActions->join('division_member', 'point_actions.member_id', 'division_member.member_id')
                ->join('divisions', 'division_member.division_id', 'divisions.id')
                ->where('divisions.id', $request->division);
        })->when($conditionTeam, function ($pointActions) use ($request) {
            return $pointActions->join('team_member', 'point_actions.member_id', 'team_member.member_id')
                ->join('teams', 'team_member.team_id', 'teams.id')
                ->where('teams.id', $request->teams);
        })->get();

        $pointActions = $pointActions->paginate(BaseModel::PER_PAGE);
        $pointActions->appends(request()->query());

        return view('points.index', compact('pointActions', 'members', 'divisions', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('point_action_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::get();

        return view('points.created', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PointActionRequest $request)
    {
        try {
            DB::beginTransaction();
            $request->merge([
                'status'     => PointAction::NEW_STATUS,
                'created_by' => Auth::id(),
                'month'      => date('Y-m'),
                'year'       => date('Y'),
            ]);

            PointAction::create($request->all());

            $points = Point::where('member_id', $request->member_id)->first();

            if ($points != null) {
                $results = $points->current_point + ($request->point);
                $points = $points->update([
                    'current_point'     => $results,
                    'total_received'    => $request->point > 0 ? $points->total_received + ($request->point) : $points->total_received,
                    'total_spent'       => $request->point < 0 ? $points->total_spent + ($request->point) : $points->total_spent,
                    'month_point'       => $results
                ]);
            }
            DB::commit();
            Session::flash('message', 'You have successfully added point action!'); 
        } catch (Exception  $e) {
            DB::rollback();
            Session::flash('error', 'There was an error...'); 
            throw new Exception($e->getMessage());
        } finally {
            return redirect()->route('admin.points.index');
        }
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
