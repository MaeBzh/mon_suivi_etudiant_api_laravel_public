<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\SkillTemplate;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words($nb=6, $asText=true),
            'skill_template_id' => function() {
                return SkillTemplate::factory();
            },
            'creator_id' => function() {
                if(Tutor::query()->exists()){
                    return Tutor::query()->inRandomOrder()->first()->user->getKey();
                }

                return Tutor::factory();
            },
        ];
    }
}
