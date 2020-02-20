<?php

namespace sprintBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('sprintBundle:Default:index.html.twig');
    }
}
