<?php

namespace App\Http\Controllers\Admin;

use App\Models\RequestModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $auth = 2;
        $affiliate = RequestModel::select(
            'requests.member_id',
            DB::raw("(SELECT COUNT(*) FROM requests where request_type = 1 and requests.member_id = $auth) as request_1"),
            DB::raw("(SELECT COUNT(*) FROM requests where request_type = 3 and requests.member_id = $auth) as request_3"),
            DB::raw("(SELECT COUNT(*) FROM requests where request_type = 4 and requests.member_id = $auth) as request_4"),
            DB::raw("(SELECT COUNT(*) FROM requests where request_type = 5 and requests.member_id = $auth) as request_5"),
        )
        ->whereYear("requests.created_at", date('Y'))
        ->whereMonth("requests.created_at", date('m'))
        ->groupBy('requests.member_id')
        ->where('requests.member_id', $auth)
        ->get()->toArray();
        dd($affiliate);
        return view('home');
    }
}
