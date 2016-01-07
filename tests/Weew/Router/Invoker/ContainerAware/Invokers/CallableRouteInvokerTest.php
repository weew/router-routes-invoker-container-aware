<?php

namespace Tests\Weew\Router\Invoker\ContainerAware\Invokers;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Router\Invoker\ContainerAware\Stubs\FooItem;
use Weew\Container\Container;
use Weew\Http\HttpRequestMethod;
use Weew\Router\Invoker\ContainerAware\Invokers\CallableRouteInvoker;
use Weew\Router\Route;

class CallableRouteInvokerTest extends PHPUnit_Framework_TestCase {
    public function test_supports() {
        $invoker = new CallableRouteInvoker();
        $this->assertFalse($invoker->supports(
            new Route(HttpRequestMethod::GET, 'foo', 'bar')
        ));
        $this->assertTrue($invoker->supports(
            new Route(HttpRequestMethod::GET, 'foo', function() {})
        ));
    }

    public function test_invoke() {
        $invoker = new CallableRouteInvoker();
        $item = new FooItem();
        $route = new Route(HttpRequestMethod::GET, 'foo', function(FooItem $foo, FooItem $item) {
            return $item;
        });
        $route->setParameter('item', $item);

        $this->assertTrue(
            $invoker->invoke($route, new Container()) === $item
        );
    }
}
