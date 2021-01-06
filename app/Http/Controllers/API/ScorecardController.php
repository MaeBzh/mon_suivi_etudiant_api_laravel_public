<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScorecardStoreRequest;
use App\Http\Requests\ScorecardUpdateRequest;
use App\Http\Resources\ScorecardResource;
use App\Models\Scorecard;
use App\Models\Skill;
use App\Models\SkillTemplate;
use App\Models\Student;
use App\Repositories\ScorecardRepository;
use App\Repositories\SkillRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ScorecardController extends Controller
{
    protected ScorecardRepository $scorecardRepo;
    protected SkillRepository $skillRepo;

    public function __construct()
    {
        $this->scorecardRepo = new ScorecardRepository();
        $this->skillRepo = new SkillRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return ScorecardResource::collection(Scorecard::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScorecardStoreRequest $request)
    {
        $scorecard = DB::transaction(function () use($request) {
            $skills = array();
            foreach ($request->skills as $skill) {
                $skillTemplate = SkillTemplate::find($skill['skill_template_id']);
                $newSkill =  $this->skillRepo->setModel(new Skill())->prepareStore($skillTemplate);
                $state = $skill['state'];
                $skills[$newSkill->getKey()] = $state;
            }

            $student = Student::find($request->student_id);
            $date = Carbon::now();

            $name = sprintf('%s %s - %s/%s', $student->user->firstname, $student->user->lastname, $date->month, $date->year);
            $data = $request->all();
            $data['name'] = $name;

            return $this->scorecardRepo->prepareStore($data, $skills, $name, $student);
        });

        return new ScorecardResource($scorecard);
    }


    /**
     * Show the specified resource.
     *
     * @param  Scorecard $scorecard
     * @return ScorecardResource
     */
    public function show(Scorecard $scorecard): ScorecardResource
    {
        return new ScorecardResource($scorecard);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Scorecard  $scorecard
     * @return \Illuminate\Http\Response
     */
    public function update(ScorecardUpdateRequest $request, Scorecard $scorecard)
    {
        $scorecard = DB::transaction(function () use($request, $scorecard){
            $skills = array();
            foreach ($request->skills as $skill) {
                if (array_key_exists('skill_id', $skill)) {
                    $updatedSkill = $this->skillRepo->setModel(Skill::find($skill['skill_id']))->prepareUpdate($skill);
                    $state = $skill['state'];
                    $skills[$updatedSkill->getKey()] = $state;
                }

            }

            return $this->scorecardRepo->setModel($scorecard)->prepareUpdate($request->all(), $skills);

        });

        return new ScorecardResource($scorecard);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Scorecard  $scorecard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scorecard $scorecard)
    {
        return $this->scorecardRepo->delete($scorecard);
    }
}
