<?php

namespace App\Tests\Services;

use App\Repository\UserRepository;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;



class AuthServiceTest extends TestCase
{
    
    public function testLoginWithEmailNoExist()
    {
        $repo = $this->createStub(UserRepository::class);
        $auth = new AuthService($repo);

        $repo->method('findPasswordByMail')->willReturn(null);
        $this->expectException(\Exception::class);

        $auth->auth('EmailNoExist@boom.com', 'Password123!');

    }

    public function testLoginWithBadPassword()
    {

        $repo = $this->createStub(UserRepository::class);
        $auth = new AuthService($repo);

        $repo->method('findPasswordByMail')->willReturn(true);
        $this->expectException(\Exception::class);

        $auth->auth('EmailExist@boom.com', 'Password123!');


    }
   
      
}

