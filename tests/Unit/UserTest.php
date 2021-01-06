<?php

namespace Tests\Unit;

use App\Http\Resources\UserResource;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testStore()
    {
        $user = User::admin()->first();

        $data = User::factory()->make()
            ->makeHidden(['email_verified_at'])
            ->makeVisible(['password'])
            ->toArray();

        $response = $this->actingAs($user)->postJson('/api/users', $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $expectedResponseContent = (new UserResource(User::latest('id')->first()))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);
    }
}
