<?php

namespace Tests\Unit;

use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ContactTest extends TestCase
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
        Contact::exists() || Contact::factory()->times(2)->create();
        $expectedResponseContent = ContactResource::collection(Contact::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/contacts')
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
        Contact::exists() || Contact::factory()->create();
        $contact = Contact::latest()->first();
        $expectedResponseContent = (new  ContactResource($contact))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/contacts/' . $contact->getKey())
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
        $data = Contact::factory()->make()
            ->toArray();

        $response = $this->actingAs($this->adminUser)->postJson('/api/contacts', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/contacts', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Contact::exists() || Contact::factory()->create();
        $contact = Contact::latest()->first();
        $newContact = Contact::factory()->make();

        $data = array_merge($contact->toArray(), $newContact->toArray());

        $response = $this->actingAs($this->adminUser)->putJson('/api/contacts/' . $contact->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $contact = $contact->fresh();
        $expectedResponseContent = (new ContactResource($contact))->toArray(request());

        $response->assertOk()
        ->assertJson([
            'data' =>
            $expectedResponseContent
        ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/contacts/' . $contact->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        Contact::exists() || Contact::factory()->create();
        $contact = Contact::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/contacts/' . $contact->getKey());
        $this->assertSoftDeleted('contacts', [
            'id' => $contact->getKey()
        ]);
    }
}
