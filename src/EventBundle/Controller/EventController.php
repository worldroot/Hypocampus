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
        return $this->render('@Event/Event/readevent.html.twig', array(
            'tabs'=>$tab
            // ...
        ));
    }

    public function AddeventAction(Request $request)
    {
        $club = new Participant();
        $form = $this->createForm(ParticipantType::class, $club);

        $form = $form->handleRequest($request);
        if (($form->isSubmitted()) & ($form->isValid())) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            echo "<script>alert('Ajouté avec succès')</script>";


        }

        return $this->render('@Event/Event/addevent.html.twig', array(
            'form'=>$form->createView()
        ));
    }



    public function DeleteventAction($nomp)
    {
        $cnx=$this->getDoctrine()->getManager();
        $d=$cnx->getRepository(Participant::class)->find($nomp);
        $cnx->remove($d);
        $cnx->flush();
        echo "<script>alert('Suppression succeed')</script>";
        return $this->redirectToRoute('_readevent');
    }




    public function UpdateventAction($nomp,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(Participant::class)->find($nomp);
        $form=$this->createForm(ParticipantType::class, $club);
        $form=$form->handleRequest($request);

        if( ($form->isSubmitted()) & ($form->isValid()) ){

            $em->flush();
            return $this->redirectToRoute('_readevent');
        }

        return $this->render('@Event/Event/addevent.html.twig', array(
            'form'=>$form->createView()
        ));
    }


    public function SearcheventAction()
    {
        return $this->render('EventBundle:Event:searchevent.html.twig', array(
            // ...
        ));
    }

}
