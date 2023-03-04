<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
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
            'task_title' => $this->task_title,
            'description' =>$this->description,
            'user_id_created' => $this->user_id_created,
            'user_id_assigned' => $this->user_id_assigned,
            'type_id' => $this->type_id,
            'status_id' => $this->status_id,
            'priority_id' => $this->priority_id,
            'division_id' => $this->division_id,
            'area_id' => $this->area_id,
            'deadline' => $this->deadline,
            'hours' => $this->hours,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
