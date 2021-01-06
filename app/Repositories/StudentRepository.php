<?php


namespace App\Repositories;

use App\Models\Address;
use App\Models\School;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StudentRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Student();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(User $user, Tutor $tutor, School $school, Address $address): Student
    {
        $this->model->user()->associate($user);
        $this->model->tutor()->associate($tutor);
        $this->model->school()->associate($school);
        $this->model->address()->associate($address);
        return $this->store([]);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(Student $student, User $user = null, Tutor $tutor = null, School $school = null, Address $address = null): Tutor
    {
        if($user){
            $this->model->user()->associate($user);
        }
        if($tutor){
            $this->model->tutor()->associate($tutor);
        }
        if($school){
            $this->model->school()->associate($school);
        }
        if($address){
            $this->model->address()->associate($address);
        }

        return $this->update([]);
    }



    /**
     * Delete a model in database.
     *
     * @return void
     */
    public function delete(Model $model)
    {
        $model->delete();
    }
}
