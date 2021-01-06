<?php

namespace Tests\Unit;

use App\Http\Resources\AddressResource;
use App\Http\Resources\DocumentTypeResource;
use App\Models\Address;
use App\Models\DocumentType;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DocumentTypeTest extends TestCase
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
        DocumentType::exists() || DocumentType::factory()->times(2)->create();
        $expectedResponseContent = DocumentTypeResource::collection(DocumentType::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/documentTypes')
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
        DocumentType::exists() || DocumentType::factory()->create();
        $docType = DocumentType::latest()->first();
        $expectedResponseContent = (new  DocumentTypeResource($docType))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/documentTypes/' . $docType->getKey())
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
        $data = DocumentType::factory()->make()->toArray();

        $response = $this->actingAs($this->adminUser)->postJson('/api/documentTypes', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $docType = DocumentType::latest('id')->first();

        $expectedResponseContent =  (new DocumentTypeResource($docType))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->postJson('/api/documentTypes', $data)
            ->assertForbidden();
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        DocumentType::exists() || DocumentType::factory()->create();
        $docType = DocumentType::latest()->first();
        $newDocType = DocumentType::factory()->make();

        $data = array_merge($docType->toArray(), $newDocType->toArray());

        $response = $this->actingAs($this->adminUser)->putJson('/api/documentTypes/' . $docType->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $docType = $docType->fresh();

        $expectedResponseContent = (new AddressResource($docType))->toArray(request());

        $response->assertOk()
            ->assertJson([
                'data' =>
                $expectedResponseContent
            ]);

        $this->actingAs($this->unauthorizedUser)->putJson('/api/documentTypes/' . $docType->getKey(), $data)
            ->assertForbidden();
    }

    public function testDelete()
    {
        DocumentType::exists() || DocumentType::factory()->create();
        $documentType = DocumentType::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/documentTypes/' . $documentType->getKey());
        $this->assertSoftDeleted('document_types', [
            'id' => $documentType->getKey()
        ]);
    }
}
