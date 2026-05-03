<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    public function __construct(private UserRepository $repo, private UserPasswordHasherInterface $hasher)
    {}
    
    public function register(string $email, string $password)
    {
    
        if($this->repo->UserExistByMail($email))
        {
            throw new \InvalidArgumentException("L'email existe déjà, veuillez vous connecter");
        }


        
        $user = new User();
        $user->setEmail($email);

        $hashed = $this->hasher->hashPassword($user, $password);

       
        $user->setPassword($hashed);

       

 
        return $user;
    }

 
    
} 