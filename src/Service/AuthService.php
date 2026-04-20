<?php

namespace App\Service;

use App\Entity\User;

class AuthService
{
    public function register(string $email, string $password)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

        return $user;
    }
}