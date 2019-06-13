<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/restaurant", name="restaurant")
     */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/{id}", name="index")
     */
    public function index($id )
    {
    

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => $restaurant,
        ]);
    }

     /**
     * @Route("/add", name="add")
     */
    public function add()
    {
        return $this->render('home/add.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

     /**
     * @Route("/search", name="search")
     */
    public function search()
    {
        return $this->render('home/search.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

     /**
     * @Route("/rate", name="rate")
     */
    public function rate()
    {
        return $this->render('home/rate.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
