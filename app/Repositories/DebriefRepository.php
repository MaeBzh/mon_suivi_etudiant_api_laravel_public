<?php


namespace App\Repositories;

use App\Models\Contact;
use App\Models\Debrief;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Model;

class DebriefRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Debrief();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data, Tutor $tutor, Student $student, Contact $contact): Debrief
    {
        $this->model->tutor()->associate($tutor);
        $this->model->student()->associate($student);
        $this->model->contact()->associate($contact);
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data, Debrief $debrief): Debrief
    {
        $newData = array_merge($debrief->toArray(), $data);
        return $this->update($newData, $debrief);
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
