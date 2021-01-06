<?php

namespace Database\Factories;

use App\Models\Diploma;
use App\Models\DiplomaSkillTemplate;
use App\Models\SkillTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiplomaSkillTemplateFactory extends Factory
{
    protected $model = DiplomaSkillTemplate::class;

    public function definition()
    {
        return [
            'diploma_id' => function () {
                return Diploma::factory();
            },
            'skill_template_id' => function () {
                return SkillTemplate::factory();
            }
        ];
    }
}
