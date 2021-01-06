<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DebriefStoreRequest;
use App\Http\Requests\DebriefUpdateRequest;
use App\Http\Resources\DebriefResource;
use App\Models\Contact;
use App\Models\Debrief;
use App\Models\Student;
use App\Models\Tutor;
use App\Repositories\ContactRepository;
use App\Repositories\DebriefRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TutorRepository;
use Auth;
use DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

use function GuzzleHttp\Promise\all;

class DebriefController extends Controller
{

    protected DebriefRepository $debriefRepo;
    protected TutorRepository $tutorRepo;
    protected StudentRepository $studentRepo;
    protected ContactRepository $contactRepo;

    public function __construct() {
        $this->debriefRepo = new DebriefRepository();
        $this->tutorRepo = new TutorRepository();
        $this->studentRepo = new StudentRepository();
        $this->contactRepo = new ContactRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index() : ResourceCollection
    {
        return DebriefResource::collection(Debrief::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DebriefStoreRequest $request)
    {
        $debrief = DB::transaction(function () use($request){
            $tutor = Auth::user()->tutor;
            $student = Student::find($request->student);
            $contact = Contact::find($request->contact);
            return $this->debriefRepo->prepareStore($request->all(), $tutor, $student, $contact);
        });
        return new DebriefResource($debrief);
    }


    /**
     * Show the specified resource.
     *
     * @param  Debrief $debrief
     * @return DebriefResource
     */
    public function show(Debrief $debrief) : DebriefResource
    {
        return new DebriefResource($debrief);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Debrief  $debrief
     * @return \Illuminate\Http\Response
     */
    public function update(DebriefUpdateRequest $request, Debrief $debrief, Tutor $tutor, Student $student, Contact $contact)
    {
        $debrief = DB::transaction(function () use($request, $debrief, $tutor, $student, $contact){
            return $this->debriefRepo->setModel($debrief)->prepareUpdate($request->all(), $debrief, $tutor, $student, $contact);
        });
        return new DebriefResource($debrief);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Debrief  $debrief
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debrief $debrief)
    {
        return $this->debriefRepo->delete($debrief);
    }
}
