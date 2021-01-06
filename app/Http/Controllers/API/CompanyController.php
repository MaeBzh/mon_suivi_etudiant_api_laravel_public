<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyController extends Controller
{
    protected CompanyRepository $companyRepo;
    protected AddressRepository $addressRepo;

    public function __construct() {
        $this->companyRepo = new CompanyRepository();
        $this->addressRepo = new AddressRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return CompanyResource::collection(Company::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyStoreRequest $request)
    {
        $company = DB::transaction(function () use ($request){
            $address = $this->addressRepo->prepareStore($request->address);
            return $this->companyRepo->prepareStore($request->all(), $address);
        });

        return new CompanyResource($company);
    }


    /**
     * Show the specified resource.
     *
     * @param  Company $company
     * @return CompanyResource
     */
    public function show(Company $company) : CompanyResource
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        $company =  DB::transaction(function () use($request, $company){
            if($request->input('address')) {
                if($request->input('address.address_id')) {
                    $address = $this->addressRepo->setModel($company->address)->prepareUpdate($request->input('address'));
                } else {
                    $address = $this->addressRepo->prepareStore($request->input('address'));
                    $company->address()->associate($address);
                }
            }

            return  $this->companyRepo->setModel($company)->prepareUpdate($request->all(), $address);
        });

        return new CompanyResource($company);
    }



    //TODO : write a method to update the address unstead of creating a new when updating company

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        return $this->companyRepo->delete($company);
    }

}
