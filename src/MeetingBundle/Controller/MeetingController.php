<?php

namespace MeetingBundle\Controller;

use MeetingBundle\Entity\Meeting;
use MeetingBundle\Form\MeetingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TeamBundle\Entity\team;

class MeetingController extends Controller
{
    public function createMeetingAction(Request $request)
    {
        $meeting = new meeting();
        $form = $this->createForm(MeetingType::class, $meeting);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($meeting);
            $em->flush();
            /* $basic  = new \Nexmo\Client\Credentials\Basic('09444ba7', 'GLTN6BKeO3WuWSoO');
             $client =new \Nexmo\Client($basic);
             $message = $client->message()->send([
                 'to' => '+21693991868',
                 'from' => 'Reunion',
                 'text' => 'Reunion urgent '
             ]);*/
            return $this->redirectToRoute('read_meeting');
        }
        return $this->render('@Meeting/meeting/create_Meeting.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function readMeetingAction()
    {
        $em = $this->getDoctrine();
        $tab = $em->getRepository(Meeting::class)->findAll();



        return $this->render('@Meeting/meeting/read_meeting.html.twig', array(
            "meetings" => $tab
        ));


    }

    public function updateMeetingAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $meeting = $em->getRepository(Meeting::class)->find($id);

        $team = $em->getRepository(team::class)->findAll();

        //Save?
        if ($request->isMethod('POST')) {
            //Mettre a jour
            $meeting->setDescription($request->get('description'));
            $meeting->setDuration($request->get('duration'));

            $teamtmp = $em->getRepository(team::class)->find($request->get('team'));
            $meeting->setTeam($teamtmp);

            $em->persist($meeting);
            $em->flush();
            //Rederiger vers read
            return $this->redirectToRoute('read_meeting');
        }
        return $this->render('@Meeting/meeting/update_meeting.html.twig', array(
            'form' => $meeting,
            'team' => $team
        ));
    }

    public function deleteMeetingAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $meeting = $em->getRepository(Meeting::class)->find($id);
        $em->remove($meeting);
        $em->flush();
        return $this->redirectToRoute('read_meeting');
    }

    public function pdfAction($id)
    {

        $snappy = $this->get('knp_snappy.pdf');
        $em = $this->getDoctrine();

        $tab = $em->getRepository(Meeting::class)->findAll();
        $scarra = 0;
        foreach ($tab as $row)
        {
            if($row->getId() != $id)
            {
                unset($tab[$scarra]);
            }
            $scarra = $scarra + 1;
        }
        $html = $this->renderView('@Meeting/meeting/pdf.html.twig', array(
            "meetings" => $tab
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );

    }
}
