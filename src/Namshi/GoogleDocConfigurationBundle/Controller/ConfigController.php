<?php

namespace Namshi\GoogleDocConfigurationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ConfigController provides a simple layer to update configuration based on a config object.
 *
 * @package Namshi\GoogleDocConfigurationBundle\Controller
 */
class ConfigController extends Controller
{
    const CONFIG_APPROVED = "http://static2.wikia.nocookie.net/__cb20120203132529/codelyoko/images/1/1f/Chuck_Norris_Approves.png";
    const CONFIG_SHOW     = "http://static.comicvine.com/uploads/original/3/31265/1550715-chuck_norris_2.jpg";
    const CONFIG_BROKEN   = "http://benwilder.files.wordpress.com/2011/03/chuck_norris_facts.jpg";

    /**
     * Updates the current configuration.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateAction()
    {
        try {
            $newConfig = $this->get('namshi_google_doc_configuration.gvalue')->getDocument($this->container->getParameter('namshi_google_doc_configuration.config.google_doc_key'));

            if ($this->has('namshi_google_doc_configuration.validator')) {
                $this->get('namshi_google_doc_configuration.validator')->validate($newConfig);
            }

            $this->getConfiguration()->update($newConfig);

            return $this->render('NamshiGoogleDocConfigurationBundle:Config:success.html.twig', array(
                'config' => $this->getConfiguration()->getAll(),
                'chuck'  => static::CONFIG_APPROVED
            ));
        } catch (\Exception $e) {
            return $this->render('NamshiGoogleDocConfigurationBundle:Config:error.html.twig', array(
                'error' => $e->getMessage(),
                'chuck' => static::CONFIG_BROKEN
            ));
        }
    }

    /**
     * Shows the current configuration.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        return $this->render('NamshiGoogleDocConfigurationBundle:Config:success.html.twig', array(
            'config' => $this->getConfiguration()->getAll(),
            'chuck'  => static::CONFIG_SHOW
        ));
    }

    /**
     * @return \Namshi\GoogleDocConfigurationBundle\Config\ConfigInterface
     */
    protected function getConfiguration()
    {
        return $this->get('namshi_google_doc_configuration.config');
    }
}
