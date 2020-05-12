<?php

namespace projetsBundle\Controller;

use BacklogBundle\Entity\Project;
use projetsBundle\Entity\projets;
use projetsBundle\Form\projetsType;
use projetsBundle\projetsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class projetsController extends Controller
{
    public function createprojetAction(Request $request)
    {

        $projets = new projets();
        // creer notre formulaire
        $form=$this->createForm(projetsType::class,$projets);
        $projets->setHistory(0);
        //recuperation de donnes
        $form=$form->handleRequest($request);
        //test sur les donnees
        if($form->isValid())
        {
            $x = $projets->getStartDate();
            $y = $projets->getEndDate();

            $date1 = strtotime( $x->format("Y-m-d") );
            $date2 = strtotime( $y->format("Y-m-d"));




            $diff = $date2 - $date1;

            if($diff > 0)
            {
            //creation d un objet doctrine
            $em=$this->getDoctrine()->getManager();
            //persister les donnees dans ORM
            $em->persist($projets);
            //sauvegarder les donnees dans BD
            $em->flush();

            return $this->redirectToRoute('afficherprojet');

            }
            else
            {
                echo "<script>alert('Vous avez sélectionnez une date incorrect!!')</script>";
            }
        }
        
        return $this->render('@projets/projets/createprojet.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deleteprojetAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $projets=$em->getRepository(projets::class)->find($id);
        $projets->setHistory(1);

        $em->persist($projets);
        $em->flush();

        return $this->redirectToRoute('afficherprojet');

    }
    public function RdeleteprojetAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $projets=$em->getRepository(projets::class)->find($id);
        $projets->setHistory(0);

        $em->persist($projets);
        $em->flush();

        return $this->redirectToRoute('afficherprojet');

    }

    public function updateprojetAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->find($id);


        //Save?
        if ($request->isMethod('POST')) {
            //Mettre a jour

            $startDate =\DateTime::createFromFormat('Y-m-d', $request->get('startDate'));
            $endDate = \DateTime::createFromFormat('Y-m-d', $request->get('endDate'));
            $projets->setProjetName($request->get('projet_name'));
            $projets->setOwner($request->get('owner'));
            $projets->setDescription($request->get('description'));

            $projets->setStartDate($startDate);
            $projets->setEndDate($endDate);


            $em->persist($projets);
            $em->flush();

            //Rederiger vers read
            return $this->redirectToRoute('afficherprojet');
        }
        return $this->render('@projets/projets/updateprojet.html.twig', array(
            'form'=>$projets
        ));
    }

    public function afficherprojetAction(Request $request)
    {

        $search =$request->query->get('projet_name');
        $en = $this->getDoctrine()->getManager();
        $projets=$en->getRepository("projetsBundle:projets")->searchProjets($search);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $projets, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render("@projets/projets/afficherprojet.html.twig",array(
            'projets' => $projets,
            'pagination' => $pagination
        ));

    }
    public function HistoryprojetsAction(Request  $request)
    {
        $search =$request->query->get('projet_name');
        $en = $this->getDoctrine()->getManager();
        $projets=$en->getRepository("projetsBundle:projets")->searchProjetsH($search);
        return $this->render("@projets/projets/Historyprojets.html.twig",array(
            'projets' => $projets,

        ));
    }
//api pour mobile




    public function afficherProjectApiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->findBy(['history' => '0']);
        $data = $this->get("jms_serializer")->serialize($projets, "json");
        return new Response($data);
    }

    public function MoreProjectApiAction(Request $request,$id)
        {
            $em = $this->getDoctrine()->getManager();
            $projets = $em->getRepository(projets::class)->find($id);
            $data = $this->get("jms_serializer")->serialize($projets, "json");
            return new Response($data);
        }
    public function api_deleteProjectAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->find($id);
        dump($projets);
        $em->remove($projets);
        $em->flush();


        return new Response();
    }


//archiver
    public function Aff_archiverProjectApiAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->findBy(['history' => '1']);
        $data = $this->get("jms_serializer")->serialize($projets, "json");
        return new Response($data);
    }
    public function api_archiverProjectAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->find($id);
        dump($projets);
        $projets->setHistory(1);
        $em->persist($projets);
        $em->flush();


        return new Response();
    }
    public function api_NOTarchiverProjectAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->find($id);
        dump($projets);
        $projets->setHistory(0);
        $em->persist($projets);
        $em->flush();


        return new Response();
    }

    public function createProjectApiAction(Request $request)
    {
/*
        $em = $this->getDoctrine()->getManager();
        $projets = new projets();
        $projets->setProjetName("projet_name");
        $projets->setOwner($request->get("owner"));
        $projets->setStartDate($request->get('start_date'));
        $projets->setEndDate($request->get('end_date'));
        $projets->setHistory(0);
        $projets->setDescription($request->get("description"));
        $em->persist($projets);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($projets);




        $data = $request->getContent();
        var_dump($data);
        $em = $this->getDoctrine()->getManager();
        $pos = $this->get("jms_serializer")->deserialize($data,"ProjetsBundle\Entity\Projets","json");


          $projets= new projets();

          $em = $this->getDoctrine()->getManager();

          $projets->setProjetName($pos->getProjetName());
          $projets->setOwner($pos->getOwner());
          $projets->setStartDate($pos->getStartDate());
          $projets->setEndDate($pos->getEndDate());
          $projets->setDescription($pos->getDescription());



          $em->persist($projets);
          $em->flush();
  /////**************************
*/              //EEE MMM dd HH:mm:ss yyyy
         $projets= new projets();

         $projets->setProjetName($request->get("projet_name"));
         $projets->setOwner($request->get("owner"));





        $start_date=new \DateTime($request->get('start_date'));
        $end_date=new \DateTime($request->get('end_date'));
        $projets->setStartDate($start_date);
        $projets->setEndDate($end_date);

        ////$endDate=\DateTime::createFromFormat('d-m-Y H:i:s', $request->get('end_date'))->format('Y-m-d h:i:s');
        //$date1 = strtotime( $request->get('start_date')->format("Y-m-d") );
        //$date2 = strtotime( $request->get('end_date')->format("Y-m-d"));
         //$start_date=new \DateTime($date1);
         //$end_date=new \DateTime($date2);


          //$projets->setStartDate($request->get('start_date'));
          //$projets->setEndDate($request->get('end_date'));


          $projets->setHistory(0);
          $projets->setDescription($request->get("description"));

          $em = $this->getDoctrine()->getManager();
              //$child->setParent($this->getUser());
          $em->persist($projets);
          $em->flush();


        return new Response();
       // return new JsonResponse($formatted);

    }



    public function updateprojetApiAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $projets = $em->getRepository(projets::class)->find($id);



            //Mettre a jour

        $start_date=new \DateTime($request->get('start_date'));
        $end_date=new \DateTime($request->get('end_date'));
            $projets->setProjetName($request->get('projet_name'));
            $projets->setOwner($request->get('owner'));
            $projets->setDescription($request->get('description'));


        $projets->setStartDate($start_date);
        $projets->setEndDate($end_date);


            $em->persist($projets);
            $em->flush();

            //Rederiger vers read

        return new Response();
        // return new JsonResponse($formatted);

    }






    public function ProgressProjectApiAction($id)
    {
        //$search =$request->query->get('projets');
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('sprintBundle:sprint')->getProgress($id);
        $max=$result[0];

        return  new Response($max['Progress']);

    }

    public function CompletedProjectApiAction($id)
    {
        //$search =$request->query->get('projets');
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('sprintBundle:sprint')->getProgressC($id);
        $max=$result[0];

        return  new Response($max['ProgressC']);
    }

}
