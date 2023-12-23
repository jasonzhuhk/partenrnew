<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'contact_person' => $this->contact_person,
            'phone' => $this->phone,
            'address' => $this->address,
            'website' => $this->website,
            'commission_cycle' => $this->commission_cycle,
            'commission_rate' => $this->commission_rate,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'verified' =>$this->hasVerifiedEmail(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
