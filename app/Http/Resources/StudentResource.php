<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_filter([
            'id' => $this->id,
            'firstname' => $this->user->firstname,
            'lastname' => $this->user->lastname,
            'email' => $this->user->email,
            'password' => $this->user->password,
            'phone' => $this->user->phone,
            'address' => (new AddressResource($this->resource->address))->toArray(request()),
            'school' => (new SchoolResource($this->resource->school))->toArray(request()),
            'tutor' => (new TutorResource($this->resource->tutor))->toArray(request())
        ]);
    }
}
