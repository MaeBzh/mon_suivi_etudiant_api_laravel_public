<?php


namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use App\Models\School;
use Illuminate\Database\Eloquent\Model;

class SchoolRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new School();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data, Address $address): School
    {
        $this->model->address()->associate($address);
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): School
    {
        return $this->update($data);
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
