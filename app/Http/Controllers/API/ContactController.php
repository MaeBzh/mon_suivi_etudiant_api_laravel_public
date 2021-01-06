<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Repositories\AddressRepository;
use App\Repositories\ContactRepository;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactController extends Controller
{

    protected AddressRepository $addressRepo;

    public function __construct()
    {
        $this->contactRepo = new ContactRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return ContactResource::collection(Contact::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactStoreRequest $request)
    {
        $contact = DB::transaction(function () use($request) {
            return $this->contactRepo->prepareStore($request->all());
        });
        return new ContactResource($contact);
    }


    /**
     * Show the specified resource.
     *
     * @param  Contact $contact
     * @return ContactResource
     */
    public function show(Contact $contact): ContactResource
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactUpdateRequest $request, Contact $contact)
    {
        $contact = DB::transaction(function () use($request, $contact) {
            return $this->contactRepo->setModel($contact)->prepareUpdate($request->all());
        });
        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        return $this->contactRepo->delete($contact);
    }
}
