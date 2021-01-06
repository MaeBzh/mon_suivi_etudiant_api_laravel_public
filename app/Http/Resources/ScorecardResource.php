<?php

namespace App\Http\Resources;

use App\Models\Diploma;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class ScorecardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $student = Student::find($this->student_id);
        $creator = User::find($this->creator_id);

        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'student' => [
                'firstname' => $student->user->firstname,
                'lastname' => $student->user->lastname
            ],
            'tutor' => [
                'firstname' => $creator->firstname,
                'lastname' => $creator->lastname,
            ],
            'created by' => [
                'firstname' => $creator->firstname,
                'lastname' => $creator->lastname,
            ],
            'diploma' => (Diploma::find($this->diploma_id))->name,
            'skills' => (SkillResource::collection($this->resource->skills))->toArray($request)
        ];

        return array_filter($result);
    }
}
