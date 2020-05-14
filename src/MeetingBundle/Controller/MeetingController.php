<?php

namespace MeetingBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use MeetingBundle\Entity\Meeting;
use MeetingBundle\Entity\tmpMeeting;
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
                 'text' => 'Reunion urgente '
             ]);*/
            return $this->redirectToRoute('read_meeting');
        }
        return $this->render('@Meeting/meeting/create_Meeting.html.twig', array(
            'form' => $form->createView()
        ));

    }

    public function readMeetingAction(Request $request)
    {
        $em = $this->getDoctrine();
        $tabb = $em->getRepository(Meeting::class)->tri();
        $tab = $em->getRepository(Meeting::class)->findAll();


        $pieChart = new PieChart();
        $totalEtudiant=0;
        foreach($tab as $S) {
            $totalEtudiant=$totalEtudiant+$S->getNbrmeeting();
        }

        $data= array();
        $stat=['classe', 'etat'];
        $nb=0;
        array_push($data,$stat);
        foreach($tab as $S) {
            $stat=array();
            array_push($stat,$S->getTeam()->getTeamname(),(($S->getNbrmeeting()) *100)/$totalEtudiant);
            $nb=($S->getNbrmeeting() *100)/$totalEtudiant;
            $stat=[$S->getTeam()->getTeamname(),$nb];
            array_push($data,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $tabb, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );

        $pieChart->getOptions()->setTitle('');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);



        return $this->render('@Meeting/meeting/read_meeting.html.twig', array(
            "meetings" => $tabb,
            'piechart' => $pieChart,
             'pagination' => $pagination
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
            $meeting->setNbrmeeting($request->get('nbrmeeting'));

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
    public function statmeetingAction()
    {     $pieChart = new PieChart();
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Meeting::class)->findAll();

        $totalEtudiant=0;
        foreach($tab as $S) {
            $totalEtudiant=$totalEtudiant+$S->getNbrmeeting();
        }

        $data= array();
        $stat=['classe', 'etat'];
        $nb=0;
        array_push($data,$stat);
        foreach($tab as $S) {
            $stat=array();
            array_push($stat,$S->getTeam(),(($S->getNbrmeeting()) *100)/$totalEtudiant);
            $nb=($S->getNbrmeeting() *100)/$totalEtudiant;
            $stat=[$S->getTeam(),$nb];
            array_push($data,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Meeting/meeting/statsmeeting.html.twig', array(
            'formations'=>$tab,'piechart' => $pieChart
        ));
    }

    public function afficherMegAction()
    {
        $em = $this->getDoctrine()->getManager();
        $meets = $em->getRepository(Meeting::class)->findAll();

        $data = $this->get("jms_serializer")->serialize($meets, "json");
        return new Response($data);
    }

    public function deleteMegAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(Meeting::class)->find($id);
        dump($notification);
        $em->remove($notification);
        $em->flush();

        return new Response();
    }

    public function ajouterMegAction(Request $request)
    {
        $meeing= new Meeting();
        $meeing->setDescription($request->get("_0"));
        $meeing->setDuration($request->get("_1"));
        $meeing->setNbrmeeting($request->get("_2"));


        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(team::class)->find($request->get("_3"));

        $meeing->setTeam($team);

        $em->persist($meeing);
        $em->flush();


        return new Response();
    }

    public function updateMegAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $meeing = $em->getRepository(Meeting::class)->find($id);

        $meeing->setDescription($request->get("_0"));
        $meeing->setDuration($request->get("_1"));
        $meeing->setNbrmeeting($request->get("_2"));


        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(team::class)->find($request->get("_3"));

        $meeing->setTeam($team);

        $em->persist($meeing);
        $em->flush();


        return new Response();
    }

}
