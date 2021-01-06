<?php

namespace Tests\Unit;

use App\Http\Resources\DebriefResource;
use App\Models\Contact;
use App\Models\Debrief;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Carbon\Traits\Date;
use Tests\TestCase;

class DebriefTest extends TestCase
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
        Debrief::exists() || Debrief::factory()->times(2)->create();
        $expectedResponseContent = DebriefResource::collection(Debrief::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/debriefs')
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
        Debrief::exists() || Debrief::factory()->create();
        $debrief = Debrief::latest()->first();
        $expectedResponseContent = (new  DebriefResource($debrief))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/debriefs/' . $debrief->getKey())
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
        $debrief = Debrief::factory()->make();

        $tutor = Tutor::find($debrief['tutor_id']);
        $student = Student::find($debrief['student_id']);
        $contact = Contact::find($debrief['contact_id']);

        $data = [
            'date' => $debrief->date,
            'summary' => $debrief->summary,
            'student' => $student->getKey(),
            'tutor' => $tutor->getKey(),
            'contact' => $contact->getKey()
        ];

        $response = $this->actingAs($this->adminUser)->postJson('/api/debriefs', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $expectedResponseContent = (new DebriefResource(Debrief::latest('id')->first()))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/debriefs', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Debrief::exists() || Debrief::factory()->create();
        $debrief = Debrief::latest()->first();
        $newDebrief = Debrief::factory()->make();

        $tutor = Tutor::find($debrief['tutor_id']);
        $student = Student::find($debrief['student_id']);
        $contact = Contact::find($debrief['contact_id']);

        $data = [
            'date' => $newDebrief->date,
            'summary' => $newDebrief->summary,
            'student' => $student->getKey(),
            'tutor' => $tutor->getKey(),
            'contact' => $contact->getKey()
        ];

        $response = $this->actingAs($this->adminUser)->putJson('/api/debriefs/' . $debrief->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $debrief = $debrief->fresh();
        $expectedResponseContent = (new DebriefResource($debrief))->toArray(request());


        $response->assertOk()
        ->assertJson([
            'data' => $expectedResponseContent
        ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/debriefs/' . $debrief->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        Debrief::exists() || Debrief::factory()->create();
        $debrief = Debrief::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/debriefs/' . $debrief->getKey());
        $this->assertSoftDeleted('debriefs', [
            'id' => $debrief->getKey()
        ]);
    }
}
