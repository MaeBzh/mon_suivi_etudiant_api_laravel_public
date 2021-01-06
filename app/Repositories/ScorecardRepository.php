<?php


namespace App\Repositories;

use App\Models\Scorecard;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ScorecardRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Scorecard();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data, array $skills): Scorecard
    {
        /** @var scorecard $scorecard */
        $scorecard = $this->store($data);
        foreach($skills as $skill => $state) {
            $scorecard->skills()->attach($skill, ['state' => $state]);
        }


        return $scorecard;
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data, array $skills): Scorecard
    {
        foreach($skills as $skill => $state) {
            $this->model->skills()->syncWithoutDetaching($skill, ['state' => $state]);
        }
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
