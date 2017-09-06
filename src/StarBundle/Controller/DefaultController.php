<?php

namespace StarBundle\Controller;

use StarBundle\Entity\Flight;
use StarBundle\Form\FlightType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $flights = $entityManager
            ->getRepository(Flight::class)
            ->findAll();
        return $this->render('StarBundle:Default:index.html.twig', ["flights" => $flights]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(FlightType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $task = $form->getData();
            $entityManager->persist($task);
            $entityManager->flush();
            $this->addFlash('success', "Le vol a bien été ajouté");

            return $this->redirectToRoute('home');
        }
        return $this->render('StarBundle:Default:create.html.twig',['form' => $form->createView()]);
    }
}
