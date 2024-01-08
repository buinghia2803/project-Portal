<?php

namespace App\Http\Resources\Manager;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestsManagerResource extends JsonResource
{
    public function toArray($request)
    {
        return $data = [
            'member_full_name' => $this->members->full_name,
            'request_type' => $this->request_type,
            'request_for_date' => $this->request_for_date,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'idcompensation_time' => $this->idcompensation_time,
            'compensation_date' => $this->compensation_date,
            'leave_all_day' => $this->leave_all_day,
            'leave_start' => $this->leave_start,
            'leave_end' => $this->leave_end,
            'leave_time' => $this->leave_time,
            'reason' => $this->reason,
            'status' => $this->status,
            'manager_id' => $this->members->id,
            'manager_full_name' => $this->members->full_name,
            'manager_confirmed_status' => $this->manager_confirmed_status,
            'manager_confirmed_at' => $this->manager_confirmed_at,
            'manager_confirmed_comment' => $this->manager_confirmed_comment,
            'admin_id' => $this->members->id,
            'admin_full_name' => $this->members->full_name,
            'admin_approved_status' => $this->admin_approved_status,
            'admin_approved_at' => $this->admin_approved_at,
            'admin_approved_comment' => $this->admin_approved_comment,
            'error_count' => $this->error_count,
            'created_at' => $this->created_at,
        ];

        // chuyển đổi mảng thành json
        return json_decode(json_encode($data), FALSE);
    }
}
