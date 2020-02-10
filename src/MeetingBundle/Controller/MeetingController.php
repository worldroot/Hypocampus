<?php

namespace MeetingBundle\Controller;

use MeetingBundle\Entity\Meeting;
use MeetingBundle\Form\MeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MeetingController extends Controller
{
    public function createMeetingAction(Request $request)
    { $meeting = new meeting();
        $form=$this->createForm(MeetingType::class,$meeting);
        $form=$form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($meeting);
            $em->flush();
            return $this->redirectToRoute('read_meeting');
        }
        return $this->render('@Meeting/meeting/create_Meeting.html.twig', array(
            'form'=>$form->createView()
        ));

    }

    public function readMeetingAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Meeting::class)->findAll();
        return $this->render('@Meeting/meeting/read_meeting.html.twig', array(
            "meetings" => $tab
        ));


    }

    public function updateMeetingAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository(Meeting::class)->find($id);


        //Save?
        if ($request->isMethod('POST')) {
            //Mettre a jour
            $meeting->setDescription($request->get('description'));
            $meeting->setDuration($request->get('duration'));

            $em->persist($meeting);
            $em->flush();
            //Rederiger vers read
            return $this->redirectToRoute('read_meeting');
        }
        return $this->render('@Meeting/meeting/update_meeting.html.twig', array(
            'form'=>$meeting
        ));
    }

    public function deleteMeetingAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $meeting=$em->getRepository(Meeting::class)->find($id);
        $em->remove($meeting);
        $em->flush();
        return $this->redirectToRoute('read_meeting');
    }

}
