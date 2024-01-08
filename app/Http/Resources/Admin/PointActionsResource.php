<?php

namespace App\Http\Resources\Admin;

use App\Models\Point;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PointActionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public function with($request)
    {
        $data_points = Point::where('member_id', Auth::user()->id)->first();

        return [
            'current_point' => $data_points->current_point,
            'month_point' => $data_points->month_point,
        ];
    }
}
