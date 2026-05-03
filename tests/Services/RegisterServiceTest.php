<?php


namespace App\Tests\Services;

use App\Repository\UserRepository;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterServiceTest extends KernelTestCase
{

    public function testUserCanRegister()
    {
        $repo = $this->createStub(UserRepository::class);
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);

        $registerService = new RegisterService($repo, $hasher);

        $user = $registerService->register('testuser@boomwerk.com', 'password123');

        $this->assertEquals('testuser@boomwerk.com', $user->getEmail());
        $this->assertNotEmpty($user->getPassword());

    }

    public function testIsPasswordHashed(){

        $repo = $this->createStub(UserRepository::class);
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);
        
        $Register = new RegisterService($repo, $hasher);

        $user = $Register->register("testuser@boomwerk.com","Password123");

        $this->assertEquals($hasher->isPasswordValid($user, "Password123"), true);
        
    }

    

    public function testRegisterWithEmailAlreadyExist(){    

        $repo = $this->createMock(UserRepository::class);
        $hasher = self::getContainer()->get(UserPasswordHasherInterface::class);


        $repo->expects($this->once())->method('UserExistByMail')->willReturn(true);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("L'email existe déjà, veuillez vous connecter");

        $register = new RegisterService($repo, $hasher);
        $register->register("test@test.com", "Password");

        
        
    }

}