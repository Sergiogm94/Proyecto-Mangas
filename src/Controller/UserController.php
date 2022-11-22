<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route("/createUser", name: "createUser")]
    public function createUser(EntityManagerInterface $doctrine, Request $request, UserPasswordHasherInterface $hasher)
    {
        $form = $this -> createForm(UserType::class);
        $form -> handleRequest($request);
        if($form -> isSubmitted() && $form -> isValid()){
            $user = $form -> getData();
            $user -> setPassword($hasher -> hashPassword($user, $user -> getPassword()));
            $user -> setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $doctrine -> persist($user);
            $doctrine -> flush();
            $this -> addFlash("Éxito", "Usuario insertado correctamente");
        }
        return $this -> renderForm("Users/CreateUser.html.twig", ["Userform" => $form]);
    }
}
