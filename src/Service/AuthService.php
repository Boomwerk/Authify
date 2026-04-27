<?php

namespace App\Service;

use App\Repository\UserRepository;
use Exception;

class AuthService
{
    public function __construct(private UserRepository $repo)
    {}
    
    public function auth(string $email, string $password)
    {
        
        if(!$this->repo->UserExistByMail($email)){
            throw new Exception("Le compte n'existe pas , veuillez vous inscrire",405);
        }


        $hash =  $this->repo->FindPasswordByMail($email);

        if(!password_verify($password, $hash))
        {
            throw new Exception("Le mot de passe est incorrect !",405);
        }


        // generation JWT

    }

 
    
} 