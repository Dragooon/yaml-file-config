<?php

namespace Dragooon\YamlFileConfig;

use Dragooon\YamlFileConfig\ConfigInterface;
use Dragooon\YamlFileConfig\Exception\UndefinedParameterException;

class ArrayConfiguration implements ConfigInterface
{
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return isset($this->config[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->config;
    }

    /**
     * {@inheritdoc{
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new UndefinedParameterException($key);
        }
        return $this->config[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if (!$this->has($offset)) {
            throw new UndefinedParameterException($offset);
        }
        unset($this->config[$offset]);
    }
}
