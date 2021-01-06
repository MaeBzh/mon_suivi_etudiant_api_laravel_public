<?php

namespace App\Http\Resources;

use App\Models\DocumentType;
use App\Models\Student;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
        $result = [
            'id' => $this->id,
            'filename' => $this->filename,
            'relative_path' => $this->relative_path,
            'disk' => $this->disk,
            'extension' => $this->extension,
            'document_type' => $this->documentType->name,
            'debrief' => $this->debrief_id,
            'student' => [
                'id' => $student->getKey(),
                'firstname' => $student->user->firstname,
                'lastname' => $student->user->lastname,
            ]
        ];

        return array_filter($result);
    }
}
