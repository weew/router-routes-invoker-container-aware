<?php

namespace Tests\Weew\Router\Invoker\ContainerAware\Invokers;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Router\Invoker\ContainerAware\Stubs\FooItem;
use Weew\Container\Container;
use Weew\Http\HttpRequestMethod;
use Weew\Router\Invoker\ContainerAware\Exceptions\InvalidControllerClass;
use Weew\Router\Invoker\ContainerAware\Exceptions\InvalidControllerMethod;
use Weew\Router\Invoker\ContainerAware\Invokers\ArraySyntaxRouteInvoker;
use Weew\Router\Route;

class ArraySyntaxRouteInvokerTest extends PHPUnit_Framework_TestCase {
    public function test_supports() {
        $invoker = new ArraySyntaxRouteInvoker();
        $this->assertFalse(
            $invoker->supports(new Route(HttpRequestMethod::GET, 'foo', 'bar'))
        );
        $this->assertTrue(
            $invoker->supports(new Route(HttpRequestMethod::GET, 'foo', ['foo', 'bar']))
        );
    }

    public function test_invoke() {
        $invoker = new ArraySyntaxRouteInvoker();
        $container = new Container();
        $item = new FooItem();

        $route = new Route(HttpRequestMethod::GET, 'foo', [FooItem::class, 'test']);
        $route->setParameter('bar', $item);

        $this->assertTrue(
            $invoker->invoke($route, $container) === $item
        );
    }

    public function test_invoke_with_invalid_controller_class() {
        $invoker = new ArraySyntaxRouteInvoker();
        $container = new Container();
        $route = new Route(HttpRequestMethod::GET, 'foo', ['foo', 'test']);

        $this->setExpectedException(InvalidControllerClass::class);
        $invoker->invoke($route, $container);
    }

    public function test_invoke_with_invalid_controller_method() {
        $invoker = new ArraySyntaxRouteInvoker();
        $container = new Container();
        $route = new Route(HttpRequestMethod::GET, 'foo', [FooItem::class, 'foo']);

        $this->setExpectedException(InvalidControllerMethod::class);
        $invoker->invoke($route, $container);
    }

}
