<?php

namespace sprintBundle\Controller;

use sprintBundle\Entity\sprint;
use sprintBundle\Form\sprintType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class sprintController extends Controller
{
    public function createsprintAction(Request $request)
    {


        $sprint = new sprint();
        // creer notre formulaire
        $form=$this->createForm(sprintType::class,$sprint);
        //recuperation de donnesS
        $sprint->setEtat(0);
        $form=$form->handleRequest($request);
        //test sur les donnees
        if($form->isValid())
        {
            //creation d un objet doctrine
            $em=$this->getDoctrine()->getManager();
            //persister les donnees dans ORM
            $em->persist($sprint);
            //sauvegarder les donnees dans BD
            $em->flush();
            return $this->redirectToRoute('affichersprint');
        }
        return $this->render('@sprint/sprint/createsprint.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function affichersprintAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(sprint::class)->findAll();
        return $this->render('@sprint/sprint/affichersprint.html.twig', array(
            'sprint'=>$tab
        ));
    }

    public function updatesprintAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sprint = $em->getRepository(sprint::class)->find($id);


        //Save?
        if ($request->isMethod('POST')) {
            //Mettre a jour
            $startDatesprint = \DateTime::createFromFormat('Y-m-d', $request->get('startDatesprint'));
            $endDatesprint = \DateTime::createFromFormat('Y-m-d', $request->get('endDatesprint'));
            $sprint->setSprintName($request->get('sprintName' ));
            $sprint->setStartDatesprint($startDatesprint);
            $sprint->setEndDatesprint($endDatesprint);


            $em->persist($sprint);
            $em->flush();
            //Rederiger vers read
            return $this->redirectToRoute('affichersprint');
        }
        return $this->render('@sprint/sprint/updatesprint.html.twig', array(
            'form'=>$sprint,'table'=>$sprint
        ));
    }

    public function deletesprintAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $club=$em->getRepository(sprint::class)->find($id);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('affichersprint');
    }

}
