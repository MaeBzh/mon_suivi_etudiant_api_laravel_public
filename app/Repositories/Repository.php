<?php


namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository
{

    public $model;

    /**
     * Get the current model.
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }


    /**
     * Set a new model.
     *
     * @param  Model $model
     * @return mixed
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * fillData
     *
     * @param  array $data
     * @return void
     */
    protected function fillData(array $data): void {
        $fillable = $this->model->getFillable();
        $filteredData = array_intersect_key($data, array_flip($fillable));
        $this->model->fill($filteredData);
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    protected function store(array $data): Model
    {     
        $this->fillData($data);
        $this->model->saveOrFail();

        return $this->model;
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    protected function update(array $data): Model
    {
        $this->fillData($data);
        $this->model->update();
        return $this->model;
    }

}
