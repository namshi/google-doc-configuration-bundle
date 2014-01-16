<?php

namespace Namshi\GoogleDocConfigurationBundle\Config;

/**
 * Interface ValidatorInterface
 *
 * @package Namshi\GoogleDocConfigurationBundle\Config
 */
interface ValidatorInterface
{
    /**
     * Validates the $confid, throwing an exception if it contains an invalid value.
     *
     * @param array $config
     * @return null
     * @throws \Exception
     */
    public function validate(array $config);
} 