<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UzytkownicyRepository;
use App\Entity\Uzytkownicy;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
     * @Route("/register", name="register")
     */
class RegisterController extends AbstractController
{
    
   /**
     * @Route("/", name="register"), methods={"GET"}
     */
    public function index()
    {
        return $this->render('register/register.html.twig');
    }

    /**
     * @Route("/create", name="create"), methods={"POST"}
     */
    public function create(Request $request, UzytkownicyRepository $usersRep) : Response
    { 
        //TODO: zrobic regexy na textboxy w php- html mozna zmienic

        $username = $_POST['username'];
        $password =  password_hash($_POST['password'], PASSWORD_BCRYPT);    //hashowanie hasła
        $town = $_POST['town'];

        if($usersRep->findOneBy(array('username' => $username)) != null)    //jeżeli uzytkownik o takim username juz istnieje
        {
            return $this->render('register/register.html.twig',[
                'error' => 'Użytkownik o takiej nazwie już istnieje'
            ]);
        }

        $uzytkownicy = new Uzytkownicy();
        $uzytkownicy->setUsername($username);
        $uzytkownicy->setPassword($password);
        $uzytkownicy->setTown($town);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($uzytkownicy);
        $entityManager->flush();

        return $this->redirect('http://localhost:8000/login');
    }

     /**
     * @Route("/userslst", name="userslst")
     */
    public function userslst(UzytkownicyRepository $uzytkownicyRepository)
    {
        $user = $uzytkownicyRepository->findAll();
        return $this->render('register/UsersLst.html.twig', [
            'user' => $user
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
