<?php

namespace EventBundle\Controller;


use EventBundle\Entity\Participant;
use EventBundle\Form\ParticipantType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class ParticipantController extends Controller
{
    public function ReadeventAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Participant::class)->findAll();
        return $this->render('@Event/Participant/readevent.html.twig', array(
            'tabs'=>$tab
            // ...
        ));
    }

    public function AddpAction(Request $request)
    {
        $club = new Participant();
        $form = $this->createForm(ParticipantType::class, $club);

        $form = $form->handleRequest($request);
        if (($form->isSubmitted()) & ($form->isValid())) {

            $em = $this->getDoctrine()->getManager();

/*
                        $club->setChoix($request->get('typeEvent'));

                        if($club->getChoix()=="Cours")
                        {
                            $choix=$em->getRepository(EventsAdmin::class)->findType("Cours");
                            $club->setChoix($choix[0]);
                        }
                        if($club->getChoix()=="Workshop")
                        {
                            $choix=$em->getRepository(EventsAdmin::class)->findType("Workshop");
                            $club->setChoix($choix[0]);
                        }
                        if($club->getChoix()=="Formation")
                        {
                            $choix=$em->getRepository(EventsAdmin::class)->findType("Formation");
                            $club->setChoix($choix[0]);
                        }
*/

            $em->persist($club);
            $em->flush();
            echo "<script>alert('Ajouté avec succès')</script>";
            return $this->redirectToRoute('addp');


        }

        return $this->render('@Event/Participant/addp.html.twig', array(
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
        return $this->redirectToRoute('searchp');
    }




    public function UpdateventAction($nomp,Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(Participant::class)->find($nomp);
        $form=$this->createForm(ParticipantType::class, $club);
        $form=$form->handleRequest($request);

        if( ($form->isSubmitted()) & ($form->isValid()) ){

            $em->flush();
            return $this->redirectToRoute('searchp');
        }

        return $this->render('@Event/Participant/addp.html.twig', array(
            'form'=>$form->createView()
        ));
    }


    public function SearchpAction(Request $request)
    {

        $em=$this->getDoctrine();
        $tab=$em->getRepository(Participant::class)->findAll();

        $input=$request->get('nomp');
        if(isset($input))
        {
            $formation = $em->getRepository(Participant::class)->findNomp($input);

            return $this->render('@Event/Participant/searchp.html.twig', array(
                'formations' => $formation
            ));
        }

        return $this->render('@Event/Participant/searchp.html.twig', array(
            'formations'=>$tab
        ));
    }


    public function TriepAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Participant::class)->tri();
        return $this->render('@Event/Participant/searchp.html.twig', array(
            'tabs'=>$tab
            // ...
        ));
    }




}
