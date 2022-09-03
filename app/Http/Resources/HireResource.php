<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HireResource extends JsonResource
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
            'names' => $this->names,
            'start_date' => $this->start_date->format("d-m-t"),
            'end_date' => $this->end_date->format("d-m-y")
        ];
    }
}
