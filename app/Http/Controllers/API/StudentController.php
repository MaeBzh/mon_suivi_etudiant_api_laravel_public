<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Resources\StudentResource;
use App\Models\School;
use App\Models\Student;
use App\Repositories\AddressRepository;
use App\Repositories\SchoolRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TutorRepository;
use App\Repositories\UserRepository;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;


class StudentController extends Controller
{
    protected TutorRepository $tutorRepo;
    protected UserRepository $userRepo;
    protected SchoolRepository $schoolRepo;
    protected AddressRepository $addressRepo;
    protected StudentRepository $studentRepo;

    public function __construct()
    {
        $this->tutorRepo = new TutorRepository();
        $this->userRepo = new UserRepository();
        $this->addressRepo = new AddressRepository();
        $this->schoolRepo = new schoolRepository();
        $this->studentRepo = new StudentRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        return StudentResource::collection(Student::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request)
    {
        $student = DB::transaction(function () use($request){
            $user = $this->userRepo->prepareStore($request->all());
            $address = $this->addressRepo->prepareStore($request->input('address'));
            if($request->input('school.id')) {
                $school = School::find($request->input('school.id'));
            } else {
                $schoolAddress = $this->addressRepo->prepareStore($request->input('school.address'));
                $school = $this->schoolRepo->prepareStore($request->input('school'), $schoolAddress);
            }
            $tutor = Auth::user()->tutor;
            return $this->studentRepo->prepareStore($user, $tutor, $school, $address);
        });

        return new StudentResource($student);
    }


    /**
     * Show the specified resource.
     *
     * @param  Student $student
     * @return StudentResource
     */
    public function show(Student $student): StudentResource
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $updatedStudent = DB::transaction(function () use($request, $student){

            $this->userRepo->setModel($student->user)->prepareUpdate($request->all());
            $this->studentRepo->setModel($student);

            if ($request->filled('school')) {
                $updatedStudent = $this->changeStudentSchool($request, $student);
            } else {
                $updatedStudent = $this->studentRepo->setModel($student)->prepareUpdate($request->all());
            }

            return $updatedStudent;
        });

        return new StudentResource($updatedStudent);
    }

    public function changeStudentSchool(Request $request, Student $student): Student {
        if($request->filled('school.id')) {
            if ($request->input('school.id') !== $student->school->id) {
                $student->school()->associate(School::find($request->input('school.id')));
            } else {
                $this->schoolRepo->setModel($student->school);
                $this->schoolRepo->prepareUpdate($request->input('school'));
            }
        } else {
            $address = (new AddressRepository)->prepareStore($request->input('school.address'));
            $school = $this->schoolRepo->prepareStore($request->input('school'), $address);
            $student->school()->associate($school);

        }
        return $student;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        return $this->studentRepo->delete($student);
    }
}
