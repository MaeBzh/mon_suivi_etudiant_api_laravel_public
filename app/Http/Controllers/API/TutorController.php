<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TutorResource;
use App\Models\Address;
use App\Models\Company;
use App\Models\Tutor;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\TutorRepository;
use App\Repositories\UserRepository;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TutorController extends Controller
{
    protected TutorRepository $tutorRepo;
    protected UserRepository $userRepo;
    protected CompanyRepository $companyRepo;

    public function __construct()
    {
        $this->tutorRepo = new TutorRepository();
        $this->userRepo = new UserRepository();
        $this->addressRepo = new AddressRepository();
        $this->companyRepo = new CompanyRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return TutorResource::collection(Tutor::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tutor = DB::transaction(function () use($request){
            $user = $this->userRepo->prepareStore($request->all());
            if($request->input('company.id')) {
                $company = Company::find($request->input('company.id'));
            } else {
                $companyAddress = $this->addressRepo->prepareStore($request->input('company.address'));
                $company = $this->companyRepo->prepareStore($request->input('company'), $companyAddress);
            }
            return $this->tutorRepo->prepareStore($user, $company);
        });

        return new TutorResource($tutor);
    }


    /**
     * Show the specified resource.
     *
     * @param  Tutor $tutor
     * @return TutorResource
     */
    public function show(Tutor $tutor): TutorResource
    {
        return new TutorResource($tutor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tutor $tutor)
    {
        $updatedTutor = DB::transaction(function () use($request, $tutor) {
            $this->userRepo->setModel($tutor->user);
            $this->userRepo->prepareUpdate($request->all());
            $this->tutorRepo->setModel($tutor);

            if ($request->filled('company')) {
                $updatedTutor = $this->changeTutorCompany($request, $tutor);
            } else {
                $updatedTutor = $this->tutorRepo->prepareUpdate($request->all());
            }
            return $updatedTutor;
        });

        return new TutorResource($updatedTutor);
    }

    public function changeTutorCompany(Request $request, Tutor $tutor): Tutor {
        if($request->filled('company.id')) {
            if ($request->input('company.id') !== $tutor->company->id) {
                $tutor->company()->associate(Company::find($request->input('company.id')));
            } else {
                $this->companyRepo->setModel($tutor->company);
                $this->companyRepo->prepareUpdate($request->input('company'));
            }
        } else {
            $address = (new AddressRepository)->prepareStore($request->input('company.address'));
            $company = $this->companyRepo->prepareStore($request->input('company'), $address);
            $tutor->company()->associate($company);

        }
        return $tutor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tutor  $tutor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tutor $tutor)
    {
        return $this->tutorRepo->delete($tutor);
    }
}
