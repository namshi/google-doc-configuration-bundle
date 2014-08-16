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
     * @var array
     */
    protected $cache = [];

    /**
     * @var string
     */
    protected $configHash = self::REDIS_CONFIG_HASH;

    /**
     * @param ClientInterface $redis
     * @param null $configHash
     * @param bool $greedy if it's true it will fetch all configs per redis hash in one shot
     */
    public function __construct(ClientInterface $redis, $configHash = null, $greedy = false)
    {
        $this->redis = $redis;

        if ($configHash) {
            $this->setConfigHash($configHash);
        }

        if ($greedy) {
            $this->cache[$this->getConfigHash()] = $this->getAll();
        }
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        if (isset($this->cache[$this->getConfigHash()][$key])) {

            return $this->cache[$this->getConfigHash()][$key];
        }

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

        $this->resetCache($this->getConfigHash());

        return $this->getAll();
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

    /**
     * It resets the cache, if the config hash is specified it will just clear that entry
     *
     * @param null $configHash
     */
    public function resetCache($configHash = null)
    {
        if (null !== $configHash && isset($this->cache[$configHash])) {
            $this->cache[$configHash] = [];
        } else {
            $this->cache = [];
        }
    }
} 