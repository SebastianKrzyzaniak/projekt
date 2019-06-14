<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Functions\Functions;
use App\Entity\Restaurant;

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
        // $r = $restaurant->findAll()[0]->getComments();

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'index'
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id, RestaurantRepository $restaurant )
    {
        // $r = $restaurant->findAll()[0]->getComments();

        return $this->render('restaurant/detail.html.twig', [
            'controller_name' => 'detail'
        ]);
    }

     /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        if(!isset($_POST['restaurantName']) ){
        return $this->render('restaurant/add.html.twig', [
            'controller_name' => 'add',
        ]);
        }

        $restaurantName = $_POST['restaurantName'];
        $town = $_POST['town'];

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

        $restaurant = new Restaurant();
        $restaurant->setName($restaurantName);
        $restaurant->setTown($town);
        $restaurant->setImgPath($result_image_path);
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
    public function search()
    {
        return $this->render('restaurant/search.html.twig', [
            'controller_name' => 'search'
        ]);
    }

     /**
     * @Route("/rate/{id}", name="rate")
     */
    public function rate(Request $request)
    {
        return $this->render('restaurant/rate.html.twig', [
            'id' => "ZMIENIC LOGIKE W RESTAURANT.RATE",
        ]);
    }
}
