<?php

namespace Tests\Weew\Router\Invoker\ContainerAware;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Router\Invoker\ContainerAware\Stubs\FakeResponseable;
use Tests\Weew\Router\Invoker\ContainerAware\Stubs\FakeResponseHolder;
use Weew\Container\Container;
use Weew\Http\HttpRequestMethod;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHttpResponse;
use Weew\Router\Invoker\ContainerAware\Exceptions\InvalidRouteValue;
use Weew\Router\Invoker\ContainerAware\Invokers\CallableRouteInvoker;
use Weew\Router\Invoker\ContainerAware\RoutesInvoker;
use Weew\Router\Route;

class RoutesInvokerTest extends PHPUnit_Framework_TestCase {
    public function test_has_default_invokers() {
        $routesInvoker = new RoutesInvoker(new Container());
        $this->assertTrue(count($routesInvoker->getInvokers()) > 0);
    }

    public function test_add_invoker() {
        $routesInvoker = new RoutesInvoker(new Container());
        $count = count($routesInvoker->getInvokers());
        $routesInvoker->addInvoker(new CallableRouteInvoker());

        $this->assertTrue(
            count($routesInvoker->getInvokers()) == $count + 1
        );
    }

    public function test_invoke_route() {
        $routesInvoker = new RoutesInvoker(new Container());
        $response = new HttpResponse(HttpStatusCode::OK);
        $route = new Route([HttpRequestMethod::GET], 'foo', function() use ($response) {
            return $response;
        });

        $this->assertTrue($routesInvoker->invokeRoute($route) === $response);
    }

    public function test_invoke_route_with_non_http_response_as_return_value() {
        $routesInvoker = new RoutesInvoker(new Container());
        $route = new Route([HttpRequestMethod::GET], 'foo', function() {
            return 'foo';
        });
        $response = $routesInvoker->invokeRoute($route);

        $this->assertTrue(
            $response instanceof IHttpResponse
        );
        $this->assertEquals('foo', $response->getContent());
    }

    public function test_invoke_route_with_bad_route_handler() {
        $routesInvoker = new RoutesInvoker(new Container());
        $route = new Route([HttpRequestMethod::GET], 'foo', 'bar');
        $this->setExpectedException(InvalidRouteValue::class);
        $routesInvoker->invokeRoute($route);
    }

    public function test_invoke() {
        $routesInvoker = new RoutesInvoker(new Container());
        $response = new HttpResponse(HttpStatusCode::OK);
        $route = new Route([HttpRequestMethod::GET], 'foo', function() use ($response) {
            return $response;
        });

        $this->assertTrue($routesInvoker->invoke($route) === $response);
    }

    public function test_invoke_with_null() {
        $routesInvoker = new RoutesInvoker(new Container());
        $response = $routesInvoker->invoke(null);

        $this->assertTrue($response instanceof IHttpResponse);
        $this->assertEquals(HttpStatusCode::NOT_FOUND, $response->getStatusCode());
    }

    public function test_invoke_with_http_response_holder_as_response() {
        $response = new HttpResponse(HttpStatusCode::OK);
        $holder = new FakeResponseHolder($response);
        $routesInvoker = new RoutesInvoker(new Container());

        $route = new Route([HttpRequestMethod::GET], 'foo', function() use ($holder) {
            return $holder;
        });

        $this->assertTrue($routesInvoker->invoke($route) === $holder->getHttpResponse());
    }

    public function test_invoke_with_http_responseable_as_response() {
        $response = new HttpResponse(HttpStatusCode::OK);
        $holder = new FakeResponseable($response);
        $routesInvoker = new RoutesInvoker(new Container());

        $route = new Route([HttpRequestMethod::GET], 'foo', function() use ($holder) {
            return $holder;
        });

        $this->assertTrue($routesInvoker->invoke($route) === $holder->toHttpResponse());
    }
}
