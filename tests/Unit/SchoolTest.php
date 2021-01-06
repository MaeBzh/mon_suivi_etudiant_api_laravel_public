<?php

namespace Tests\Unit;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\SchoolResource;
use App\Models\Address;
use App\Models\Company;
use App\Models\School;
use App\Models\User;
use Tests\TestCase;

class SchoolTest extends TestCase
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
        School::exists() || School::factory()->times(2)->create();
        $expectedResponseContent = SchoolResource::collection(School::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/schools')
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
        School::exists() || School::factory()->create();
        $school = School::latest('id')->first();

        $expectedResponseContent = (new  SchoolResource($school))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/schools/' . $school->getKey())
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
        $data['address'] = Address::factory()->make()->toArray();
        $data['name'] = "School name";

        $response = $this->actingAs($this->adminUser)->postJson('/api/schools', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdSchool = School::latest('id')->first();

        $expectedResponseContent = (new CompanyResource($createdSchool))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/schools', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        School::exists() || School::factory()->create();
        /** @var School $school */
        $school = School::latest()->first();
        $newSchool = School::factory()->make();
        $data['address'] = Address::factory()->make()->toArray();
        $data['name'] = $newSchool->name;
        $data['id'] = $school->getKey();

        $response = $this->actingAs($this->adminUser)->putJson('/api/schools/' . $school->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $school = $school->fresh();

        $expectedResponseContent = (new SchoolResource($school))->toArray(request());


        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/schools/' . $school->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        School::exists() || School::factory()->create();
        $school = School::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/schools/' . $school->getKey());
        $this->assertSoftDeleted('schools', [
            'id' => $school->getKey()
        ]);
    }
}
