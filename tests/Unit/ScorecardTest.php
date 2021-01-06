<?php

namespace Tests\Unit;

use App\Http\Resources\ScorecardResource;
use App\Models\Diploma;
use App\Models\Scorecard;
use App\Models\ScorecardSkill;
use App\Models\Skill;
use App\Models\SkillTemplate;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class ScorecardTest extends TestCase
{
    public User $adminUser;
    public User $unauthorizedUser;

    /**
     * Set up the variables for the tests.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::admin()->first();
        $this->unauthorizedUser = User::isStudent()->first();
    }

    /**
     * Test the index.
     *
     * @return void
     */
    public function testIndex()
    {
        Scorecard::exists() || Scorecard::factory()->times(2)->create();
        $expectedResponseContent = ScorecardResource::collection(Scorecard::all())->toArray(request());
        $this->actingAs($this->adminUser)->get('/api/scorecards')
            ->assertOk()
            ->assertJson([
                'data' =>
                $expectedResponseContent
            ]);
    }

    /**
     * Test the show of one model.
     *
     * @return void
     */
    public function testShow()
    {
        Scorecard::exists() || Scorecard::factory()->create();
        $scorecard = Scorecard::latest('id')->first();

        $expectedResponseContent = (new  ScorecardResource($scorecard))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/scorecards/' . $scorecard->getKey())
            ->assertOk()
            ->assertJson([
                'data' =>
                $expectedResponseContent
            ]);
    }

    /**
     * Test the store of a model.
     *
     * @return void
     */
    public function testStore()
    {
        $data['creator_id'] = $this->adminUser->getKey();
        $data['diploma_id'] = Diploma::factory()->create()->getKey();
        $data['student_id'] = Student::factory()->create()->getKey();
        $skillTemplates = SkillTemplate::factory()->times(5)->create();
        foreach($skillTemplates as $skillTemplate) {
            $skill['state'] = ScorecardSkill::MASTERED;
            $skill['skill_template_id'] = $skillTemplate->getKey();
            $data['skills'][] = $skill;

        }

        $response = $this->actingAs($this->adminUser)->postJson('/api/scorecards', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdScorecard = Scorecard::latest('id')->first();

        $expectedResponseContent = (new ScorecardResource($createdScorecard))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/scorecards', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Scorecard::exists() || Scorecard::factory()->create();
        /** @var Scorecard $scorecard */
        $scorecard = Scorecard::latest()->first();
        $newScorecard = Scorecard::factory()->make();
        $skillTemplates = SkillTemplate::factory()->times(5)->create();
        $data['name'] = $newScorecard->name;
        $data['id'] = $scorecard->getKey();
        $data['creator_id'] = $this->adminUser->getKey();
        $data['diploma_id'] = Diploma::factory()->create()->getKey();
        $data['student_id'] = Student::factory()->create()->getKey();
        foreach($skillTemplates as $skillTemplate) {
            $skill['state'] = ScorecardSkill::MASTERED;
            $skill['skill_template_id'] = $skillTemplate->getKey();
            $data['skills'][] = $skill;
        }



        $response = $this->actingAs($this->adminUser)->putJson('/api/scorecards/' . $scorecard->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $scorecard = $scorecard->fresh();

        $expectedResponseContent = (new ScorecardResource($scorecard))->toArray(request());


        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/scorecards/' . $scorecard->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        Scorecard::exists() || Scorecard::factory()->create();
        $scorecard = Scorecard::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/scorecards/' . $scorecard->getKey());
        $this->assertSoftDeleted('scorecards', [
            'id' => $scorecard->getKey()
        ]);
    }
}
