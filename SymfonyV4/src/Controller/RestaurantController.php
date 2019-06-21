<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Functions\Functions;
use App\Entity\Restaurant;
use App\Repository\UserRepository;
use App\Entity\Comments;

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
        $description = $_POST['description'];

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

        return $this->redirectToRoute('restaurantdetail', [
            'id' => $restaurant->getId()
            ]);
    }

     /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, UserRepository $userRepository, RestaurantRepository $restaurantRepository)
    {
        $sessionUserId = $this->get('session')->get('logged')['id'];
        $user = $userRepository->findOneBy(['id' => $sessionUserId]);

        if($user == null)
        {
            $restaurants = $restaurantRepository->findBy(array(), null, 5);
            return $this->render('restaurant/search.html.twig',[
                'lstRestaurantsInfo' => 'Szukaj ~ Oceniaj ~ Komentuj',
                'restaurants' => $restaurants
            ]);
        }

        if(!isset($_POST['select']))
        {
            $restaurants = $user->getRestaurants();
            return $this->render('restaurant/search.html.twig',[
                'lstRestaurantsInfo' => 'Lista restauracji z Twojej okolicy:',
                'restaurants' => $restaurants
            ]);
        }

        if($_POST['select'] == "name")
        {
            $restaurants = $restaurantRepository->findBy(['name' => $_POST['phrase']]);

            return $this->render('restaurant/search.html.twig',[
                'lstRestaurantsInfo' => 'Lista restauracji o nazwie "'.$_POST['phrase'].'":',
                'restaurants' => $restaurants
            ]);
        }

        if($_POST['select'] == "town")
        {
            $restaurants = $restaurantRepository->findBy(['town' => $_POST['phrase']]);            

            return $this->render('restaurant/search.html.twig',[
                'lstRestaurantsInfo' => 'Lista restauracji z miasta '.$_POST['phrase'].":",
                'restaurants' => $restaurants
            ]);
        }
    }

     /**
     * @Route("/rate/{id}", name="rate")
     */
    public function rate($id, Request $request, RestaurantRepository $restaurantRepository)
    {
        $stars = $_POST["rate"];
        $comment = $_POST['comment'];

        $restaurant = $restaurantRepository->findOneBy(['id' => $id]);
        $new_comment = new Comments();
        $new_comment->setComment($comment);
        $new_comment->addRestaurantId($restaurant);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($new_comment);
        $entityManager->flush();

        $restaurant->addComment($new_comment);
        $restaurant->setGrade((($restaurant->getGrade()*$restaurant->getGradesCounter())+$stars)/($restaurant->getGradesCounter()+1));
        $entityManager->persist($restaurant);
        $entityManager->flush();

        //tutaj przyjmujemy oceny, komentarze, zapisujemy i idziemy do detail/{id}
        return $this->redirect("/home");
    }
}
