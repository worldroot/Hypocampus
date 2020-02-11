<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route ("/")
     */
    public function indexAction()
    {
        return $this->render('@User/Security/login.html.twig');
    }
    /**
     * @Route ("/Register")
     */
    public function registerAction()
    {
        return $this->render('@User/Registration/register.html.twig');
    }
}
