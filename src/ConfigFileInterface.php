<?php

namespace Dragooon\YamlFileConfig;

/**
 * This interface defines the behaviour of a configuration loading from a file
 */
interface ConfigFileInterface
{
    /**
     * Sets the file to load from
     *
     * @param string $file
     */
    public function setFile($file);

    /**
     * Gets the file for this configuration
     *
     * @return string
     */
    public function getFile();

    /**
     * Loads configuration from file. The class should try to delay loading of configuration
     * as much as possible, ideally until requested.
     *
     * @return void
     * @throws Exception\InvalidFileException
     */
    public function load();

    /**
     * Saves the configuration into the file, if possible
     *
     * @return void
     * @throws Exception\InvalidFileException
     */
    public function save();

    /**
     * Return all the configuration variables loaded
     *
     * @return array
     */
    public function getAll();
}
