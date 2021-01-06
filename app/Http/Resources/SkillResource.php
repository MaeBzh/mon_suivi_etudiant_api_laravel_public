<?php

namespace App\Http\Resources;

use App\Models\ScorecardSkill;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $scorecardSkill = ScorecardSkill::where('skill_id', $this->id)->first();
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'created_by' => [
                'firstname' => $this->creator->firstname,
                'lastname' => $this->creator->lastname,
            ],
            'skill_template' => $this->skillTemplate_id,
            'state' => $scorecardSkill->state
        ];

        return array_filter($result);
    }
}
