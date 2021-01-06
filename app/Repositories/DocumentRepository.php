<?php


namespace App\Repositories;

use App\Models\Debrief;
use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;

class DocumentRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Document();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): Document
    {
        $this->model->student()->associate(Student::find($data['student']));
        $this->model->documentType()->associate(DocumentType::find($data['document_type']));
        if($data['debrief']) {
            $this->model->debrief()->associate(Debrief::find($data['debrief']));
        }
        return $this->store($data);
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): Document
    {
        if($data['document_type']) {
            $this->model->documentType()->associate(DocumentType::find($data['document_type']));
        }
        if($data['student']) {
            $this->model->student()->associate(Student::find($data['student']));
        }
        if($data['debrief']) {
            $this->model->debrief()->associate(Debrief::find($data['debrief']));
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
