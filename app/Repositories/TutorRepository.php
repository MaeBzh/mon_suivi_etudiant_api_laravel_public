<?php


namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TutorRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Tutor();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(User $user, Company $company): Tutor
    {
        $this->model->user()->associate($user);
        $this->model->company()->associate($company);
        return $this->store([]);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data, Company $company = null): Tutor
    {
        if ($company) {
            $this->model->company()->associate($company);
        }
        $newData = array_merge($this->model->toArray(), $data);

        return $this->update($newData, $this->model);
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
