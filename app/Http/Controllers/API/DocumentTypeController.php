<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentTypeStoreRequest;
use App\Http\Requests\DocumentTypeUpdateRequest;
use App\Http\Resources\DocumentTypeResource;
use App\Models\DocumentType;
use App\Repositories\DocumentTypeRepository;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DocumentTypeController extends Controller
{

    protected DocumentTypeRepository $docTypeRepo;

    public function __construct()
    {
        $this->docTypeRepo = new DocumentTypeRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return DocumentTypeResource::collection(DocumentType::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentTypeStoreRequest $request)
    {
        $documentType = DB::transaction(function () use ($request) {
            return $this->docTypeRepo->prepareStore($request->all());
        });

        return new DocumentTypeResource($documentType);
    }


    /**
     * Show the specified resource.
     *
     * @param  DocumentType $docType
     * @return DocumentTypeResource
     */
    public function show(DocumentType $documentType): DocumentTypeResource
    {
        return new DocumentTypeResource($documentType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  DocumentType  $docType
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentTypeUpdateRequest $request,  DocumentType $documentType)
    {
        $documentType = DB::transaction(function () use ($request, $documentType) {
            return $this->docTypeRepo->setModel($documentType)->prepareUpdate($request->all());
        });
        return new DocumentTypeResource($documentType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DocumentType  $docType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentType $documentType)
    {
        return $this->docTypeRepo->delete($documentType);
    }
}
