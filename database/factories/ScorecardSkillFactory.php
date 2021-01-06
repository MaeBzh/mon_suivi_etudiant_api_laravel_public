<?php

namespace Database\Factories;

use App\Models\Scorecard;
use App\Models\ScorecardSkill;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScorecardSkillFactory extends Factory
{
    protected $model = ScorecardSkill::class;

    public function definition()
    {
        $strings = array(ScorecardSkill::NOT_SEEN, ScorecardSkill::IN_PROGRESS, ScorecardSkill::MASTERED);

    return [
        'state' => array_rand($strings),
        'scorecard_id' => function () {
            return Scorecard::factory();
        },
        'skill_id' => function () {
            return Skill::factory();
        }
    ];
    }
}
