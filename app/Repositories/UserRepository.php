<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    use Repository;

    /**
     * @var User
     */
    protected $model;

    /**
     * ProfileRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param $input
     * @return User
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * @param User $model
     * @param array $input
     * @return User
     */
    protected function save($model, $input)
    {
        $model->fill($input);
        $model->save();
        return $model;
    }
}
