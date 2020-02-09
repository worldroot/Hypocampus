<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeamBundle\Entity\team;
use TeamBundle\Form\teamType;

class teamController extends Controller
{
    public function createteamAction(Request $request)
    {

        $team = new team();
        $form=$this->createForm(teamType::class,$team);
        $form=$form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('readteam');
        }
        return $this->render('@Team/team/createteam.html.twig', array(
            'form'=>$form->createView()
        ));

    }

    public function readteamAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(team::class)->findAll();
        return $this->render('@Team/team/readteam.html.twig', array(
            "teams" => $tab
        ));
    }

    public function updateteamAction()
    {
        return $this->render('TeamBundle:team:updateteam.html.twig', array(
            // ...
        ));
    }

    public function deleteteamAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $team=$em->getRepository(team::class)->find($id);
        $em->remove($team);
        $em->flush();
        return $this->redirectToRoute('readteam');
    }

}
