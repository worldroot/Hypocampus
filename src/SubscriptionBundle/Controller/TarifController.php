<?php

namespace SubscriptionBundle\Controller;

use SubscriptionBundle\Entity\Tarif;
use SubscriptionBundle\Form\TarifType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TarifController extends Controller
{
    public function readtarifAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Tarif::class)->findAll();
        return $this->render('@Subscription/Tarif/readtarif.html.twig', array(
            'tarifs'=>$tab
        ));
    }

    public function createtarifAction(Request $request)
    {
        $tarif = new Tarif();
        $form=$this->createForm(TarifType::class,$tarif);
        $form=$form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($tarif);
            $em->flush();
            return $this->redirectToRoute('readtarif');
        }
        return $this->render('@Subscription/Tarif/createtarif.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deletetarifAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $tarif=$em->getRepository(Tarif::class)->find($id);
        $em->remove($tarif);
        $em->flush();
        return $this->redirectToRoute('readtarif');

    }

    public function updatetarifAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tarif = $em->getRepository(Tarif::class)->find($id);

        if ($request->isMethod('POST')) {
            $tarif->setname($request->get('name'));
            $tarif->setvalue($request->get('prix'));
            $tarif->setusernbr($request->get('usernbr'));
            $tarif->setprojectnbr($request->get('projectnbr'));

            $em->persist($tarif);
            $em->flush();

            return $this->redirectToRoute('readtarif');
        }
        return $this->render('@Subscription/Tarif/updatetarif.html.twig', array(
            'tarif'=>$tarif
        ));
    }

}
