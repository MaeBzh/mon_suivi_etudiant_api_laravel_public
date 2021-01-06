<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressStoreRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Repositories\AddressRepository;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AddressController extends Controller
{

    protected AddressRepository $addressRepo;

    public function __construct()
    {
        $this->addressRepo = new AddressRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return AddressResource::collection(Address::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressStoreRequest $request)
    {
        $address = DB::transaction(function () use ($request) {
            return $this->addressRepo->prepareStore($request->all());
        });

        return new AddressResource($address);
    }


    /**
     * Show the specified resource.
     *
     * @param  Address $address
     * @return AddressResource
     */
    public function show(Address $address): AddressResource
    {
        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(AddressUpdateRequest $request, Address $address)
    {
        $address = DB::transaction(function () use ($request, $address) {
            return $this->addressRepo->setModel($address)->prepareUpdate($request->all());
        });
        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        return $this->addressRepo->delete($address);
    }
}
