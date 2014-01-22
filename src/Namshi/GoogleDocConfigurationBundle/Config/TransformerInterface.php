<?php

namespace Namshi\GoogleDocConfigurationBundle\Config;

/**
 * Interface TransformerInterfaceInterface
 *
 * @package Namshi\GoogleDocConfigurationBundle\Config
 */
interface TransformerInterface
{
    /**
     * transform the $config, throwing an exception if transformation failed.
     *
     * @param array $config
     * @return null
     * @throws \Exception
     */
    public function transform(array $config);
}