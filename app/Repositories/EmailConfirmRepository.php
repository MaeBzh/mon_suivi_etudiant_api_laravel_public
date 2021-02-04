<?php


namespace App\Repositories;

use App\Models\EmailConfirm;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmailConfirmRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new EmailConfirm();
    }


    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): EmailConfirm
    {
        $this->delete($data);
        $data['token'] = $this->model->generateToken();
        $data['created_at'] = Carbon::now();
        return $this->store($data);
    }

   /**
     * Delete a model in database.
     *
     * @return void
     */
    public function delete(array $data)
    {
        EmailConfirm::query()->whereEmail($data['email'])->delete();
    }

}
