<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;

/**
     * @Route("/restaurant", name="restaurant")
     */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index($id, RestaurantRepository $restaurant )
    {
        // $r = $restaurant->findAll()[0]->getComments();

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'index'
        ]);
    }

     /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        if(!isset($_POST['username']) ){
        return $this->render('restaurant/add.html.twig', [
            'controller_name' => 'add',
        ]);
        }

        $username = $_POST['username'];
        $town = $_POST['town'];

        move_uploaded_file($_FILES['file']['tmp_name'], "images/".$_FILES['file']['name']);

        $zdjecie = imagecreatefromjpeg("images/fajnypies.jpg"); 

        $x = imagesx($zdjecie);
        $y = imagesy($zdjecie);

        $final_x = 910;
        $final_y = 679;

        $tmp_x = 0;
        $tmp_y = 0;

        // i o to proste skalowanie ;]
        if($y<$x) $tmp_x = ceil(($x-$final_x*$y/$final_y)/2);
        elseif($x<$y) $tmp_y = ceil(($y-$final_y*$x/$final_x)/2);
            
        $nowe_zdjecie = imagecreatetruecolor($final_x, $final_y); 
        imagecopyresampled($nowe_zdjecie, $zdjecie, 0, 0, $tmp_x, $tmp_y, $final_x, $final_y, $x-2*$tmp_x, $y-2*$tmp_y);

        imagejpeg($nowe_zdjecie, "images/".$_FILES['file']['name'], 100);

        return $this->render('restaurant/index.html.twig',[
            'x' => imagesx($nowe_zdjecie),
            'y' => imagesy($nowe_zdjecie)
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
     * @Route("/rate", name="rate")
     */
    public function rate()
    {
        return $this->render('restaurant/rate.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
