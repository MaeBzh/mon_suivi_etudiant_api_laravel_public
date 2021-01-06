<?php


namespace App\Repositories;

use App\Models\Diploma;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class DiplomaRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Diploma();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data, Collection $skillTemplates): Diploma
    {
        /** @var Diploma $diploma */
        $diploma = $this->store($data);

        $diploma->skillTemplates()->attach($skillTemplates);

        return $diploma;
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data, Collection $skillTemplates): Diploma
    {
        $this->model->skillTemplates()->syncWithoutDetaching($skillTemplates);
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
