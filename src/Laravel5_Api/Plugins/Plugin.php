<?php

namespace SehrGut\Laravel5_Api\Plugins;

use SehrGut\Laravel5_Api\Context;

/**
 * Base plugin from which all plugins have to inherit.
 */
class Plugin
{
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

    /**
     * The controller's current context.
     *
     * @var Context
     */
    protected $context;

    /**
     * Construct a new Context.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->config = $this->default_config;
        $this->context = $context;
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
