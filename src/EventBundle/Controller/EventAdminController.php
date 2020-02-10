<?php

namespace EventBundle\Controller;

use EventBundle\Entity\EventsAdmin;
use EventBundle\Form\EventsAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventAdminController extends Controller
{
    public function affichereventAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(EventsAdmin::class)->findAll();
        return $this->render('@Event/EventAdmin/afficherevent.html.twig', array(
            'tabs'=>$tab
            // ...
        ));
    }
    public function addeventAction(Request $request)
    {
        $club = new EventsAdmin();
        $form = $this->createForm(EventsAdminType::class, $club);
        $form = $form->handleRequest($request);

        if (($form->isSubmitted()) & ($form->isValid())) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('afficherevent');


        }
        return $this->render('@Event/EventAdmin/addevent.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function updateEventsAction($idev,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(EventsAdmin::class)->find($idev);
        $form=$this->createForm(EventsAdminType::class, $club);
        $form=$form->handleRequest($request);

        if( ($form->isSubmitted()) & ($form->isValid()) ){

            $em->flush();
            return $this->redirectToRoute('afficherevent');
        }
        return $this->render('@Event/EventAdmin/update_events.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deleteeventsAction($idev)
    {
        $cnx=$this->getDoctrine()->getManager();
        $d=$cnx->getRepository(EventsAdmin::class)->find($idev);
        $cnx->remove($d);
        $cnx->flush();
        echo "<script>alert('Suppression succeed')</script>";
        return $this->redirectToRoute('afficherevent');
    }

    public function searcheventsAction()
    {
        return $this->render('@Event/EventAdmin/searchevents.html.twig', array(
            // ...
        ));
    }

}
