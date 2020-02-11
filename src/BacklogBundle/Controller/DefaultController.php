<?php

namespace BacklogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function create_ProjectBacklogAction()
    {
        return $this->render('@Backlog/Default/create_ProjectBacklog.html.twig');
    }

    public function view_ProjectBacklogAction()
    {
        return $this->render('@Backlog/Default/view_ProjectBacklog.html.twig');
    }
}
