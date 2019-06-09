<?php

namespace App\Controller;

use App\Entity\Uzytkownicy;
use App\Form\UzytkownicyType;
use App\Repository\UzytkownicyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/uzytkownicy")
 */
class UzytkownicyController extends AbstractController
{
    /**
     * @Route("/", name="uzytkownicy_index", methods={"GET"})
     */
    public function index(UzytkownicyRepository $uzytkownicyRepository): Response
    {
        return $this->render('uzytkownicy/index.html.twig', [
            'uzytkownicies' => $uzytkownicyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="uzytkownicy_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uzytkownicy = new Uzytkownicy();
        $form = $this->createForm(UzytkownicyType::class, $uzytkownicy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($uzytkownicy);
            $entityManager->flush();

            return $this->redirectToRoute('uzytkownicy_index');
        }

        return $this->render('uzytkownicy/new.html.twig', [
            'uzytkownicy' => $uzytkownicy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uzytkownicy_show", methods={"GET"})
     */
    public function show(Uzytkownicy $uzytkownicy): Response
    {
        return $this->render('uzytkownicy/show.html.twig', [
            'uzytkownicy' => $uzytkownicy,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="uzytkownicy_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Uzytkownicy $uzytkownicy): Response
    {
        $form = $this->createForm(UzytkownicyType::class, $uzytkownicy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('uzytkownicy_index', [
                'id' => $uzytkownicy->getId(),
            ]);
        }

        return $this->render('uzytkownicy/edit.html.twig', [
            'uzytkownicy' => $uzytkownicy,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="uzytkownicy_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Uzytkownicy $uzytkownicy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$uzytkownicy->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($uzytkownicy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('uzytkownicy_index');
    }
}
