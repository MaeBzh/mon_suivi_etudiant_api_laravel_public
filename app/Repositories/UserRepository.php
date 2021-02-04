<?php


namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository
{
    // public User $model;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareAdminStore(array $data): User
    {
        return $this->prepareStore(array_merge($data, [
            'is_admin' => true
        ]));
    }

    /**
     * Store a model in database.
     *
     * @return Model
     */
    public function prepareStore(array $data): User
    {
        return $this->store(array_merge($data, [
            'password' => Hash::make($data['password'])
        ]));
    }

    /**
     * Update a model in database.
     *
     * @return Model
     */
    public function prepareUpdate(array $data): User
    {
        return $this->update($data);
    }

    public function prepareUpdatePassword(array $data): User {
        return $this->update(array_merge($data, [
            'password' => Hash::make($data['password'])
        ]));
    }

    public function activeAccount() {
        return $this->update(['active' => true]);
    }

    public function verifyAccount() {
        return $this->update(['email_verified_at' => Carbon::now()]);
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
