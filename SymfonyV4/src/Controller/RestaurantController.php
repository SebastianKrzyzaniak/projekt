<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;

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
    public function add()
    {
        return $this->render('restaurant/add.html.twig', [
            'controller_name' => 'add',
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
