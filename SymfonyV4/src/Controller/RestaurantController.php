<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Functions\Functions;
use App\Entity\Restaurant;
use App\Repository\UserRepository;

/**
     * @Route("/restaurant", name="restaurant")
     */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index( RestaurantRepository $restaurant )
    {
        return $this->redirectToRoute('restaurantsearch');
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id, RestaurantRepository $restaurantRepository )
    {
         $restaurant = $restaurantRepository->findOneBy(['id' => $id]);

        return $this->render('restaurant/detail.html.twig', [
            'restaurant' => $restaurant
        ]);
    }

     /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, UserRepository $userRepository)
    {
        if(!isset($_POST['restaurantName']) ){
        return $this->render('restaurant/add.html.twig', [
            'controller_name' => 'add',
        ]);
        }

        $restaurantName = $_POST['restaurantName'];
        $town = $_POST['town'];
        $description = "opis"; //$_POST['description'];

        move_uploaded_file($_FILES['file']['tmp_name'], "images/".$_FILES['file']['name']);

        $dst_width = 910;
        $dst_height = 679;

        //--convert image to custom config
        $result_image_path = Functions::ChangeImageSize("images/".$_FILES['file']['name'],$dst_width, $dst_height);
        //--end
        if($result_image_path == null) //podano zły format zdj
        {
            return $this->render('restaurant/add.html.twig',[
                'error' => "Wamagany format: [*.jpg] / [*.png] / [*.gif] / [*.bmp]"
            ]);
        }


        $userInThisTown = $userRepository->findBy(['town' => $town]);
        $restaurant = new Restaurant();
        $restaurant->setName($restaurantName);
        $restaurant->setTown($town);
        $restaurant->setImgPath($result_image_path);
        $restaurant->setDescription($description);
        foreach($userInThisTown as $user)
        {
            $restaurant->addUser($user);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($restaurant);
        $entityManager->flush();

        return $this->redirectToRoute('restaurantrate', [
            'id' => $restaurant->getId()
            ]);
    }

     /**
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        if(!isset($_POST['select']))
        {
            return $this->render('restaurant/search.html.twig');
        }

        if($_POST['select'] == "name")
        {
            return $this->render('restaurant/search.html.twig',[
                'lstRestaurantsInfo' => 'o nazwie "'.$_POST['phrase'].'"'
            ]);
        }

        if($_POST['select'] == "town")
        {
            return $this->render('restaurant/search.html.twig',[
                'lstRestaurantsInfo' => 'z miasta '.$_POST['phrase']
            ]);
        }
    }

     /**
     * @Route("/rate", name="rate")
     */
    public function rate(Request $request)
    {
        //tutaj przyjmujemy oceny, komentarze, zapisujemy i idziemy do detail/{id}
        return $this->redirect("../home");
    }
}
