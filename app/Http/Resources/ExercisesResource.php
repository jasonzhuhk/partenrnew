<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExercisesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    //name, contact_person, phone, address, website, commission_cycle, commission_rate
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
   
        ];
    }
}
