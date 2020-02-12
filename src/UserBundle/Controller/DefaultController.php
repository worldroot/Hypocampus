<?php

namespace UserBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;


class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('@User/Security/login.html.twig');
    }

    public function registerAction()
    {
        return $this->render('@User/Registration/register.html.twig');
    }
}
