<?php

namespace App\Services\User;

use App\Models\User;

class UserServiceEloquent implements UserService {

    public function isExistByEmail(string $email)
    {
       $user = User::emailExist($email);
    }
}
