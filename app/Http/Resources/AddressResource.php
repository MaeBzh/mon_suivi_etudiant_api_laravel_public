<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'zipcode' => $this->zipcode,
            'city' => $this->city
        ];

        return array_filter($result);
    }
}
