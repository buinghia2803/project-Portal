<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaveQuotaResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'year' => $this->year,
            'quota' => $this->quota,
            'paid_leave' => $this->paid_leave,
            'unpaid_leave' => $this->unpaid_leave,
            'remain' => $this->remain,
            'requests' => $this->requests->map(function ($request) {
                return [
                    'id' => $request->id,
                    'year' => $request->year,
                    'type' => $request->type,
                    'quota' => $request->quota,
                    'note' => $request->note,
                    'status' => $request->status,
                ];
            }),
        ]; 

        // dd($data);
        
        return (object) $data;  
    }
}
 

