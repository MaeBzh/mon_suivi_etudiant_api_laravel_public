<?php


namespace App\Repositories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

class AddressRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Address();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): Address
    {
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): Address
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
