<?php

namespace Tests\Unit;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AddressTest extends TestCase
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
        Address::exists() || Address::factory()->times(2)->create();
        $expectedResponseContent = AddressResource::collection(Address::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/addresses')
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
        Address::exists() || Address::factory()->create();
        $address = Address::latest()->first();
        $expectedResponseContent = (new  AddressResource($address))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/addresses/' . $address->getKey())
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
        $data = Address::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)->postJson('/api/addresses', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $address = Address::latest('id')->first();

        $expectedResponseContent =  (new AddressResource($address))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $data
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/addresses', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Address::exists() || Address::factory()->create();
        $address = Address::latest()->first();
        $newAddress = Address::factory()->make();

        $data = array_merge($address->toArray(), $newAddress->toArray());

        $response = $this->actingAs($this->adminUser)->putJson('/api/addresses/' . $address->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $address = $address->fresh();

        $expectedResponseContent = (new AddressResource($address))->toArray(request());

        $response->assertOk()
            ->assertJson([
                'data' =>
                $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/addresses/' . $address->getKey(), $data)
            ->assertForbidden();
    }
}
