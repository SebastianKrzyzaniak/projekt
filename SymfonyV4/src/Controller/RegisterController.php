<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use App\Repository\RestaurantRepository;

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
    public function create(Request $request, UserRepository $userRepository, RestaurantRepository $restaurantRepository) : Response
    { 
        //TODO: zrobic regexy na textboxy w php- html mozna zmienic

        $username = $_POST['username'];
        $password =  password_hash($_POST['password'], PASSWORD_BCRYPT);    //hashowanie hasła
        $town = $_POST['town'];

        if($userRepository->findOneBy(array('username' => $username)) != null)    //jeżeli uzytkownik o takim username juz istnieje
        {
            return $this->render('register/register.html.twig',[
                'error' => 'Użytkownik o takiej nazwie już istnieje'
            ]);
        }

        $restaurantsInThisTown = $restaurantRepository->findBy(['town' => $town]);
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setTown($town);
        foreach($restaurantsInThisTown as $restaurant)
        {
            $user->addRestaurant($restaurant);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirect('../login');
    }

    //  /**
    //  * @Route("/userslst", name="userslst")
    //  */
    // public function userslst(UserRepository $userRepository)
    // {
    //     $user = $userRepository->findAll();
    //     return $this->render('register/UsersLst.html.twig', [
    //         'user' => $user
    //     ]);
    // }
}
