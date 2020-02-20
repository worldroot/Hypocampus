<?php

namespace sprintBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use projetsBundle\Entity\projets;
use sprintBundle\Entity\sprint;
use sprintBundle\Form\sprintType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class sprintController extends Controller
{
    public function createsprintAction(Request $request)
    {


        $sprint = new sprint();
        // creer notre formulaire
        $form=$this->createForm(sprintType::class,$sprint);
        //recuperation de donnesS
        $sprint->setEtat(0);
        $form=$form->handleRequest($request);
        //test sur les donnees
        if($form->isValid())
        {
            //creation d un objet doctrine
            $em=$this->getDoctrine()->getManager();

            //persister les donnees dans ORM
            $em->persist($sprint);
            //sauvegarder les donnees dans BD
            $em->flush();
            return $this->redirectToRoute('affichersprint');
        }
        return $this->render('@sprint/sprint/createsprint.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function affichersprintAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(sprint::class)->findAll();
        return $this->render('@sprint/sprint/affichersprint.html.twig', array(
            'sprint'=>$tab
        ));
    }

    public function updatesprintAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sprint = $em->getRepository(sprint::class)->find($id);
        $projets=$em->getRepository(projets::class)->findAll();



        //Save?
        if ($request->isMethod('POST')) {
            //Mettre a jour
            $startDatesprint = \DateTime::createFromFormat('Y-m-d', $request->get('startDatesprint'));
            $endDatesprint = \DateTime::createFromFormat('Y-m-d', $request->get('endDatesprint'));
            $sprint->setSprintName($request->get('sprintName' ));
            $sprint->setStartDatesprint($startDatesprint);
            $sprint->setEndDatesprint($endDatesprint);

            $projettmps=$em->getRepository(projets::class)->find($request->get('projet'));
            $sprint->setProjets($projettmps);

            $em->persist($sprint);
            $em->flush();
            //Rederiger vers read
            return $this->redirectToRoute('affichersprint');
        }
        return $this->render('@sprint/sprint/updatesprint.html.twig', array(
            'form'=>$sprint,
            'table'=>$sprint,
            'projets'=>$projets
        ));
    }

    public function deletesprintAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $club=$em->getRepository(sprint::class)->find($id);
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute('affichersprint');
    }



    public function DRAG_DROPAction(Request $request)
    {

        $em=$this->getDoctrine();
        $tab=$em->getRepository(sprint::class)->scarra();



            $id = $request->query->get('id');
            $etat = $request->query->get('etat');
            if( $id != null)
            {
                $em->getRepository(sprint::class)->scarra__($id,$etat);

            }


        return $this->render('@sprint/sprint/DRAG_DROP.html.twig', array(
            'tasks'=>$tab
        ));
    }
    public function ProgressAction($search)
    {
        //$search =$request->query->get('projets');
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('sprintBundle:sprint')->getProgress($search);
        $max=$result[0];

        return  new Response($max['Progress']);

    }
    public function ProgressCAction($search)
    {
        //$search =$request->query->get('projets');
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('sprintBundle:sprint')->getProgressC($search);
        $max=$result[0];

        return  new Response($max['ProgressC']);

    }
    public function TodoAction($search)
    {
        //$search =$request->query->get('projets');
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('sprintBundle:sprint')->getTodo($search);
        $max=$result[0];

        return  new Response($max['Todo']);

    }
    public function DoneAction($search)
    {
        //$search =$request->query->get('projets');
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('sprintBundle:sprint')->getDone($search);
        $max=$result[0];

        return  new Response($max['Done']);

    }
    public function statsprintAction()
    {        $pieChart = new PieChart();
        $em= $this->getDoctrine();

        $sprint = $em->getRepository(sprint::class)->findAll();

        $totalEtudiant=0;
        foreach($sprint as $S) {
            $totalEtudiant=$totalEtudiant+$S->getEtat();
        }

        $data= array();
        $stat=['classe', 'etat'];
        $nb=0;
        array_push($data,$stat);
        foreach($sprint as $S) {
            $stat=array();
            array_push($stat,$S->getSprintName(),(($S->getEtat()) *100)/$totalEtudiant);
            $nb=($S->getEtat() *100)/$totalEtudiant;
            $stat=[$S->getSprintName(),$nb];
            array_push($data,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des sprint par niveau');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);




        return $this->render('@sprint/sprint/statsprint.html.twig', array('piechart' => $pieChart));
    }
}
