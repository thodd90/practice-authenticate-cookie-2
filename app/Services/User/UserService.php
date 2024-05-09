<?php
namespace App\Services\User;

interface UserService {

    public function isExistByEmail(string $email);

    public function findById(int $id);
}
