<?php

namespace projetsBundle\Controller;

use projetsBundle\Entity\projets;
use projetsBundle\Form\projetsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class projetsController extends Controller
{
    public function createprojetAction(Request $request)
    {

        $projets = new projets();
        // creer notre formulaire
        $form=$this->createForm(projetsType::class,$projets);
        //recuperation de donnes
        $form=$form->handleRequest($request);
        //test sur les donnees
        if($form->isValid())
        {
            //creation d un objet doctrine
            $em=$this->getDoctrine()->getManager();
            //persister les donnees dans ORM
            $em->persist($projets);
            //sauvegarder les donnees dans BD
            $em->flush();
            return $this->redirectToRoute('afficherprojet');
        }
        return $this->render('@projets/projets/createprojet.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deleteprojetAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $club=$em->getRepository(projets::class)->find($id);
        $em->remove($club);
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
            $projets->setProjetName($request->get('projet_name'));
            $projets->setOwner($request->get('owner'));

            $projets->setStartDate($request->get('startDate' ));
            $projets->setEndDate($request->get('endDate'));


            $em->persist($projets);
            $em->flush();
            //Rederiger vers read
            return $this->redirectToRoute('afficherprojet');
        }
        return $this->render('@projets/projets/updateprojet.html.twig', array(
            'form'=>$projets
        ));
    }

    public function afficherprojetAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(projets::class)->findAll();
        return $this->render('@projets/projets/afficherprojet.html.twig', array(
            'projets'=>$tab
        ));
    }

}
