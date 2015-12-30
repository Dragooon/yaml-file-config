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
class YamlFileConfig extends ArrayConfiguration implements ConfigFileInterface
{

    /**
     * The full path of configuration
     *
     * @var string
     */
    protected $file;

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
        $this->setFile($file);
        parent::__construct([]);
    }

    /**
     * {@inheritdoc}
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * {@inheritdoc}
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
    public function has($key)
    {
        $this->load();
        return parent::has($key);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        $this->load();
        parent::set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $this->load();
        return parent::getAll();
    }

}
