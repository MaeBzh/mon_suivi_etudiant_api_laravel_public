<?php

namespace Tests\Unit;

use App\Http\Resources\DocumentResource;
use App\Models\Debrief;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Student;
use App\Models\User;
use Auth;
use Tests\TestCase;

class DocumentTest extends TestCase
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
        Document::exists() || Document::factory()->times(2)->create();
        $expectedResponseContent = DocumentResource::collection(Document::all())->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/documents')
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
        Document::exists() || Document::factory()->create();
        $document = Document::latest('id')->first();
        $expectedResponseContent = (new  DocumentResource($document))->toArray(request());

        $this->actingAs($this->adminUser)->get('/api/documents/' . $document->getKey())
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
        $document = Document::factory()->make();
        $documentType = DocumentType::factory()->create();
        $student = Student::factory()->create();
        $debrief = Debrief::factory()->create();

        $data = [
            'filename' => $document->filename,
            'relative_path' => $document->relative_path,
            'disk' => $document->disk,
            'extension' => $document->extension,
            'document_type' => $documentType->getKey(),
            'student' => $student->getKey(),
            'debrief' => $debrief->getKey()
        ];

        $response = $this->actingAs($this->adminUser)->postJson('/api/documents', $data);
        if (($e = $response->exception) && get_class($e) !== ValidationException::class) {
            dd($response->exception);
        }

        $createdDocument = Document::latest('id')->first();

        $expectedResponseContent = (new DocumentResource($createdDocument))->toArray(request());

        $response->assertCreated()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        // $this->actingAs($this->unauthorizedUser)->postJson('/api/documents', $data)
        //     ->assertForbidden();

        // $this->assertTrue(Auth::attempt(['email' => $documentType->email, 'password' => 'password']));
    }

    /**
     * Test the update of a model.
     *
     * @return void
     */
    public function testUpdate()
    {
        Document::exists() || Document::factory()->create();
        $document = Document::latest('id')->first();

        $documentType = DocumentType::factory()->create();
        $student = Student::factory()->create();
        $debrief = Debrief::factory()->create();

        $data = [
            'filename' => $document->filename,
            'relative_path' => $document->relative_path,
            'disk' => $document->disk,
            'extension' => $document->extension,
            'document_type' => $documentType->getKey(),
            'student' => $student->getKey(),
            'debrief' => $debrief->getKey()
        ];

        $response = $this->actingAs($this->adminUser)->putJson('/api/documents/' . $document->getKey(), $data);
        if ($response->exception) {
            dd($response->exception);
        }

        $document = $document->fresh();

        $expectedResponseContent = (new DocumentResource($document))->toArray(request());

        $response->assertOk()
            ->assertJson([
                'data' => $expectedResponseContent
            ]);

        // $this->actingAs($this->unauthorizedUser)->putJson('/api/documents/' . $tutor->getKey(), $data)
        //     ->assertForbidden();
    }

    public function testDelete()
    {
        Document::exists() || Document::factory()->create();
        $document = Document::latest('id')->first();

        $this->actingAs($this->adminUser)->delete('/api/documents/' . $document->getKey());
        $this->assertSoftDeleted('documents', [
            'id' => $document->getKey()
        ]);
    }

}
