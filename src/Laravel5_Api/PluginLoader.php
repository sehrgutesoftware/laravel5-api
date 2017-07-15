<?php

namespace SehrGut\Laravel5_Api;

use InvalidArgumentException;
use SehrGut\Laravel5_Api\Hooks\Hook;
use SehrGut\Laravel5_Api\Plugins\Plugin;

/**
 * Takes care of Controller Plugins loading, calling, configuring…
 */
class PluginLoader
{
    /**
     * Instances of loaded plugins.
     *
     * @var array
     */
    protected $plugins = [];

    /**
     * Maps hooks to plugin classes. Don't add anything here manually!
     *
     * @var array
     */
    private $hooks = [];

    /**
     * Construct a new instance.
     *
     * @param Controller $controller The principal controller
     * @param array|null $plugins    List of plugin classes to load
     */
    function __construct(Controller $controller, array $plugins = null)
    {
        // Register controller hooks
        $this->loadPlugin($controller);

        // Load Plugins
        if ($plugins) {
            $this->loadPlugins($plugins);
        }
    }

    /**
     * Instantiate and remember Plugins of given types.
     *
     * @param  array  $plugins Plugin types (order matters)
     * @return void
     */
    public function loadPlugins(array $plugins)
    {
        foreach (array_unique($plugins) as $class) {
            $this->loadPlugin($class);
        }
    }

    /**
     * Instantiate and remember a single Plugin of given type.
     *
     * @param  String|Plugin $class Plugin type or instance
     * @return void
     */
    public function loadPlugin($class)
    {
        if ($class instanceof Plugin OR $class instanceof Controller) {
            $instance = $class;
            $class = get_class($class);
        } elseif (is_string($class) AND class_exists($class)) {
            $instance = new $class();
        } else {
            throw new InvalidArgumentException();
        }

        if ($this->isLoaded($class)) {
            return;
        }

        $this->plugins[$class] = $instance;

        $this->registerHooks($class);
    }

    /**
     * Check if a Plugin was loaded already.
     *
     * @param  String  $class Plugin type
     * @return boolean
     */
    public function isLoaded(String $class)
    {
        return array_key_exists($class, $this->plugins);
    }

    /**
     * Pass configuration array to a plugin instance.
     *
     * @param string $class   FQN of the plugin
     * @param array  $options Array of options for the plugin
     *
     * @return void
     */
    public function configurePlugin(String $class, array $options)
    {
        if ($this->isLoaded($class)) {
            $this->plugins[$class]->configure($options);
        }
    }

    /**
     * Pass the `$argument` to all plugins registered for `$hook`
     * consecutively and return the result of the last plugin.
     *
     * @param string $hook     FQN of the hook interface
     * @param mixed  $argument Argument passed to the first hook
     *
     * @return mixed Return value of the last hook
     */
    public function applyHooks(String $hook, $argument)
    {
        $method_name = static::getHookMethodName($hook);

        // Call all plugins, passing the return value of the
        // previous hook as first argument to the next
        foreach ($this->getPluginsForHook($hook) as $plugin) {
            $argument = $plugin->$method_name($argument);
        }

        return $argument;
    }

    /**
     * Register hooks for given plugin type.
     *
     * @param  String $class Plugin type
     * @return void
     */
    protected function registerHooks(String $class)
    {
        $hooks = class_implements($class);
        foreach ($hooks as $hook) {
            $this->registerHook($class, $hook);
        }
    }

    /**
     * Register a plugin to a single hook.
     *
     * @param Plugin $class  The plugin class
     * @param string $hook   FQN of the hook interface
     *
     * @return void
     */
    protected function registerHook(String $class, String $hook)
    {
        if (!static::isHook($hook)) {
            return;
        }

        if (!$this->hookExists($hook)) {
            $this->hooks[$hook] = [];
        }

        $this->hooks[$hook][] = $class;
    }

    /**
     * Check if there are any Plugins registered on a hook.
     *
     * @param  String $hook  Hook Interface
     * @return boolean
     */
    protected function hookExists(String $hook)
    {
        return array_key_exists($hook, $this->hooks);
    }

    /**
     * Get all plugin instances for given hook in the order in which they were loaded.
     *
     * @param  String $hook Hook Interface
     * @return array
     */
    protected function getPluginsForHook(String $hook)
    {
        $instances = [];

        foreach ($this->getPluginClassesForHook($hook) as $class) {
            if ($this->isLoaded($class)) {
                $instances[] = $this->plugins[$class];
            }
        }

        return $instances;
    }

    /**
     * Get all Plugin Types that are registered on given hook in the order they were loaded.
     *
     * @param  String $hook Hook Interface
     * @return array
     */
    protected function getPluginClassesForHook(String $hook)
    {
        if($this->hookExists($hook)) {
            return $this->hooks[$hook];
        }

        return [];
    }

    /**
     * Turn the FQN of a hook Interface into its corresponding method name.
     *
     * @param string $fqn FQN of the hook Interface
     *
     * @return string Name of the hook method
     */
    public static function getHookMethodName(String $fqn)
    {
        $without_namespace = array_last(explode('\\', $fqn));

        return lcfirst($without_namespace);
    }

    /**
     * Test whether a Hook is
     * @param  String  $class [description]
     * @return boolean        [description]
     */
    public static function isHook(String $class)
    {
        return is_subclass_of($class, Hook::class, true);
    }
}
