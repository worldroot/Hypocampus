<?php

namespace EntrepriseBundle\Controller;

use AppBundle\Entity\User;
use EntrepriseBundle\Entity\Entreprise;
use EntrepriseBundle\Form\EntrepriseType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;


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

    public function scarraAction()
    {
        $em=$this->getDoctrine();
        $tab=$em->getRepository(Entreprise::class)->scarraAa();

        return $this->render('@Entreprise/Entreprise/scarra_.html.twig', array(
            'user' => $tab
        ));
    }

    public function xhemAction(Request $request)
    {
        $username = $request->get('username');
        $role = $request->get('role');

        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('username' => $username));
        $user->addRole($role);
        $userManager->updateUser($user);



        return $this->redirectToRoute('scarra');
    }

    public function loginScarraAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user1 = $userManager->findUserBy(array('username' => $request->get("uname")));
        $data = $this->get("jms_serializer")->serialize($user1, "json");
        return new Response($data);

    }

    public function apiAfficherAction()
    {
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(Entreprise::class)->findAll();
        $data = $this->get("jms_serializer")->serialize($team, "json");
        return new Response($data);
    }
    

    public function apiDeleteAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(Entreprise::class)->find($id);
        dump($notification);
        $em->remove($notification);
        $em->flush();


        return new Response();
    }

    public function apiAjouterAction(Request $request)
    {
        $team= new Entreprise();
        $team->setName($request->get("name"));
        $team->setEmail($request->get("email"));
        $start_date=new \DateTime($request->get('dateofcreation'));
        $team->setCreatedate($start_date);

        $em = $this->getDoctrine()->getManager();
        $em->persist($team);
        $em->flush();


        return new Response();
    }

    public function apiModifierAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(Entreprise::class)->find($id);


        $start_date = new \DateTime($request->get('dateofcreation'));
        $team->setName($request->get('name'));
        $team->setEmail($request->get('email'));


        $team->setCreatedate($start_date);


        $em->persist($team);
        $em->flush();

        return new Response();
    }

    public function apiUserReadAction()
    {
        $em = $this->getDoctrine()->getManager();
        $team = $em->getRepository(Entreprise::class)->getAllUsers();
        $data = $this->get("jms_serializer")->serialize($team, "json");
        return new Response($data);
    }

    public function apiUserDeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $notification = $em->getRepository(Entreprise::class)->deleteUser($id);


        return new Response();
    }

    public function apiUserCreateAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPlainPassword($request->get('password'));
        $user->setEnabled(true);
        $user->setSuperAdmin(false);
        $user->addRole("ROLE_SCRUM_MASTER");
        $userManager->updateUser($user);

        return new Response();
    }

    public function apiUserUpdateAction($id, Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$id));

        $user->setUsername($request->get('username'));
        $user->setEmail($request->get('email'));
        $user->setPlainPassword($request->get('password'));
        //$user->addRole($request->get('roles'));


        $userManager->updateUser($user);

        return new Response();
    }
}
