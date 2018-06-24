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
     * @param User $profile
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
