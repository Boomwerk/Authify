<?php

namespace App\Tests\Controllers;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppControllerTest extends WebTestCase
{

    public function reset(){

        $container = static::getContainer();

        
        $em = $container->get(EntityManagerInterface::class);

        $repo = $em->getRepository(User::class);

        $user = $repo->findOneBy(["email" => "user@test.com"]);

        if($user){
            $em->remove($user);
            $em->flush();
        }
        
        
    }

    public function testRegisterWithOtherMethod(){

        $client = static::createClient();

        $client->request('GET', "/register", ["email" => "test@boom.com", "password" => "Password123"]);

        $this->assertResponseStatusCodeSame(405);
    }

    public function testRegisterFailRequestOtherJsonContentType(){

        $data = ["email" => "user@test.com", "password" => "Password123"];

        $client = static::createClient();

        $client->request('POST', "/register", $data,[],["CONTENT-TYPE" => "multipart/form-data"]);

        $this->assertResponseStatusCodeSame(405);

    }

    public function testCanRegister(){
        

        $client = static::createClient();

        $client->jsonRequest(
            'POST', 
            "/register",
            [
                'email' => 'user@test.com',
                'password' => 'Password123'
            ]
        );


        $this->assertResponseStatusCodeSame(201); 


        $this->reset();


    }

    
    

    

    public function testRegisterWithBlankField(){
        
    $client = static::createClient();

        $client->jsonRequest(
            'POST', 
            "/register",
            [
                'email' => '',
                'password' => ''
            ]
        );

        $this->assertResponseStatusCodeSame(400);
    }

    public function testAuthWithGetMethod(){

        $client = static::createClient();

        $client->request('GET', "/auth", ["email" => "test@boom.com", "password" => "Password123"]);

        $this->assertResponseStatusCodeSame(405);

    }

    public function testAuthFailRequestOtherJsonContentType(){

        $data = ["email" => "user@test.com", "password" => "Password123"];

        $client = static::createClient();

        $client->request('POST', "/auth", $data,[],["CONTENT-TYPE" => "multipart/form-data"]);

        $this->assertResponseStatusCodeSame(405);

    }


}