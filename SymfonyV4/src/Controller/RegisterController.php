<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function index()
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
            'parametr_monia' => 3,
        ]);
    }

    /**
     * @Route("/register/monia", name="monia")
     */
    public function monia()
    {
        return $this->render('register/monia.html.twig', [
            'controller_name' => 'RegisterController',
            'parametr_monia' => 'moniaPaczy',
        ]);
    }

     /**
     * @Route("/register/sk", name="sk")
     */
    public function sk()
    {
        return $this->render('register/sk.html.twig', [
            'controller_name' => 'RegisterController',
            'parametr_monia' => 'sk',
        ]);
    }
}
