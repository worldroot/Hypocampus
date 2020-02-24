<?php

namespace projetsBundle\Controller;

use projetsBundle\Entity\projets;
use projetsBundle\Form\projetsType;
use projetsBundle\projetsBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /*
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(projets::class)->findAll();

        $input=$request->get('projet_name');
        if(isset($input) & !empty($input))
        {
            $formation = $em->getRepository(projets::class)->searchTitre($input);



            return $this->render('@projets/projets/afficherprojet.html.twig', array(
                'projets' => $formation
            ));


        }



        return $this->render('@projets/projets/afficherprojet.html.twig', array(
            'projets'=>$tab
        ));
        /*
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts =  $em->getRepository('projetsBundle:peojets')->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Post Not found :( ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getProjetName(),$posts->getOwner(),$posts->getStartDate(),$posts->getEndDate(),$posts->getDescription()];

        }
        return $realEntities;


    public function PSAction()
    {
        $em = $this->getDoctrine()->getManager();
        $result =$em->getRepository('projetsBundle:projets')->getPS();
        $max=$result[0];

        return  new Response($max['hwo']);

    }
 */
}
