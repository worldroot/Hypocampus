<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('@User/Default/index.html.twig');
    }

    public function registerAction()
    {
        return $this->render('@User/Registration/register.html.twig');
    }
}
