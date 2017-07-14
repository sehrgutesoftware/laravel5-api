<?php

namespace Tests;

use Illuminate\Http\Request;
use Mockery;
use SehrGut\Laravel5_Api\Hooks\TestHook;

class ControllerHooksTest extends TestCase
{
    public function test_it_calls_the_hook_on_the_controller()
    {
        $request = new Request();
        $controller = Mockery::mock(
            'SehrGut\Laravel5_Api\Controller, SehrGut\Laravel5_Api\Hooks\TestHook',
            [$request]
        );
        $controller->shouldReceive('testHook')
            ->with('test input')
            ->once()
            ->andReturn('test output');

        $output = $controller->applyHooks(TestHook::class, 'test input');

        $this->assertEquals('test output', $output);
    }
}
