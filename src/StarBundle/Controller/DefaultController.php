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
            ->findBy([], ['horaire' => 'ASC']);
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
        return $this->render('StarBundle:Default:create.html.twig',['form' => $form->createView(), "isAdmin" => true]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $flights = $entityManager
            ->getRepository(Flight::class)
            ->findBy([], ['horaire' => 'ASC']);
        return $this->render('StarBundle:Default:admin.html.twig', ["flights" => $flights, "isAdmin" => true]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function editAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $entityManager->getRepository(Flight::class)->find($id);
        $form = $this->createForm(FlightType::class, $todo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            $this->addFlash('success', "Le vol a bien été modifiée");
            return $this->redirectToRoute('admin');
        }
        return $this->render('StarBundle:Default:edit.html.twig',['form' => $form->createView(), "isAdmin" => true]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     */
    public function deleteAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $todo = $entityManager->getRepository(Flight::class)->find($id);
        $entityManager->remove($todo);
        $entityManager->flush();
        $this->addFlash('success', "Le vol a bien été supprimée");
        return $this->redirectToRoute('admin');
    }
}
