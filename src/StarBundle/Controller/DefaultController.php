<?php

namespace StarBundle\Controller;

use StarBundle\Entity\Flight;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
}
