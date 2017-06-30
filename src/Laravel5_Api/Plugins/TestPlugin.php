<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery;
use SehrGut\Laravel5_Api\Hooks\AuthorizeAction;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\FormatResource;
use SehrGut\Laravel5_Api\Hooks\ResponseHeaders;

/**
 * This plugin is to test all hooks that exist on the Controller.
 */
class TestPlugin extends Plugin implements
    AdaptCollectionQuery,
    AdaptResourceQuery,
    AuthorizeResource,
    AuthorizeAction,
    FormatCollection,
    FormatResource,
    ResponseHeaders
{
    public function adaptCollectionQuery(Builder $query)
    {
        Log::info('TestPlugin: called adaptCollectionQuery', ['query' => $query]);

        return $query;
    }

    public function adaptResourceQuery(Builder $query)
    {
        Log::info('TestPlugin: called adaptResourceQuery', ['query' => $query]);

        return $query;
    }

    public function authorizeResource(String $action)
    {
        Log::info('TestPlugin: called authorizeResource', ['action' => $action]);

        return $action;
    }

    public function authorizeAction(String $action)
    {
        Log::info('TestPlugin: called authorizeAction', ['action' => $action]);

        return $action;
    }

    public function formatCollection(Array $collection)
    {
        Log::info('TestPlugin: called formatCollection', ['collection' => $collection]);

        return $collection;
    }

    public function formatResource(Model $resource)
    {
        Log::info('TestPlugin: called formatResource', ['resource' => $resource]);

        return $resource;
    }

    public function responseHeaders(Array $headers)
    {
        Log::info('TestPlugin: called responseHeaders', ['headers' => $headers]);

        return $headers;
    }
}
