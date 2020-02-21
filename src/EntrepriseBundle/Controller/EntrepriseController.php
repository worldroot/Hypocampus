<?php

namespace EntrepriseBundle\Controller;

use EntrepriseBundle\Entity\Entreprise;
use EntrepriseBundle\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntrepriseController extends Controller
{
    public function createAction(Request $request)
    {
        $ep = new Entreprise();
        $form=$this->createForm(EntrepriseType::class,$ep);
        $form=$form->handleRequest($request);
        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($ep);
            $em->flush();

            $message = \Swift_Message::newInstance()
                ->setSubject('Hypocampus')
                ->setFrom('houcem.chett@gmail.com')
                ->setTo($ep->getEmail())
                ->setBody('Welcome to HYPOCAMPUS, Thanks you for choosing us.
                You will get your Free Trial pack in the next 3 days.');

            $this->get('mailer')->send($message);

            return $this->redirectToRoute('read');
        }

        return $this->render('@Entreprise/Entreprise/create.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function readAction(Request $request)
    {
        $search = $request->query->get('search');
        $filtre = $request->query->get('filtre');

        $em=$this->getDoctrine();
        $tab=$em->getRepository(Entreprise::class)->search($search,$filtre);

        return $this->render('@Entreprise/Entreprise/read.html.twig', array(
            'ep' => $tab
        ));
    }

    public function updateAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ep = $em->getRepository(Entreprise::class)->find($id);

        if ($request->isMethod('POST')) {
            $ep->setname($request->get('name'));
            $ep->setemail($request->get('email'));
            $date = \DateTime::createFromFormat('Y-m-d', $request->get('date'));
            $ep->setcreatedate($date);

            $em->persist($ep);
            $em->flush();

            return $this->redirectToRoute('read');
        }

        return $this->render('@Entreprise/Entreprise/update.html.twig', array(
            'ep'=>$ep
        ));
    }

    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();

        $ep=$em->getRepository(Entreprise::class)->find($id);
        $em->remove($ep);
        $em->flush();
        return $this->redirectToRoute('read');

    }

}
