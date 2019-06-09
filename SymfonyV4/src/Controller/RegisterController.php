<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UzytkownicyRepository;
use App\Entity\Uzytkownicy;

/**
     * @Route("/register", name="register")
     */
class RegisterController extends AbstractController
{
    
   /**
     * @Route("/", name="register")
     */
    public function index()
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'parametr_monia' => 3,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function Create(Uzytkownicy $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        return $this->render('uzytkownicy/', [
        ]);
    }

     /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Uzytkownicy $user)
    {
        return $this->render('register/show.html.twig', [
            'user' => $user
        ]);
    }
}
