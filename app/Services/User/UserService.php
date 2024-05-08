<?php
namespace App\Services\User;

interface UserService {

    public function isExistByEmail(string $email);
}
