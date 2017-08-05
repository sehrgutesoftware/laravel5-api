<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Support\Facades\Log;
use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery;
use SehrGut\Laravel5_Api\Hooks\AuthorizeAction;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;
use SehrGut\Laravel5_Api\Hooks\BeforeRespond;
use SehrGut\Laravel5_Api\Hooks\BeginAction;
use SehrGut\Laravel5_Api\Hooks\FormatCollection;
use SehrGut\Laravel5_Api\Hooks\FormatResource;
use SehrGut\Laravel5_Api\Hooks\TestHook;

/**
 * This plugin is to test all hooks that exist on the Controller.
 */
class TestPlugin extends Plugin implements
    AdaptCollectionQuery,
    AdaptResourceQuery,
    AuthorizeResource,
    AuthorizeAction,
    BeginAction,
    BeforeRespond,
    FormatCollection,
    FormatResource,
    TestHook
{
    public function adaptCollectionQuery(Context $context)
    {
        Log::info('TestPlugin: called adaptCollectionQuery', ['context' => $context]);

        return $context;
    }

    public function adaptResourceQuery(Context $context)
    {
        Log::info('TestPlugin: called adaptResourceQuery', ['context' => $context]);

        return $context;
    }

    public function authorizeResource(Context $context)
    {
        Log::info('TestPlugin: called authorizeResource', ['context' => $context]);

        return $context;
    }

    public function authorizeAction(Context $context)
    {
        Log::info('TestPlugin: called authorizeAction', ['context' => $context]);

        return $context;
    }

    public function beginAction(Context $context)
    {
        Log::info('TestPlugin: called beginAction', ['context' => $context]);

        return $context;
    }

    public function beforeRespond(Context $context)
    {
        Log::info('TestPlugin: called beforeRespond', ['context' => $context]);

        return $context;
    }

    public function formatCollection(Context $context)
    {
        Log::info('TestPlugin: called formatCollection', ['context' => $context]);

        return $context;
    }

    public function formatResource(Context $context)
    {
        Log::info('TestPlugin: called formatResource', ['context' => $context]);

        return $context;
    }

    public function testHook(Context $context)
    {
        Log::info('TestPlugin: called testHook', ['context' => $context]);

        return $context;
    }
}
