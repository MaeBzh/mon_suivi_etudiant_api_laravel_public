<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolStoreRequest;
use App\Http\Requests\SchoolUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\SchoolResource;
use App\Models\School;
use App\Repositories\AddressRepository;
use App\Repositories\SchoolRepository;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolController extends Controller
{
    protected SchoolRepository $schoolepo;
    protected AddressRepository $addressRepo;

    public function __construct() {
        $this->schoolRepo = new SchoolRepository();
        $this->addressRepo = new AddressRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return SchoolResource::collection(School::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolStoreRequest $request)
    {
        $school = DB::transaction(function () use($request) {
            $address = $this->addressRepo->prepareStore($request->address);
            return $this->schoolRepo->prepareStore($request->all(), $address);
        });

        return new SchoolResource($school);
    }


    /**
     * Show the specified resource.
     *
     * @param  School $school
     * @return SchoolResource
     */
    public function show(School $school) : SchoolResource
    {
        return new SchoolResource($school);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  School  $school
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolUpdateRequest $request, School $school)
    {
        $newSchool = DB::transaction(function () use($request, $school){
            if($request->input('address')) {
                if($request->input('address.address_id')) {
                    $address = $this->addressRepo->setModel($school->address)->prepareUpdate($request->input('address'));
                } else {
                    $address = $this->addressRepo->prepareStore($request->input('address'));
                    $school->address()->associate($address);
                }
            }
            return $this->schoolRepo->setModel($school)->setModel($school)->prepareUpdate($request->all(), $address);
        });

        return new CompanyResource($newSchool);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  School  $school
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school)
    {
        return $this->schoolRepo->delete($school);
    }

}
