<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class Report extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' =>$this->description,
            'user_id' => $this->user_id,
            // 'task_id' => $this->task_id,
            'start' => $this->start_time,
            'end' => $this->end_time,
            'color' => $this->color,
            'textColor' => $this->textColor,
            // $this->mergeWhen(Auth::user()->is_admin, [
            //     'name' => $this->user->name,
            //     'email' => $this->user->email,
            // ])
        ];
    }
}
