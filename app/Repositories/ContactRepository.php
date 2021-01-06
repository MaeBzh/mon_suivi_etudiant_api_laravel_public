<?php


namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;

class ContactRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Contact();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): Contact
    {
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): Contact
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
