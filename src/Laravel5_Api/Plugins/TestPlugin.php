<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Log;
use Illuminate\Database\Eloquent\Builder;

use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery;
use SehrGut\Laravel5_Api\Hooks\AuthorizeAction;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;

/**
 * This plugin is to test all hooks that exist on the Controller.
 */
class TestPlugin extends Plugin implements AdaptCollectionQuery,
                                           AdaptResourceQuery,
                                           AuthorizeResource,
                                           AuthorizeAction
{
    public function adaptCollectionQuery(Builder $query)
    {
        Log::info("TestPlugin: called adaptCollectionQuery", ['query' => $query]);
        return $query;
    }

    public function adaptResourceQuery(Builder $query)
    {
        Log::info("TestPlugin: called adaptResourceQuery", ['query' => $query]);
        return $query;
    }

    public function authorizeResource(String $action)
    {
        Log::info("TestPlugin: called authorizeResource", ['action' => $action]);
        return $action;
    }

    public function authorizeAction(String $action)
    {
        Log::info("TestPlugin: called authorizeAction", ['action' => $action]);
        return $action;
    }
}
