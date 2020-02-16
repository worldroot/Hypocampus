<?php

namespace SubscriptionBundle\Controller;

use SubscriptionBundle\Entity\Subscription;
use SubscriptionBundle\Entity\Tarif;
use SubscriptionBundle\Form\SubscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class SubscriptionController extends Controller
{
    public function readsubAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Subscription::class)->findAll();
        return $this->render('@Subscription/Subscription/readsub.html.twig', array(
            'subs'=>$tab
        ));
    }

    public function createsubAction(Request $request)
    {
        $sub = new Subscription();
        $form=$this->createForm(SubscriptionType::class,$sub);
        $form=$form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($sub);
            $em->flush();
            return $this->redirectToRoute('readsub');
        }
        return $this->render('@Subscription/Subscription/createsub.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function deletesubAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $sub=$em->getRepository(Subscription::class)->find($id);
        $em->remove($sub);
        $em->flush();
        return $this->redirectToRoute('readsub');
    }

    public function upadatesubAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sub = $em->getRepository(Subscription::class)->find($id);
        $tab=$em->getRepository(Tarif::class)->findAll();

        if ($request->isMethod('POST')) {
            $sub->setname($request->get('name'));
            $sub->setactive($request->get('active'));
            $tmp=$em->getRepository(Tarif::class)->find($request->get('tarif'));
            $sub->settarif($tmp);
            $date = \DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $sub->setdate($date);

            $em->persist($sub);
            $em->flush();

            return $this->redirectToRoute('readsub');
        }
        return $this->render('@Subscription/Subscription/upadatesub.html.twig', array(
            'sub'=>$sub,
            'tarif'=>$tab
        ));
    }

}
