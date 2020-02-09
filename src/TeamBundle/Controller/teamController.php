<?php

namespace TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeamBundle\Entity\team;

class teamController extends Controller
{
    public function createteamAction()
    {
        return $this->render('@Team/team/createteam.html.twig', array(
            // ...
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

    public function deleteteamAction()
    {
        return $this->render('TeamBundle:team:deleteteam.html.twig', array(
            // ...
        ));
    }

}
