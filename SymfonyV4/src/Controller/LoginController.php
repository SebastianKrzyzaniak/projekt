<?php

namespace App\Controller;

use App\Entity\Uzytkownicy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('login/login.html.twig', [
        ]);
    }

    /**
     * @Route("/logowanie", name="Logowanie")
     */
    public function Logowanie(Request $request) : Response
    {
        $uzytkownicy->setUsername($_POST['username']);
        $uzytkownicy->setPassword($_POST['password']);
        $uzytkownicy->setTown($_POST['town']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($uzytkownicy);
        $entityManager->flush();

        return $this->redirect('http://localhost:8000/home');
    }
    
}
