<?php

namespace Dragooon\YamlFileConfig;

/**
 * Base interface for any class providing configuration
 */
interface ConfigInterface extends \ArrayAccess
{
    /**
     * Returns all the configuration variable
     *
     * @return array
     */
    public function getAll();

    /**
     * Checks whether a specific configuration variable is defined or not
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Returns a specific $key variable
     *
     * @param string $key
     * @return mixed
     * @throws Exception\UndefinedParameterException
     */
    public function get($key);

    /**
     * Sets a specific variable
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);
}
