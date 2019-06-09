<?php

namespace App\Controller;

use App\Entity\Uzytkownicy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

 /**
     * @Route("/login", name="login.")
     */
class LoginController extends AbstractController
{
    /**
     * @Route("/", name="login")
     */
    public function index()
    {
        return $this->render('login/index.html.twig', [
        ]);
    }

    /**
     * @Route("/Logowanie", name="Logowanie")
     */
    public function Logowanie($username, $password, $town)
    {
        $register = new Uzytkownicy();
        $register->setUsername($username);
        $register->setPassword($password);
        $register->setTown($town);
        $em = $this->getDoctrine()->getManager();
        $em->persist($register);
        $em->flush();

        return $this->render('login/moniaCos.html.twig', [
            'controller_name' => 'LoginController',
            'parametr_monia' => $username.$password.$town,
        ]);
    }
    
}
