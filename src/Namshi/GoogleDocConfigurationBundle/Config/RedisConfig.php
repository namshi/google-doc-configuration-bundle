<?php

namespace Namshi\GoogleDocConfigurationBundle\Config;

use Predis\ClientInterface;

/**
 * Class Config represent a key-value configuration.
 *
 * @package Namshi\GoogleDocConfigurationBundle
 */
class RedisConfig implements ConfigInterface
{
    const REDIS_CONFIG_HASH = 'namshi_google_doc_configuration.config';

    /**
     * @var Client
     */
    protected $redis;

    /**
     * @var string
     */
    protected $configHash = self::REDIS_CONFIG_HASH;

    public function __construct(ClientInterface $redis, $configHash = null)
    {
        $this->setRedis($redis);

        if ($configHash) {
            $this->setConfigHash($configHash);
        }
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        return $this->getRedis()->hget($this->getConfigHash(), $key) ?: $default;
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return $this->getRedis()->hgetall($this->getConfigHash());
    }

    /**
     * @inheritDoc
     */
    public function update(array $config)
    {
        $oldConfig = $this->getAll();

        foreach ($config as $parameter => $value) {
            $this->getRedis()->hset($this->getConfigHash(), $parameter, $value);
        }

        foreach (array_diff($oldConfig, $config) as $parameter => $value) {
            $this->getRedis()->hdel($this->getConfigHash(), $parameter);
        }

        return $this->getAll();
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

    /**
     * @param string $configHash
     */
    public function setConfigHash($configHash)
    {
        $this->configHash = $configHash;
    }

    /**
     * @return string
     */
    public function getConfigHash()
    {
        return $this->configHash;
    }
} 