<?php


namespace App\Repositories;

use App\Models\DiplomaSkillTemplate;
use Illuminate\Database\Eloquent\Model;

class DiplomaSkillTemplateRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new DiplomaSkillTemplate();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): DiplomaSkillTemplate
    {
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): DiplomaSkillTemplate
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
