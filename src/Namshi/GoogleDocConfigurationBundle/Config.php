<?php

namespace Namshi\GoogleDocConfigurationBundle;

use Predis\Client;

class Config
{
    const REDIS_CONFIG_KEY = 'namshi_google_doc_configuration.config';

    /**
     * @var Client
     */
    protected $redis;

    /**
     * @var array
     */
    protected $configuration;

    public function __construct(array $configuration, Client $redis = null)
    {
        $this->setConfiguration($configuration);
        $this->setRedis($redis);
    }

    public function update()
    {
        return true;
    }

    /**
     * @param array $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param \Predis\Client $redis
     */
    public function setRedis($redis)
    {
        $this->redis = $redis;
    }

    /**
     * @return \Predis\Client
     */
    public function getRedis()
    {
        return $this->redis;
    }
} 