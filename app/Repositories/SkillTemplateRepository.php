<?php


namespace App\Repositories;

use App\Models\SkillTemplate;
use Auth;
use Illuminate\Database\Eloquent\Model;

class SkillTemplateRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new SkillTemplate();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): SkillTemplate
    {
        $this->model->creator()->associate(Auth::user());
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): SkillTemplate
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
