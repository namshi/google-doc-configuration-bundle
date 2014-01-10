<?php

namespace Namshi\GoogleDocConfigurationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigController extends Controller
{
    public function updateAction()
    {
        $config = $this->get('namshi_google_doc_configuration.config');

        try {
            $config->update();

            return $this->render('NamshiGoogleDocConfigurationBundle:Config:success.html.twig', array('config' => $config));
        } catch (\Exception $e) {
            return $this->render('NamshiGoogleDocConfigurationBundle:Config:error.html.twig', array('exception' => $e));
        }
    }
}
