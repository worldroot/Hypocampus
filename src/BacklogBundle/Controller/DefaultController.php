<?php

namespace BacklogBundle\Controller;

use BacklogBundle\Entity\Backlog;
use BacklogBundle\Entity\Commentaire;
use BacklogBundle\Entity\Task;
use BacklogBundle\Form\BacklogType;
use BacklogBundle\Form\CommentaireType;
use BacklogBundle\Form\TaskType;
use Cassandra\Date;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function CreateTaskCommentaireAction(Request $request,$id_b, $id){



        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form = $form->handleRequest($request);
        if(($form->isSubmitted()) & ($form->isValid()))
        {
            //4.A Création d'un objet doctrine
            $em = $this->getDoctrine()->getManager();

            $commentaire->setDateCreation(new \DateTime('now'));
            $user = $this->getUser();
            $commentaire->setUser($user);
            //4.B persister les données dans orm
            $em->persist($commentaire);
            //5.A sauv les données dans la bd
            $em->flush();
            //6 redirect to route
            return $this->redirectToRoute('view_BacklogTask',['id_b' => $id_b, 'id'=> $id]);
        }

        return $this->render('@Backlog/Default/create_Task_Commentaire.html.twig', array(
            'form' => $form->createView()
        ));



    }
    public function backlog_sprint_indexAction()
    {
        return $this->render('@Backlog/Default/backlog_sprint_index.html.twig');
    }

    public function backlog_navAction()
    {
        return $this->render('@Backlog/Default/backlog_nav.html.twig');
    }

    public function IndexProjectBacklogAction(){

        $em = $this->getDoctrine();
        $tab = $em->getRepository(Backlog::class)->findAll();


        return $this->render('@Backlog/Default/backlog_index.html.twig', array(
            'backlogs'=> $tab
            // ...
        ));

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



    public function view_ProjectBacklogAction($id)
    {

        $em = $this->getDoctrine();
        $tab = $em->getRepository(Backlog::class)->find($id);
        $tab2 = $em->getRepository(Task::class)->backlogTasks($id);


        return $this->render('@Backlog/Default/view_ProjectBacklog.html.twig', array(
            'backlog'=> $tab,
            'tasks' => $tab2
            // ...
        ));

    }

    public function AddBacklogTaskAction(Request $request, $id)
    {

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form = $form->handleRequest($request);
        if(($form->isSubmitted()) & ($form->isValid()))
        {
            //4.A Création d'un objet doctrine
            $em = $this->getDoctrine()->getManager();
            //4.B persister les données dans orm
            $date =new \DateTime('now');
            $task->setCreatedDate($date);
            $backlog= $em->getRepository(Backlog::class)->find($id);
            $task->setBacklog($backlog);
            $em->persist($task);



            if ( $task->getState() == 'To Do')
            {
                $backlog->setPointsToDo($backlog->getPointsToDo() + $task->getStoryPoints());

            }elseif ($task->getState() == 'In Progress'){
                $backlog->setPointsInProgress($backlog->getPointsInProgress() + $task->getStoryPoints());

            }else{
                $backlog->setPointsDone($backlog->getPointsDone() + $task->getStoryPoints());

            }





            //5.A sauv les données dans la bd

            $em->flush();

            //6 redirect to route
            return $this->redirectToRoute('view_ProjectBacklog',['id' => $id]);
        }

        return $this->render('@Backlog/Default/create_BacklogTask.html.twig', array(
            'form' => $form->createView()
        ));


    }


    public function removeBacklogTaskAction($id_b,$id)
    {
        $em = $this->getDoctrine()->getManager();

        //1. prendre  l' objet
        $task = $em->getRepository(Task::class)->find($id);

        $backlog = $em->getRepository(Backlog::class)->find($id_b);

        if ( $task->getState() == 'To Do')
        {
            $backlog->setPointsToDo($backlog->getPointsToDo() - $task->getStoryPoints());

        }elseif ($task->getState() == 'In Progress'){
            $backlog->setPointsInProgress($backlog->getPointsInProgress() - $task->getStoryPoints());

        }else{
            $backlog->setPointsDone($backlog->getPointsDone() - $task->getStoryPoints());

        }


        $em->remove($task);
        $em->flush();



        return $this->redirectToRoute('view_ProjectBacklog',['id' => $id_b]);

    }

    public function DeleteProjectBacklogAction($id)
    {
        $em = $this->getDoctrine()->getManager();



        //1. prendre  l' objet
        $backlog = $em->getRepository(Backlog::class)->find($id);





        $em->remove($backlog);
        $em->flush();



        return $this->redirectToRoute('index_ProjectBacklog');

    }

    public function UpdateBacklogTaskAction($id_b, $id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository(Task::class)->find($id);

        $backlog = $em->getRepository(Backlog::class)->find($id_b);


        if ( $task->getState() == 'To Do')
        {
            $backlog->setPointsToDo($backlog->getPointsToDo() - $task->getStoryPoints());

        }elseif ($task->getState() == 'In Progress'){
            $backlog->setPointsInProgress($backlog->getPointsInProgress() - $task->getStoryPoints());

        }else{
            $backlog->setPointsDone($backlog->getPointsDone() - $task->getStoryPoints());

        }


        $form = $this->createForm(TaskType::class, $task);
        $form = $form->handleRequest($request);





        if(($form->isSubmitted()) & ($form->isValid()))
        {

            if ( $task->getState() == 'To Do')
            {
                $backlog->setPointsToDo($backlog->getPointsToDo() + $task->getStoryPoints());

            }elseif ($task->getState() == 'In Progress'){
                $backlog->setPointsInProgress($backlog->getPointsInProgress() + $task->getStoryPoints());

            }else{
                $backlog->setPointsDone($backlog->getPointsDone() + $task->getStoryPoints());

            }




            $em->flush();


            return $this->redirectToRoute('view_ProjectBacklog',['id' => $id_b]);


        }

        return $this->render('@Backlog/Default/update_BacklogTask.html.twig', array(
            'form' => $form->createView()
        ));


    }

    public function UpdateProjectBacklogAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $backlog = $em->getRepository(Backlog::class)->find($id);
        $form = $this->createForm(BacklogType::class, $backlog);
        $form = $form->handleRequest($request);





        if(($form->isSubmitted()) & ($form->isValid()))
        {

            $em->flush();


            return $this->redirectToRoute('view_ProjectBacklog',['id' => $id]);


        }

        return $this->render('@Backlog/Default/update_ProjectBacklog.html.twig', array(
            'form' => $form->createView()
        ));


    }

    public function ViewBacklogTaskAction($id)
    {

        $em = $this->getDoctrine();
        $tab2 = $em->getRepository(Task::class)->find($id);
        $commentaires = $em->getRepository(Commentaire::class)->commentairesTask($id);


        return $this->render('@Backlog/Default/task_show2.html.twig', array(
            'task' => $tab2,
            'commentaires' => $commentaires
            // ...
        ));
    }

    public function UpdateTaskCommentaireAction($id_b, $id, $id_c, Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository(Commentaire::class)->find($id_c);
        $form = $this->createForm(CommentaireType::class, $com);
        $form = $form->handleRequest($request);


        if(($form->isSubmitted()) & ($form->isValid()))
        {

            $em->flush();

            $tab = $em->getRepository(Backlog::class)->findAll();
            $tab2 = $em->getRepository(Task::class)->findAll();

            return $this->redirectToRoute('view_BacklogTask',['id_b' => $id_b, 'id' => $id]);


        }

        return $this->render('@Backlog/Default/update_Task_Commentaire.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function DeleteTaskCommentaireAction($id_b, $id, $id_c)
    {

        $em = $this->getDoctrine()->getManager();



        //1. prendre  l' objet
        $commentaire = $em->getRepository(Commentaire::class)->find($id_c);


        $em->remove($commentaire);
        $em->flush();

        return $this->redirectToRoute('view_BacklogTask',['id_b' => $id_b, 'id' => $id]);

    }


}
