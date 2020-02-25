<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Certif;
use EventBundle\Form\CertifType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CertifController extends Controller
{
    public function addcertifAction(Request $request)
    {
        $club = new Certif();
        $form = $this->createForm(CertifType::class, $club);
        $form = $form->handleRequest($request);

        if (($form->isSubmitted()) & ($form->isValid())) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('readcertif');

        }
        return $this->render('@Event/Certif/addcertif.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function readcertifAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Certif::class)->findAll();
        return $this->render('@Event/Certif/readcertif.html.twig', array(
            'formations'=>$tab
        ));
    }

    public function updatecertifAction($pointc,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(Certif::class)->find($pointc);
        $form=$this->createForm(CertifType::class, $club);
        $form=$form->handleRequest($request);

        if( ($form->isSubmitted()) & ($form->isValid()) ){

            $em->flush();
            return $this->redirectToRoute('readcertif');
        }
        return $this->render('@Event/Certif/addcertif.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deletecertifAction($idc)
    {
        $cnx=$this->getDoctrine()->getManager();
        $d=$cnx->getRepository(Certif::class)->find($idc);
        $cnx->remove($d);
        $cnx->flush();
        echo "<script>alert('Suppression succeed')</script>";
        return $this->redirectToRoute('readcertif');

    }

}
