<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Repositories\DocumentRepository;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

use function GuzzleHttp\Promise\all;

class DocumentController extends Controller
{
    protected DocumentRepository $documentRepo;

    public function __construct() {
        $this->documentRepo = new DocumentRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return DocumentResource::collection(Document::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentStoreRequest $request)
    {
        $document = DB::transaction(function () use ($request){
            return $this->documentRepo->prepareStore($request->all());
        });

        return new DocumentResource($document);
    }


    /**
     * Show the specified resource.
     *
     * @param  Document $document
     * @return DocumentResource
     */
    public function show(Document $document) : DocumentResource
    {
        return new DocumentResource($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentUpdateRequest $request, Document $document)
    {
        $document =  DB::transaction(function () use($request, $document){
            return  $this->documentRepo->setModel($document)->prepareUpdate($request->all());
        });

        return new DocumentResource($document);
    }



    //TODO : write a method to update the address unstead of creating a new when updating document

    /**
     * Remove the specified resource from storage.
     *
     * @param  Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        return $this->documentRepo->delete($document);
    }

}
