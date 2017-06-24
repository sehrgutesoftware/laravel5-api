<?php

namespace SehrGut\Laravel5_Api\Plugins;

use SehrGut\Laravel5_Api\Controller;

/**
 * Base plugin from which all plugins have to inherit.
 */
class Plugin
{
    /**
     * Holds a controller instance.
     *
     * @var Controller
     */
    protected $controller;

    /**
     * Defualt configuration that should be overwritten by the child class.
     *
     * @var array
     */
    protected $default_config = [];

    /**
     * This should be set via the `configure` method on the instance.
     *
     * @var array
     */
    protected $config = [];

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $this->config = $this->default_config;
    }

    /**
     * Set configuration options on the plugin.
     *
     * @param array $options New options (Previously set values not present here remain unchanged)
     *
     * @return $this
     */
    public function configure(array $options)
    {
        $this->config = array_merge($this->config, $options);

        return $this;
    }
}
