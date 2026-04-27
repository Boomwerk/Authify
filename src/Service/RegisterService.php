<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class RegisterService
{
    public function __construct(private UserRepository $repo)
    {}
    
    public function register(string $email, string $password)
    {
    
        if($this->repo->UserExistByMail($email))
        {
            throw new \InvalidArgumentException("L'email existe déjà, veuillez vous connecter");
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

 
        return $user;
    }

 
    
} 