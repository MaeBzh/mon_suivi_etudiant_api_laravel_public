<?php

namespace Tests\Unit;

use App\Http\Resources\DiplomaResource;
use App\Models\Diploma;
use App\Models\SkillTemplate;
use App\Models\User;
use Tests\TestCase;

class DiplomaTest extends TestCase
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
        Diploma::exists() || Diploma::factory()->times(2)->create();
        $expectedResponseContent = DiplomaResource::collection(Diploma::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/diplomas')
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
        Diploma::exists() || Diploma::factory()->create();
        $diploma = Diploma::latest('id')->first();

        $expectedResponseContent = (new  DiplomaResource($diploma))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/diplomas/' . $diploma->getKey())
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
        $data['skillTemplates'] = SkillTemplate::factory()->times(5)->make()->toArray();
        $data['name'] = "Diploma name";

        $response = $this->actingAs($this->adminUser)->postJson('/api/diplomas', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdDiploma = Diploma::latest('id')->first();

        $expectedResponseContent = (new DiplomaResource($createdDiploma))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/diplomas', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Diploma::exists() || Diploma::factory()->create();
        /** @var Diploma $diploma */
        $diploma = Diploma::latest()->first();
        $newDiploma = Diploma::factory()->make();

        $data['skillTemplates'] = SkillTemplate::factory()->times(5)->make()->toArray();
        $data['name'] = $newDiploma->name;
        $data['id'] = $diploma->getKey();

        $response = $this->actingAs($this->adminUser)->putJson('/api/diplomas/' . $diploma->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $diploma = $diploma->fresh();

        $expectedResponseContent = (new DiplomaResource($diploma))->toArray(request());


        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/diplomas/' . $diploma->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        Diploma::exists() || Diploma::factory()->create();
        $diploma = Diploma::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/diplomas/' . $diploma->getKey());
        $this->assertSoftDeleted('diplomas', [
            'id' => $diploma->getKey()
        ]);
    }
}
