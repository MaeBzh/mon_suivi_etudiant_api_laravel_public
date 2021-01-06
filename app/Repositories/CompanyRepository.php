<?php


namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CompanyRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Company();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data, Address $address): Company
    {
        $this->model->address()->associate($address);
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): Company
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
