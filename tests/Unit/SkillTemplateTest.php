<?php

namespace Tests\Unit;

use App\Http\Resources\SkillTemplateResource;
use App\Models\SkillTemplate;
use App\Models\User;
use Tests\TestCase;

class SkillTemplateTest extends TestCase
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
        SkillTemplate::exists() || SkillTemplate::factory()->times(2)->create();
        $expectedResponseContent = SkillTemplateResource::collection(SkillTemplate::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/skillTemplates')
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
        SkillTemplate::exists() || SkillTemplate::factory()->create();
        $skillTemplate = SkillTemplate::latest('id')->first();

        $expectedResponseContent = (new  SkillTemplateResource($skillTemplate))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/skillTemplates/' . $skillTemplate->getKey())
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
        $data['name'] = "skill template name";

        $response = $this->actingAs($this->adminUser)->postJson('/api/skillTemplates', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdSkillTemplate = SkillTemplate::latest('id')->first();

        $expectedResponseContent = (new SkillTemplateResource($createdSkillTemplate))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/skillTemplates', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        SkillTemplate::exists() || SkillTemplate::factory()->create();
        /** @var SkillTemplate $company */
        $skillTemplate = SkillTemplate::latest()->first();
        $newSkillTemplate = SkillTemplate::factory()->make();

        $data['name'] = $newSkillTemplate->name;
        $data['id'] = $skillTemplate->getKey();

        $response = $this->actingAs($this->adminUser)->putJson('/api/skillTemplates/' . $skillTemplate->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $skillTemplate = $skillTemplate->fresh();

        $expectedResponseContent = (new SkillTemplateResource($skillTemplate))->toArray(request());


        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/skillTemplates/' . $skillTemplate->getKey(), $data)
            ->assertForbidden();
    }
}
