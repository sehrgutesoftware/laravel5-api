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

    function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }
}
