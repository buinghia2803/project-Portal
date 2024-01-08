<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\UpdateHolidayRequest;
use App\Models\Holiday;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HolidayController extends Controller
{
    public function index()
    {
            abort_if(Gate::denies('holiday_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $paginate = Holiday::PAGINATE;
            
            $holidays = Holiday::orderByDesc('id')->paginate($paginate);

            return view('admin.holiday.index', compact('holidays'));
    }

    public function create()
    {
            abort_if(Gate::denies('holiday_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            return view('admin.holiday.create');
    }

    public function store(StoreHolidayRequest $request)
    {
        try {
            Holiday::create($request->all());
            Session::flash('message', 'You have successfully added holiday');

        } catch (Exception $e) {
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.holidays.index');
        }
    }

    public function edit(Holiday $holiday)
    {
            abort_if(Gate::denies('holiday_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
            return view('admin.holiday.edit', compact('holiday'));
    }

    public function update(UpdateHolidayRequest $request, Holiday $holiday)
    {
        try {
            $holiday->update($request->all());
            Session::flash('message', 'You have successfully update holiday');
        } catch (Exception $e) {
            Session::flash('error', 'There was an error...');
        } finally {
            return redirect()->route('admin.holidays.index');
        }
    }

    public function show(Holiday $holiday)
    {
            abort_if(Gate::denies('holiday_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
            return view('admin.holiday.show', compact('holiday'));
    }

    public function destroy(Holiday $holiday)
    {
        try {
            $holiday->delete();
            Session::flash('message', 'You have successfully delete holiday!'); 
        } catch (\Exception $e) {
            Session::flash('error', 'Delete failed');
        } finally {
            return redirect()->route('admin.holidays.index');
        }
    }
}
