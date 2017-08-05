<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Support\Facades\Log;
use SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery;
use SehrGut\Laravel5_Api\Hooks\AdaptRelations;
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
    AdaptRelations,
    AdaptResourceQuery,
    AuthorizeResource,
    AuthorizeAction,
    BeginAction,
    BeforeRespond,
    FormatCollection,
    FormatResource,
    TestHook
{
    public function adaptCollectionQuery()
    {
        Log::info('TestPlugin: called adaptCollectionQuery', ['context' => $this->context]);
    }

    public function adaptRelations(array $relations)
    {
        Log::info('TestPlugin: called adaptRelations', ['relations' => $relations]);

        return $relations;
    }

    public function adaptResourceQuery()
    {
        Log::info('TestPlugin: called adaptResourceQuery', ['context' => $this->context]);
    }

    public function authorizeResource()
    {
        Log::info('TestPlugin: called authorizeResource', ['context' => $this->context]);
    }

    public function authorizeAction()
    {
        Log::info('TestPlugin: called authorizeAction', ['context' => $this->context]);
    }

    public function beginAction()
    {
        Log::info('TestPlugin: called beginAction', ['context' => $this->context]);
    }

    public function beforeRespond()
    {
        Log::info('TestPlugin: called beforeRespond', ['context' => $this->context]);
    }

    public function formatCollection()
    {
        Log::info('TestPlugin: called formatCollection', ['context' => $this->context]);
    }

    public function formatResource()
    {
        Log::info('TestPlugin: called formatResource', ['context' => $this->context]);
    }

    public function testHook()
    {
        Log::info('TestPlugin: called testHook', ['context' => $this->context]);
    }
}
