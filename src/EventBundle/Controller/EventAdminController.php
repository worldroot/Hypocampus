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
        return $this->redirectToRoute('afficherevent');
    }

    public function searcheventsAction(Request $request)
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(EventsAdmin::class)->findAll();

        $input=$request->get('TitreEvent');
        if(isset($input))
        {
            $formation = $em->getRepository(EventsAdmin::class)->findTitre($input);

            return $this->render('@Event/EventAdmin/searchevents.html.twig', array(
                'formations' => $formation
            ));
        }

        return $this->render('@Event/EventAdmin/searchevents.html.twig', array(
            'formations'=>$tab
        ));
    }

    public function ViewparticipantAction(Request $request)
    {
        $em = $this->getDoctrine();

        $choix = $em->getRepository(EventsAdmin::class)->findAll();
        //$type=$em->getRepository(EventsAdmin::class)->findcwf($choix);

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


     public function StatAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $classes = $em->getRepository(EventsAdmin::class)->findAll();
        $totalEvent=0;
        foreach($classes as $classe) {
            $totalEvent=$totalEvent+$classe->getNbEtudiants();
        }

        $data= array();
        $stat=['classe', 'nbEtudiant'];
        $nb=0;
        array_push($data,$stat);
        foreach($classes as $classe) {
            $stat=array();
            array_push($stat,$classe->getNom(),(($classe->getNbEtudiants()) *100)/$totalEvent);
            $nb=($classe->getNbEtudiants() *100)/$totalEvent;
            $stat=[$classe->getNom(),$nb];
            array_push($data,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des étudiants par niveau');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('@Graphe\Default\index.html.twig', array('piechart' => $pieChart));
    }







}
