<?php

namespace App\Controller;

use App\Entity\Uzytkownicy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UzytkownicyRepository;

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
     * @Route("/login", name="Logowanie")
     */
    public function Logowanie(Request $request, UzytkownicyRepository $usersRep) : Response
    {
        //TODO: zrobic regexy na textboxy w php- html mozna zmienic (chociaz tutaj to jeden kit)

        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $userFromDb  = $usersRep->findOneBy(array('username' => $username));

        if($userFromDb != null)
        { 
            if(!password_verify($password, $userFromDb->getPassword())) //warunek weryfikujący poprawność hasła - szyfruje hasło i porównuje z zaszyfrowanym hasłem
            { 
                return $this->render('login/login.html.twig',[
                    'error' => 'Błędne hasło'
                ]);
            } 
        }
        else
        {
            return $this->render('login/login.html.twig',[
                'error' => 'Błędny login'
            ]);
        }

        // $_SESSION['user']=$user;  //ustawienie zmiennej user w sesji serwera
        //unset($_SESSION['badPass']);
        return $this->redirect('http://localhost:8000/home');
    }
    
}
