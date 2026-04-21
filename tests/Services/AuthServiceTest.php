<?php

namespace App\Tests\Services;

use App\Repository\UserRepository;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;



class AuthServiceTest extends TestCase
{
    

    public function testUserCanRegister()
    {
        $repo = $this->createStub(UserRepository::class);

        $authService = new AuthService($repo);

        $user = $authService->register('testuser@boomwerk.com', 'password123');

        $this->assertEquals('testuser@boomwerk.com', $user->getEmail());
        $this->assertNotEmpty($user->getPassword());

    }

    public function testIsPasswordHashed(){

        $repo = $this->createStub(UserRepository::class);
        
        $auth = new AuthService($repo);

        $user = $auth->register("testuser@boomwerk.com","Password123");
        
        $this->assertEquals(password_verify("Password123", $user->getPassword()), true);
        
    }

    

    public function testRegisterWithEmailAlreadyExist(){    

        $repo = $this->createMock(UserRepository::class);

        $repo->expects($this->once())->method('UserExistByMail')->willReturn(true);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("L'email existe déjà, veuillez vous connecter");

        $auth = new AuthService($repo);
        $auth->register("test@test.com", "Password");

        
        
    }
      
}

