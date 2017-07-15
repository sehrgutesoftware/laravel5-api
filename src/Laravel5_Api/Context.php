<?php

namespace SehrGut\Laravel5_Api;

/**
 * A state container for the controller and for interaction through plugins.
 *
 * It's "protected" or "private" attributes are treated as "read only".
 * They can only be set through the constructor, but not later on.
 * This is implemented via "overloading" getter and setter.
 *
 * @link http://php.net/manual/en/language.oop5.overloading.php
 */
class Context
{
    // Read-only:
    protected $controller;
    protected $model;
    protected $request;

    // Read-write:
    public $input;
    public $action;
    public $query;
    public $resource;
    public $collection;
    public $response;

    /**
     * A place for overloaded properties.
     *
     * @var array
     */
    protected $overload = [];

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Handle write attempts to protected / missing properties.
     *
     * This method prevents writing to existing properties, while
     * accepting everything else and storeing it the $overlad.
     *
     * If a property exists, but this method is still called,
     * that means the property is protected/private and was
     * attempted to set from the outside.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if (!property_exists($this, $key)) {
            $this->overload[$key] = $value;
        }
    }

    /**
     * Handle read attempts to non-existing or protected properties.
     *
     * @see __set()
     *
     * @param void $key
     *
     * @return void
     */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
        if (array_key_exists($key, $this->overload)) {
            return $this->overload[$key];
        }
    }
}
