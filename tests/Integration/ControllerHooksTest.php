<?php

namespace Tests\Integration;

use Closure;
use Illuminate\Http\Request;
use Mockery;
use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Hooks\TestHook;
use Tests\TestCase;

class ControllerHooksTest extends TestCase
{
    public function test_it_calls_the_hook_on_the_controller()
    {
        $new_context = new Context();

        $request = new Request();
        $controller = Mockery::mock(
            'SehrGut\Laravel5_Api\Controller, SehrGut\Laravel5_Api\Hooks\TestHook',
            [$request]
        );

        $thief = Closure::bind(function ($controller) {
            return $controller->context;
        }, null, $controller);
        $context = $thief($controller);

        $controller->shouldReceive('testHook')
            ->with($context)
            ->once()
            ->andReturn($new_context);

        $controller->applyHooksToContext(TestHook::class);

        $this->assertEquals($new_context, $thief($controller));
    }
}
