<?php

namespace Tests;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Mockery;
use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Controller;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;
use SehrGut\Laravel5_Api\Hooks\Hook;
use SehrGut\Laravel5_Api\Hooks\TestHook;
use SehrGut\Laravel5_Api\PluginLoader;
use SehrGut\Laravel5_Api\Plugins\Paginator;
use SehrGut\Laravel5_Api\Plugins\Plugin;
use SehrGut\Laravel5_Api\Plugins\SearchFilter;
use stdClass;

class PluginLoaderTest extends TestCase
{
    protected function getController()
    {
        $request = new Request();

        return new Controller($request);
    }

    public function test_it_initializes_properly_without_plugins()
    {
        $loader = new PluginLoader($this->getController());
        $this->assertTrue(true);
    }

    public function test_it_initializes_properly_with_plugins()
    {
        $plugins = [Paginator::class, SearchFilter::class];

        $loader = new PluginLoader($this->getController(), $plugins);
        $this->assertTrue($loader->isLoaded(Paginator::class));
        $this->assertTrue($loader->isLoaded(SearchFilter::class));
    }

    public function test_it_loads_plugins()
    {
        $plugins = [Paginator::class, SearchFilter::class];
        $loader = new PluginLoader($this->getController());

        $loader->loadPlugins($plugins);
        $this->assertTrue($loader->isLoaded(Paginator::class));
        $this->assertTrue($loader->isLoaded(SearchFilter::class));
    }

    public function test_it_loads_plugins_individually()
    {
        $plugins = [Paginator::class, SearchFilter::class];
        $loader = new PluginLoader($this->getController());

        $this->assertFalse($loader->isLoaded(Paginator::class));
        $this->assertFalse($loader->isLoaded(SearchFilter::class));

        $loader->loadPlugin($plugins[0]);
        $this->assertTrue($loader->isLoaded(Paginator::class));
        $this->assertFalse($loader->isLoaded(SearchFilter::class));

        $loader->loadPlugin($plugins[1]);
        $this->assertTrue($loader->isLoaded(Paginator::class));
        $this->assertTrue($loader->isLoaded(SearchFilter::class));
    }

    public function test_it_loads_plugin_instances()
    {
        $plugin = new Paginator();
        $loader = new PluginLoader($this->getController());

        $this->assertFalse($loader->isLoaded(Paginator::class));
        $loader->loadPlugin($plugin);
        $this->assertTrue($loader->isLoaded(Paginator::class));
    }

    public function test_it_doesnt_take_fish_for_plugins()
    {
        $loader = new PluginLoader($this->getController());

        $this->expectException(InvalidArgumentException::class);
        $loader->loadPlugin(new stdClass());
    }

    public function test_it_configures_plugins()
    {
        $controller = $this->getController();
        $mock = Mockery::mock('SehrGut\Laravel5_Api\Plugins\Plugin');
        $mock->shouldReceive('configure')
            ->with(['option'=> 'value'])
            ->once();

        $loader = new PluginLoader($controller, [$mock]);
        $result = $loader->configurePlugin(get_class($mock), ['option' => 'value']);

        $this->assertNull($result);  // Stop complaining about no assertions
    }

    public function test_it_applies_hooks()
    {
        $controller = $this->getController();
        $context = new Context();

        $mock = Mockery::mock('SehrGut\Laravel5_Api\Plugins\TestPlugin');
        $mock->shouldReceive('authorizeResource')
            ->with($context)
            ->once()
            ->andReturn('some output');

        $loader = new PluginLoader($controller, [$mock]);
        $result = $loader->applyHooks(AuthorizeResource::class, $context);

        $this->assertEquals('some output', $result);
    }

    public function test_it_applies_hooks_in_correct_order()
    {
        $controller = $this->getController();
        $in2one = new Context();
        $one2two = new Context();
        $two2three = new Context();
        $three2out = new Context();

        // Test one direction
        $plugin_1 = Mockery::namedMock('Mock1', 'SehrGut\Laravel5_Api\Plugins\TestPlugin');
        $plugin_2 = Mockery::namedMock('Mock2', 'SehrGut\Laravel5_Api\Plugins\TestPlugin');
        $plugin_3 = Mockery::namedMock('Mock3', 'SehrGut\Laravel5_Api\Plugins\TestPlugin');
        $plugin_1->shouldReceive('authorizeResource')
            ->with($in2one)
            ->once()
            ->andReturn($one2two);
        $plugin_2->shouldReceive('authorizeResource')
            ->with($one2two)
            ->once()
            ->andReturn($two2three);
        $plugin_3->shouldReceive('authorizeResource')
            ->with($two2three)
            ->once()
            ->andReturn($three2out);

        $loader = new PluginLoader($controller, [$plugin_1, $plugin_2, $plugin_3]);
        $result = $loader->applyHooks(AuthorizeResource::class, $in2one);

        $this->assertEquals($three2out, $result);
    }

    public function test_it_generates_hook_methods_correctly()
    {
        $samples = [
            'SehrGut\\Laravel5_Api\\Hooks\\AdaptCollectionQuery'   => 'adaptCollectionQuery',
            '\\\\SehrGut\\Laravel5_Api\\Hooks\\AdaptResourceQuery' => 'adaptResourceQuery',
            'Hooks\\AuthorizeResource'                             => 'authorizeResource',
            'SehrGut\Laravel5_Api\Hooks\AuthorizeAction'           => 'authorizeAction',
            'FormatCollection'                                     => 'formatCollection',
            'formatResource'                                       => 'formatResource',
            'foreRespond'                                          => 'foreRespond',
        ];

        foreach ($samples as $challenge => $response) {
            $this->assertEquals($response, PluginLoader::getHookMethodName($challenge));
        }
    }

    public function test_it_identifies_hook_interfaces()
    {
        $this->assertFalse(PluginLoader::isHook(Controller::class));
        $this->assertFalse(PluginLoader::isHook(Plugin::class));
        $this->assertFalse(PluginLoader::isHook('Hook'));
        $this->assertFalse(PluginLoader::isHook('Something Else'));

        // Hook itself shouldn't be recognized as it defines zero methods
        $this->assertFalse(PluginLoader::isHook(Hook::class));

        $this->assertTrue(PluginLoader::isHook(TestHook::class));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\AdaptCollectionQuery'));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\AdaptResourceQuery'));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\AuthorizeResource'));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\AuthorizeAction'));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\BeforeRespond'));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\FormatCollection'));
        $this->assertTrue(PluginLoader::isHook('SehrGut\Laravel5_Api\Hooks\FormatResource'));
    }
}
