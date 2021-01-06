<?php


namespace App\Repositories;

use App\Models\ScorecardSkill;
use App\Models\Skill;
use App\Models\SkillTemplate;
use Auth;
use Illuminate\Database\Eloquent\Model;

class SkillRepository extends Repository
{
    protected ScorecardSkillRepository $scorecardSkillRepo;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Skill();
        $this->scorecardSkillRepo = new ScorecardSkillRepository();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(SkillTemplate $skillTemplate): Skill
    {
        $this->model = $this->createFromSkillTemplate($skillTemplate);
        $this->model->creator()->associate(Auth::user());
        return $this->store($this->model->toArray());
    }

    public function createFromSkillTemplate(SkillTemplate $skillTemplate)
    {
        $skill = new Skill();
        $skill->name = $skillTemplate->name;
        $skill->skill_template_id = $skillTemplate->getKey();
        $skill->creator_id = Auth::user()->getKey();
        return $skill;
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): Skill
    {
        if (array_key_exists('state', $data)) {
            $scorecardSkill = ScorecardSkill::where('skill_id', $data['skill_id'])->first();
            $this->scorecardSkillRepo->setModel($scorecardSkill)->update($data);
        }
        return $this->update($data);
    }

    /**
     * Delete a model in database.
     *
     * @return void
     */
    public function delete(Model $model)
    {
        $model->delete();
    }
}
