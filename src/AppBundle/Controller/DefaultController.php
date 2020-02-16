<?php

namespace AppBundle\Controller;

use SubscriptionBundle\Entity\Tarif;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Tarif::class)->findAll();
        return $this->render('frontend.html.twig',['tarifs' => $tab ]);
    }

}
