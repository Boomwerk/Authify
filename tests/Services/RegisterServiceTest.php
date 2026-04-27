<?php


namespace App\Tests\Services;

use App\Repository\UserRepository;
use App\Service\RegisterService;
use PHPUnit\Framework\TestCase;

class RegisterServiceTest extends TestCase
{

    public function testUserCanRegister()
    {
        $repo = $this->createStub(UserRepository::class);

        $registerService = new RegisterService($repo);

        $user = $registerService->register('testuser@boomwerk.com', 'password123');

        $this->assertEquals('testuser@boomwerk.com', $user->getEmail());
        $this->assertNotEmpty($user->getPassword());

    }

    public function testIsPasswordHashed(){

        $repo = $this->createStub(UserRepository::class);
        
        $Register = new RegisterService($repo);

        $user = $Register->register("testuser@boomwerk.com","Password123");
        
        $this->assertEquals(password_verify("Password123", $user->getPassword()), true);
        
    }

    

    public function testRegisterWithEmailAlreadyExist(){    

        $repo = $this->createMock(UserRepository::class);

        $repo->expects($this->once())->method('UserExistByMail')->willReturn(true);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("L'email existe déjà, veuillez vous connecter");

        $register = new RegisterService($repo);
        $register->register("test@test.com", "Password");

        
        
    }

}