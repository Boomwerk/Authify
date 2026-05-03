<?php

namespace App\Service;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class JWTService 
{
    public function __construct(
        private JWTEncoderInterface $jwt
    ){}

    public function generate(User $user)
    {

        return $this->jwt->encode([
            "email" => $user->getEmail(),
            "roles" => $user->getRoles()
        ]);
    }

    


}