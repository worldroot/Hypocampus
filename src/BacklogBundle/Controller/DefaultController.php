<?php

namespace BacklogBundle\Controller;

use BacklogBundle\Entity\Backlog;
use BacklogBundle\Entity\Task;
use BacklogBundle\Form\BacklogType;
use BacklogBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function backlog_sprint_indexAction()
    {
        return $this->render('@Backlog/Default/backlog_sprint_index.html.twig');
    }

    public function backlog_navAction()
    {
        return $this->render('@Backlog/Default/backlog_nav.html.twig');
    }

    public function create_ProjectBacklogAction(Request $request)
    {
        $backlog = new Backlog();
        $form = $this->createForm(BacklogType::class, $backlog);
        $form = $form->handleRequest($request);
        if(($form->isSubmitted()) & ($form->isValid()))
        {
            //4.A Création d'un objet doctrine
            $em = $this->getDoctrine()->getManager();
            //4.B persister les données dans orm
            $em->persist($backlog);
            //5.A sauv les données dans la bd
            $em->flush();
            //6 redirect to route
            return $this->redirectToRoute('backlog_nav_homepage');
        }

        return $this->render('@Backlog/Default/create_ProjectBacklog.html.twig', array(
            'form' => $form->createView()
        ));


    }



    public function view_ProjectBacklogAction()
    {

        $em = $this->getDoctrine();
        $tab = $em->getRepository(Backlog::class)->findAll();
        $tab2 = $em->getRepository(Task::class)->findAll();


        return $this->render('@Backlog/Default/view_ProjectBacklog.html.twig', array(
            'backlog'=> $tab,
            'tasks' => $tab2
            // ...
        ));

    }

    public function AddBacklogTaskAction(Request $request)
    {
        $todo=0;
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form = $form->handleRequest($request);
        if(($form->isSubmitted()) & ($form->isValid()))
        {
            //4.A Création d'un objet doctrine
            $em = $this->getDoctrine()->getManager();
            //4.B persister les données dans orm
            $em->persist($task);
            //5.A sauv les données dans la bd
            $em->flush();
            $tab = $em->getRepository(Backlog::class)->findAll();
            $tab2 = $em->getRepository(Task::class)->findAll();

            for($i = 0; $i < count($tab2); ++$i) {
                $todo += $tab2[$i]->getStoryPoints();
            }

            $form = $em->getRepository(Backlog::class)->find($tab[0]->getId());
            $form->setPointsToDo($form->getPointsToDo() + $todo);
            $em->flush();

            //6 redirect to route
            return $this->redirectToRoute('view_ProjectBacklog');
        }

        return $this->render('@Backlog/Default/create_BacklogTask.html.twig', array(
            'form' => $form->createView()
        ));


    }


    public function removeBacklogTaskAction($id)
    {
        $em = $this->getDoctrine()->getManager();



        //1. prendre  l' objet
        $task = $em->getRepository(Task::class)->find($id);

        $tab = $em->getRepository(Backlog::class)->findAll();
        $form = $em->getRepository(Backlog::class)->find($tab[0]->getId());
        $form->setPointsToDo($form->getPointsToDo() - $task->getStoryPoints());

        $em->remove($task);
        $em->flush();



        return $this->redirectToRoute('view_ProjectBacklog');

    }

    public function UpdateBacklogTaskAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Task::class)->find($id);
        $form = $this->createForm(TaskType::class, $task);
        $form = $form->handleRequest($request);





        if(($form->isSubmitted()) & ($form->isValid()))
        {

            $em->flush();

            $tab = $em->getRepository(Backlog::class)->findAll();
            $tab2 = $em->getRepository(Task::class)->findAll();

            return $this->redirectToRoute('view_ProjectBacklog');


        }

        return $this->render('@Backlog/Default/update_BacklogTask.html.twig', array(
            'form' => $form->createView()
        ));


    }



}
