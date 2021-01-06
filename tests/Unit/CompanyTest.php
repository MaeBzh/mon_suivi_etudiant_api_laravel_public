<?php

namespace Tests\Unit;

use App\Http\Resources\CompanyResource;
use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class CompanyTest extends TestCase
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
        Company::exists() || Company::factory()->times(2)->create();
        $expectedResponseContent = CompanyResource::collection(Company::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/companies')
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
        Company::exists() || Company::factory()->create();
        $company = Company::latest('id')->first();

        $expectedResponseContent = (new  CompanyResource($company))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/companies/' . $company->getKey())
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
        $data['name'] = "Company name";

        $response = $this->actingAs($this->adminUser)->postJson('/api/companies', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdCompany = Company::latest('id')->first();

        $expectedResponseContent = (new CompanyResource($createdCompany))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/companies', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Company::exists() || Company::factory()->create();
        /** @var Company $company */
        $company = Company::latest()->first();
        $newCompany = Company::factory()->make();

        $data['address'] = Address::factory()->make()->toArray();
        $data['name'] = $newCompany->name;
        $data['id'] = $company->getKey();

        $response = $this->actingAs($this->adminUser)->putJson('/api/companies/' . $company->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $company = $company->fresh();

        $expectedResponseContent = (new CompanyResource($company))->toArray(request());


        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/companies/' . $company->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        Company::exists() || Company::factory()->create();
        $company = Company::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/companies/' . $company->getKey());
        $this->assertSoftDeleted('companies', [
            'id' => $company->getKey()
        ]);
    }
}
