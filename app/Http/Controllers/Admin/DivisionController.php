<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use App\Http\Requests\Divisions\StoreDivisionsRequest;
use App\Http\Requests\Divisions\UpdateDivisionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class DivisionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('division_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
 
        $divisions = Division::paginate(Division::PER_PAGE);
        $listStatus = Division::LIST_STATUS;

        return view('admin.divisions.index', compact('divisions','listStatus'));
    }

    public function create()
    {
        abort_if(Gate::denies('division_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $members = Member::all();

        return view('admin.divisions.create', compact('members'));    
    }

    public function store(StoreDivisionsRequest $request)
    {
        abort_if(Gate::denies('division_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();
        try {
            $request->merge([
                'created_by' => Auth::id(),
                'status' => Division::NEW_STATUS,
            ]);
            $divisions = Division::create($request->all());
            $divisions->members()->sync($request->input('divisionMembers', []));
            DB::commit();
            Session::flash('message', 'You have successfully added division!'); 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        }finally {
            return redirect()->route('admin.divisions.index');
        }

    }

    public function show(Division $division)
    {
        abort_if(Gate::denies('division_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listStatus = Division::LIST_STATUS;
        $division->load('members','divisionManager');

        return view('admin.divisions.show', compact('division','listStatus'));
    }

    public function edit(Division $division)
    {
        abort_if(Gate::denies('division_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $listStatus = Division::LIST_STATUS;
        $members = Member::all();
        $division->load('members','divisionManager');

        return view('admin.divisions.edit', compact('division','listStatus','members'));
    }

    public function update(UpdateDivisionsRequest $request, Division $division)
    {
        abort_if(Gate::denies('division_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        DB::beginTransaction();
        try {
            $request->merge([
                'created_by' => $division->created_by,
            ]);
            $division->update($request->all());
            $division->members()->sync($request->input('divisionMembers', []));
            DB::commit();
            Session::flash('message', 'you have successfully updated division!'); 
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.divisions.index');
        }
    }

    public function destroy(Division $division)
    {
        try {
            $division->delete();
            Session::flash('message', 'You have successfully deleted division'); 
        } catch (\Exception $e) {
            Session::flash('error', 'Delete failed');
        } finally {
            return redirect()->route('admin.divisions.index');
        }
    }
}