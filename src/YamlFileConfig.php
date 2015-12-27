<?php
/**
 * Yaml File Configuration provider
 *
 * @author Shitiz Garg <mail@dragooon.net>
 * @license The MIT License
 */

namespace Dragooon\YamlFileConfig;
use Dragooon\YamlFileConfig\Exception\InvalidFileException;
use Dragooon\YamlFileConfig\Exception\UndefinedParameterException;
use Symfony\Component\Yaml\Yaml;

/**
 * Base class for Yaml File Configuration
 */
class YamlFileConfig implements \ArrayAccess
{

    /**
     * The full path of configuration
     *
     * @var string
     */
    protected $file;

    /**
     * Yaml configuration stored in the file
     *
     * @var array
     */
    protected $config = array();

    /**
     * Whether we have loaded the configuration or not
     *
     * @var bool
     */
    protected $isLoaded = false;

    /**
     * @param string $file
     * @throws
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $this->load();
        return isset($this->config[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     * @throws UndefinedParameterException
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw new UndefinedParameterException($key);
        }
        return $this->config[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->load();
        $this->config[$key] = $value;
    }

    /**
     * Loads configuration from file
     *
     * @return void
     * @throws InvalidFileException
     */
    public function load()
    {
        if ($this->isLoaded) {
            return;
        }

        if (!file_exists($this->file) || !is_readable($this->file)) {
            throw new InvalidFileException($this->file);
        }
        $content = file_get_contents($this->file);
        $this->config = Yaml::parse($content);
        $this->isLoaded = true;
    }

    /**
     * Saves configuration into file using Yaml::dump
     *
     * @return void
     * @throws InvalidFileException
     */
    public function save()
    {
        $this->load();

        if (!is_writable($this->file)) {
            throw new InvalidFileException('Cannot write to: ' . $this->file);
        }

        $content = Yaml::dump($this->config);
        file_put_contents($this->file, $content);
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
