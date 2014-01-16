<?php

namespace Namshi\GoogleDocConfigurationBundle\Config;

/**
 * Interface ConfigInterface defines how a key-value configuration should be represented.
 *
 * @package Namshi\GoogleDocConfigurationBundle\Config
 */
interface ConfigInterface
{
    /**
     * Returns the configuration as a key-value array.
     *
     * @return array
     */
    public function getAll();

    /**
     * Returns a config key, or a default value if its not found.
     * If the key is NULL, the default value will be returned.
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default);

    /**
     * Overrides the current configuration.
     *
     * @param array $config
     * @return null
     */
    public function update(array $config);
} 