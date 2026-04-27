<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class AuthService
{
    public function __construct(private UserRepository $repo)
    {}
    
    public function Auth(string $email, string $password)
    {
        
    }

 
    
} 