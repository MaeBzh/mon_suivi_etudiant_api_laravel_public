<?php


namespace App\Repositories;

use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PasswordResetRepository extends Repository
{

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new PasswordReset();
    }


    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): PasswordReset
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
        PasswordReset::query()->whereEmail($data['email'])->delete();
    }

}
