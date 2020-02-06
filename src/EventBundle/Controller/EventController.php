<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Event;
use EventBundle\Entity\Participant;
use EventBundle\Form\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    public function ReadeventAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Participant::class)->findAll();
        return $this->render('Event/readevent.html.twig', array(
            'tabs'=>$tab
            // ...
        ));
    }

    public function AddeventAction(Request $request)
    {
        //1.A Create Objet Vide
        $club=new Participant();
        //1.B Create Form
        $form=$this->createForm(ParticipantType::class, $club);

        //2.A Recup
        $form=$form->handleRequest($request);
        //3.A Test form
        if( ($form->isSubmitted()) & ($form->isValid()) ){

            //4.A Creation objet Doctrine
            $em=$this->getDoctrine()->getManager();
            //4.B
            $em->persist($club);
            //5.B
            $em->flush();
            //6.
            return $this->redirectToRoute('_readevent');

        }

        return $this->render('Event/addevent.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function UpdateventAction()
    {
        return $this->render('EventBundle:Event:updatevent.html.twig', array(
            // ...
        ));
    }

    public function DeleteventAction()
    {
        return $this->render('EventBundle:Event:deletevent.html.twig', array(
            // ...
        ));
    }

    public function SearcheventAction()
    {
        return $this->render('EventBundle:Event:searchevent.html.twig', array(
            // ...
        ));
    }

}
