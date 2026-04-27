<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class DTOAuth 
{
    #[Assert\NotBlank]
    #[Assert\Email]
    #[Assert\Length(
        min: 3,
        max: 155,
        
    )]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 8,
        max: 255
    )]
    public string $password;

}