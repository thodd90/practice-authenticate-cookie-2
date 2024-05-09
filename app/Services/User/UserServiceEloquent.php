<?php

namespace App\Services\User;

use App\Exceptions\ObjectNotFoundException;
use App\Models\User;

class UserServiceEloquent implements UserService {

    public function isExistByEmail(string $email): void
    {
       $user = User::emailExist($email);
    }

    public function findById(int $id)
    {
        $user = User::find($id);

        if(!$user) throw new ObjectNotFoundException('User with id ' . $id . ' not found');

        return $user;
    }
}
