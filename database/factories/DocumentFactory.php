<?php

namespace Database\Factories;

use App\Models\Debrief;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory

{
    protected $model = Document::class;

    public function definition()
    {
        return [
            'filename' => $this->faker->words($nb=4, $asTest=true).$this->faker->fileExtension,
            'relative_path' => $this->faker->url,
            'extension' => $this->faker->fileExtension,
            'disk' => 'local',
            'document_type_id' => DocumentType::factory(),
            'debrief_id' => Debrief::all()->random()->getKey(),
            'student_id' => Student::all()->random()->getKey(),
        ];
    }
}

