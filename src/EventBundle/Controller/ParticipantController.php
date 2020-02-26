<?php

namespace EventBundle\Controller;


use EventBundle\Entity\Certif;
use EventBundle\Entity\EventsAdmin;
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
        return $this->render('@Event/Participant/searchp.html.twig', array(
            'tabs'=>$tab
            // ...
        ));
    }

    public function AddpAction(Request $request)
    {
        $club = new Participant();
        $em=$this->getDoctrine();

        $event = new EventsAdmin();
        $form = $this->createForm(ParticipantType::class, $club);

        $form = $form->handleRequest($request);
        if (($form->isSubmitted()) & ($form->isValid())) {

            $x = 0;
            $list = $em->getRepository(Participant::class)->findAll();
            foreach ($list as $row)
            {
                if($row->getChoix() == $club->getChoix())
                {
                    $x = $x +1;
                }
            }

            $y = $club->getChoix()->getNumeroEvent();

                if($y > $x) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($club);
                    $em->flush();
                    echo "<script>alert('Ajouté avec succès')</script>";
                    $choix = $em->getRepository(EventsAdmin::class)->find($club->getChoix()->getIdev());

                    return $this->render('@Event/EventAdmin/viewparticipant.html.twig', array(
                        'formations' => $choix
                    ));
                }
                else{
                    echo "<script>alert('Capacité event choisi saturé !')</script>";
                }
        }

        return $this->render('@Event/Participant/addp.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function LoginpAction(Request $request)
    {
        $certif = new Certif();
        $em = $this->getDoctrine()->getManager();
        $email = $request->query->get('email');
        $pwid = $request->query->get('passwird');

        $particpants = $em->getRepository(Participant::class)->findParticipant($email);

        foreach($particpants as $pa) {
            $participant = $pa;
            $re = $participant->getReview();
            $c = $certif->getPointc();


            if($participant->getPasswordp() == $pwid )
            {
                $choix = $em->getRepository(EventsAdmin::class)->find($participant->getChoix()->getIdev());

                return $this->render('@Event/EventAdmin/viewparticipant.html.twig', array(
                    'formations' => $choix
                ));
            }

            else
            {
                echo "<script>alert('Vérifier e-mail ou mot de passe !')</script>";
            }
            // break loop after first iteration
            break;
        }

        return $this->render('@Event/Participant/loginp.html.twig', array(

            // ...
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

        return $this->render('@Event/Participant/updatevent.html.twig', array(
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
