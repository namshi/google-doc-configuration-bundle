<?php

namespace Namshi\GoogleDocConfigurationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NamshiGoogleDocConfigurationBundle:Default:index.html.twig', array('name' => $name));
    }
}
