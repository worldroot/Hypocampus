<?php

namespace EventBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use EventBundle\Entity\EventsAdmin;
use EventBundle\Entity\Participant;
use EventBundle\Form\EventsAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventAdminController extends Controller
{

    public function addeventAction(Request $request)
    {
        $event = new EventsAdmin();
        $form = $this->createForm(EventsAdminType::class, $event);
        $form = $form->handleRequest($request);

        if (($form->isSubmitted()) & ($form->isValid())) {

            $x = $event->getDateEvent();
            $y = $event->getEnddateEvent();

            $date1 = strtotime( $x->format("Y-m-d") );
            $date2 = strtotime( $y->format("Y-m-d"));
            $diff = $date2 - $date1;

            if($diff > 0) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return $this->redirectToRoute('searchevents');
            }
            else{
                echo "<script>alert('Vérifier la date de fin !')</script>";
            }

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
            return $this->redirectToRoute('searchevents');
        }
        return $this->render('@Event/EventAdmin/addevent.html.twig', array(
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
        return $this->redirectToRoute('searchevents');
    }


    public function ViewparticipantAction(Request $request)
    {
        $em = $this->getDoctrine();

        $choix = $em->getRepository(EventsAdmin::class)->findAll();

        $input = $request->get('TypeEvent');
        if (isset($input)) {
            $formation = $em->getRepository(EventsAdmin::class)->findType($input);

            return $this->render('@Event/EventAdmin/viewparticipant.html.twig', array(
                'formations' => $formation
            ));
        }

        return $this->render('@Event/EventAdmin/viewparticipant.html.twig', array(
            'formations' => $choix
        ));

    }

    public function searcheventsAction()
    {
        $pieChart = new PieChart();
        $em=$this->getDoctrine();
        $tab=$em->getRepository(EventsAdmin::class)->findAll();

        $totalEtudiant=0;
        foreach($tab as $S) {
            $totalEtudiant=$totalEtudiant+$S->getNumeroEvent();
        }

        $data= array();
        $stat=['classe', 'etat'];
        $nb=0;
        array_push($data,$stat);
        foreach($tab as $S) {
            $stat=array();
            array_push($stat,$S->getTitreEvent(),(($S->getNumeroEvent()) *100)/$totalEtudiant);
            $nb=($S->getNumeroEvent() *100)/$totalEtudiant;
            $stat=[$S->getTitreEvent(),$nb];
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

        return $this->render('@Event/EventAdmin/searchevents.html.twig', array(
            'formations'=>$tab,'piechart' => $pieChart
        ));
    }



}
