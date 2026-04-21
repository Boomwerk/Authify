<?php

namespace App\Controller;

use App\DTO\DTORegister;
use App\Repository\UserRepository;
use App\Service\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class AppController extends AbstractController
{
    public function __construct(private UserRepository $repo){}

    #[Route('/register', name: 'register', methods:["POST"])]
    public function register(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        
        if(!$request->headers->contains("Content-Type", "application/json")){
            return $this->json(["message" => "ContentType must be application/json"], 405);
        }

        $data = json_decode($request->getContent(), true);

        $dto = new DTORegister();
        $dto->email = $data["email"] ?? '';
        $dto->password = $data["password"] ?? '';

        $errors = $validator->validate($dto);

        if(count($errors) > 0)
        {

            return $this->json(["errors" => (string) $errors],400);    
        }


        try{

            $auth = new AuthService($this->repo);

            $user = $auth->register($dto->email,$dto->password);
        
            $em->persist($user);
            $em->flush(); 
            return $this->json(["Message" => "Enregistrement réussi"],201);

        }catch(\Exception $e){
            return $this->json(["Message" => $e->getMessage()], 503);
        }

 
    }


    #[Route('/auth', name: 'auth', methods:["POST"])]
    public function login(Request $request)
    {

        if(!$request->headers->contains("Content-Type", "application/json")){
            return $this->json(["message" => "ContentType must be application/json"], 405);
        }


        $data = json_decode($request->getContent());

        


    }
}
