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
        $request = new Request();
        $controller = Mockery::mock(
            'SehrGut\Laravel5_Api\Controller, SehrGut\Laravel5_Api\Hooks\TestHook',
            [$request]
        );

        $controller->shouldReceive('testHook')
            ->once();

        $controller->applyHooks(TestHook::class);

        $this->assertTrue(true);  // Mute warning: Mock expectations do not count towards assertions count
    }
}
