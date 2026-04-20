<?php

namespace App\Tests;

use App\Service\AuthService;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase
{
   public function testUserCanRegister()
   {
        $authService = new AuthService();
        $user = $authService->register('testuser@boomwerk.com', 'password123');

        $this->assertEquals('testuser@boomwerk.com', $user->getEmail());
        $this->assertNotEmpty($user->getPassword());

        
   }
}
