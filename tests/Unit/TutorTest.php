<?php

namespace Tests\Unit;

use App\Http\Resources\TutorResource;
use App\Models\Company;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Auth;
use Tests\TestCase;

class TutorTest extends TestCase
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
        Tutor::exists() || Tutor::factory()->times(2)->create();
        $expectedResponseContent = TutorResource::collection(Tutor::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/tutors')
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
        Tutor::exists() || Tutor::factory()->create();
        $tutor = Tutor::latest('id')->first();
        $expectedResponseContent = (new  TutorResource($tutor))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/tutors/' . $tutor->getKey())
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
        $user = User::factory()->make();
        $company = Company::factory()->make();

        $data = [
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'phone' => $user->phone,
            'password' => 'password',
            'company' => [
                'name' => $company->name,
                'address' => [
                    "address1" => $company->address->address1,
                    "address2" => $company->address->address2,
                    "zipcode" => $company->address->zipcode,
                    "city" => $company->address->city,
                ]

            ]
        ];

        $response = $this->actingAs($this->adminUser)->postJson('/api/tutors', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdTutor = Tutor::latest('id')->first();

        $expectedResponseContent = (new TutorResource($createdTutor))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        // $this->actingAs($this->unauthorizedUser)->postJson('/api/tutors', $data)
        //     ->assertForbidden();

        // $this->assertTrue(Auth::attempt(['email' => $user->email, 'password' => 'password']));
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Tutor::exists() || Tutor::factory()->create();
        $tutor = Tutor::latest('id')->first();

        $newUser = User::factory()->make();
        $newCompany = Company::factory()->make();

        $data = [
            'email' => $newUser->email,
            'firstname' => $newUser->firstname,
            'lastname' => $newUser->lastname,
            'phone' => $newUser->phone,
            'company' => [
                'id' => $tutor->company->getKey(),
                'name' => $newCompany->name,
                'address' => [
                    "address1" => $newCompany->address->address1,
                    "address2" => $newCompany->address->address2,
                    "zipcode" => $newCompany->address->zipcode,
                    "city" => $newCompany->address->city,
                ]

            ]
        ];

        $response = $this->actingAs($this->adminUser)->putJson('/api/tutors/' . $tutor->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $tutor = $tutor->fresh();

        $expectedResponseContent = (new TutorResource($tutor))->toArray(request());

        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        // $this->actingAs($this->unauthorizedUser)->putJson('/api/tutors/' . $tutor->getKey(), $data)
        //     ->assertForbidden();
    }

    public function testDelete()
    {
        Tutor::exists() || Tutor::factory()->create();
        $tutor = Tutor::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/tutors/' . $tutor->getKey());
        $this->assertSoftDeleted('tutors', [
            'id' => $tutor->getKey()
        ]);
    }
}
