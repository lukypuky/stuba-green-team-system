<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Division extends JsonResource
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
            'division_title' => $this->division_title,
            'level' => $this->level,
        ];
    }
}
