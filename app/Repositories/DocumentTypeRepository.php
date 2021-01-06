<?php


namespace App\Repositories;

use App\Models\DocumentType;
use Illuminate\Database\Eloquent\Model;

class DocumentTypeRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new DocumentType();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): DocumentType
    {
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): DocumentType
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
