<?php

namespace Tests\Unit;

use App\Http\Resources\StudentResource;
use App\Models\Address;
use App\Models\School;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Tests\TestCase;

class StudentTest extends TestCase
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
        Student::exists() || Student::factory()->times(2)->create();
        $expectedResponseContent = StudentResource::collection(Student::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/students')
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
        Student::exists() || Student::factory()->create();
        $student = Student::latest('id')->first();
        $expectedResponseContent = (new  StudentResource($student))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/students/' . $student->getKey())
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
        $school = School::factory()->make();
        $tutor = $this->adminUser->tutor;
        $address = Address::factory()->make();

        $data = [
            'email' => $user->email,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'phone' => $user->phone,
            'password' => 'password',
            'address' => [
                "address1" => $address->address1,
                "address2" => $address->address2,
                "zipcode" => $address->zipcode,
                "city" => $address->city,
            ],
            'school' => [
                'name' => $school->name,
                'address' => [
                    "address1" => $school->address->address1,
                    "address2" => $school->address->address2,
                    "zipcode" => $school->address->zipcode,
                    "city" => $school->address->city,
                ]
            ],
            'tutor_id' => $tutor->getKey()
        ];

        $response = $this->actingAs($this->adminUser)->postJson('/api/students', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdStudent = Student::latest('id')->first();

        $expectedResponseContent = (new StudentResource($createdStudent))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        // $this->actingAs($this->unauthorizedUser)->postJson('/api/students', $data)
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
        Student::exists() || Student::factory()->create();
        $student = Student::latest('id')->first();

        $newUser = User::factory()->make();
        $newSchool = School::factory()->make();
        $newAddress = Address::factory()->make();
        $newTutor = Tutor::factory()->create();

        $data = [
            'email' => $newUser->email,
            'firstname' => $newUser->firstname,
            'lastname' => $newUser->lastname,
            'phone' => $newUser->phone,
            'address' => [
                "id" => $student->address->getkey(),
                "address1" => $newAddress->address1,
                "address2" => $newAddress->address2,
                "zipcode" => $newAddress->zipcode,
                "city" => $newAddress->city,
            ],
            'school' => [
                "id" => $student->school_id,
                'name' => $newSchool->name,
                'address' => [
                    "address1" => $newSchool->address->address1,
                    "address2" => $newSchool->address->address2,
                    "zipcode" => $newSchool->address->zipcode,
                    "city" => $newSchool->address->city,
                ]
            ],
            'tutor_id' => $newTutor->getKey()
        ];
        $response = $this->actingAs($this->adminUser)->putJson('/api/students/' . $student->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $student = $student->fresh();

        $expectedResponseContent = (new StudentResource($student))->toArray(request());

        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        // $this->actingAs($this->unauthorizedUser)->putJson('/api/students/' . $tutor->getKey(), $data)
        //     ->assertForbidden();
    }

    public function testDelete()
    {
        Student::exists() || Student::factory()->create();
        $student = Student::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/students/' . $student->getKey());
        $this->assertSoftDeleted('students', [
            'id' => $student->getKey()
        ]);
    }
}
