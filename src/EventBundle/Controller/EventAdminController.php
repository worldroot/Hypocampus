<?php

namespace EventBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use EventBundle\Entity\EventsAdmin;
use EventBundle\Entity\Participant;
use EventBundle\Form\EventsAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

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

            $date1 = strtotime($x->format("Y-m-d"));
            $date2 = strtotime($y->format("Y-m-d"));
            $diff = $date2 - $date1;

            if ($diff > 0) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return $this->redirectToRoute('searchevents');
            } else {
                echo "<script>alert('Vérifier la date de fin !')</script>";
            }

        }
        return $this->render('@Event/EventAdmin/addevent.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function updateEventsAction($idev, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(EventsAdmin::class)->find($idev);
        $form = $this->createForm(EventsAdminType::class, $club);
        $form = $form->handleRequest($request);

        if (($form->isSubmitted()) & ($form->isValid())) {

            $em->flush();
            return $this->redirectToRoute('searchevents');
        }
        return $this->render('@Event/EventAdmin/addevent.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteeventsAction($idev)
    {
        $cnx = $this->getDoctrine()->getManager();
        $d = $cnx->getRepository(EventsAdmin::class)->find($idev);
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
        $em = $this->getDoctrine();
        $tab = $em->getRepository(EventsAdmin::class)->findAll();

        $totalEtudiant = 0;
        foreach ($tab as $S) {
            $totalEtudiant = $totalEtudiant + $S->getNumeroEvent();
        }

        $data = array();
        $stat = ['classe', 'etat'];
        $nb = 0;
        array_push($data, $stat);
        foreach ($tab as $S) {
            $stat = array();
            array_push($stat, $S->getTitreEvent(), (($S->getNumeroEvent()) * 100) / $totalEtudiant);
            $nb = ($S->getNumeroEvent() * 100) / $totalEtudiant;
            $stat = [$S->getTitreEvent(), $nb];
            array_push($data, $stat);

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
            'formations' => $tab, 'piechart' => $pieChart
        ));
    }


    public function IndexEventApiAction($idev)
    {

        $em = $this->getDoctrine();
        $evv = $em->getRepository(EventsAdmin::class)->find($idev);
        $ev = $em->getRepository(EventsAdmin::class)->findAll();
        $data = $this->get("jms_serializer")->serialize($ev, "json");
        return new Response($data);
    }

    public function AddEventApiAction($idev, $titre, $type, $cap, $dateEvent, $dateEnd, $img)
    {
        $events = new EventsAdmin();

        $em = $this->getDoctrine()->getManager();

        $date = new \DateTime($dateEvent);
        $events->setDateEvent($date);
        $end_date = new \DateTime($dateEnd);
        $events->setEnddateEvent($end_date);


        $evv = $em->getRepository(EventsAdmin::class)->find($idev);
        $events->setTitreEvent($titre);
        $events->setTypeEvent($type);
        $events->setNumeroEvent($cap);
        $events->setImageName($img);

        if ($events->getDateEvent() == $events->getEnddateEvent() || $events->getEnddateEvent() <= $events->getDateEvent()) {
            return false;
        }

        $em->persist($events);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formattedEV = $serializer->normalize($events);
        return new JsonResponse($formattedEV);
    }

    public function DeleteEventApiAction($idev)
    {
        $em = $this->getDoctrine()->getManager();
        $entrainement = $this->getDoctrine()->getManager()
            ->getRepository('EventBundle:EventsAdmin')
            ->find($idev);
        $em->remove($entrainement);
        $em->flush();
        //$entrainement->setDateCreation($boutique->getDateCreation()->format('Y-m-d H:i:s'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($entrainement);
        return new JsonResponse($formatted);
    }

    public function UpdateEventApiAction(Request $request, $idev)
    {
        $em = $this->getDoctrine()->getManager();

        $ev = new EventsAdmin();
        $ev = $em->getRepository("EventBundle:EventsAdmin")->find($idev);
        $ev->setTitreEvent($request->get('TitreEvent'));
        $ev->setTypeEvent($request->get('TypeEvent'));
        $ev->setNumeroEvent($request->get('NumeroEvent'));
        $start_date = new \DateTime($request->get('DateEvent'));
        $end_date = new \DateTime($request->get('enddateEvent'));
        $ev->setImageName($request->get('image_name'));
        $ev->setDateEvent($start_date);
        $ev->setEnddateEvent($end_date);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ev);

        return new JsonResponse($formatted);
    }

    public function StatistiqueAction()
    {
        $tot = $this->getDoctrine()->getManager()->getRepository("EventBundle:EventsAdmin")->Total();
        $pourcentage1 = $this->getDoctrine()->getManager()->getRepository("EventBundle:EventsAdmin")->StatMobile1();
        $pourcentage2 = $this->getDoctrine()->getManager()->getRepository("EventBundle:EventsAdmin")->StatMobile2();
        $pourcentage3 = $this->getDoctrine()->getManager()->getRepository("EventBundle:EventsAdmin")->StatMobile3();
        $resp = array();
        $resp[0]=$pourcentage1;
        $resp[1]=$pourcentage2;
        $resp[2]=$pourcentage3;
        $resp[3]=$tot;


            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($resp);
            return new JsonResponse($formatted);
        }



}
