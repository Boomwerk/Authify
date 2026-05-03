<?php

namespace App\Tests\Services;

use App\Entity\User;
use App\Service\JWTService;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JWTServiceTest extends KernelTestCase
{


    public function testGenerateJwt()
    {
        $jwt = self::getContainer()->get(JWTEncoderInterface::class);

        $jwtService = new JWTService($jwt);
        $user = new User();

        $user->setEmail("test@boomwerk.com");
        $user->setRoles(["ROLE_USER"]);


        $response = $jwtService->generate($user);

        $this->assertStringContainsString("test@boomwerk.com", base64_decode($response));


    }


}