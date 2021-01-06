<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebriefResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result =[
            'id' => $this['id'],
            'date' => $this['date'],
            'summary' => $this['date'],
            'tutor' => (new TutorResource($this->resource->tutor))->toArray($request),
            'student' => (new StudentResource($this->resource->student))->toArray($request),
            'contact' => (new ContactResource($this->resource->contact))->toArray($request)
        ];

        return array_filter($result);
    }
}
