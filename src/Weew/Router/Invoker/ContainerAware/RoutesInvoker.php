<?php

namespace Weew\Router\Invoker\ContainerAware;

use Weew\Container\IContainer;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHttpResponse;
use Weew\Router\Invoker\ContainerAware\Exceptions\InvalidRouteValue;
use Weew\Router\Invoker\ContainerAware\Invokers\ArraySyntaxRouteInvoker;
use Weew\Router\Invoker\ContainerAware\Invokers\CallableRouteInvoker;
use Weew\Router\IRoute;

class RoutesInvoker implements IRoutesInvoker {
    /**
     * @var IContainer
     */
    protected $container;

    /**
     * @var IRouteInvoker[]
     */
    protected $invokers = [];

    /**
     * RoutesInvoker constructor.
     *
     * @param IContainer $container
     */
    public function __construct(IContainer $container) {
        $this->container = $container;
        $this->registerDefaultInvokers();
    }

    /**
     * Invoke given route. If the route is null, returns a 404 response.
     *
     * @param IRoute $route
     *
     * @return HttpResponse|IHttpResponse
     * @throws InvalidRouteValue
     */
    public function invoke($route) {
        if ($route instanceof IRoute) {
            return $this->invokeRoute($route);
        }

        return new HttpResponse(HttpStatusCode::NOT_FOUND);
    }

    /**
     * @param IRoute $route
     *
     * @return IHttpResponse
     * @throws InvalidRouteValue
     */
    public function invokeRoute(IRoute $route) {
        $invoker = $this->findInvoker($route);

        if ($invoker) {
            $response = $invoker->invoke($route, $this->container);

            if ( ! $response instanceof IHttpResponse) {
                $response = new HttpResponse(HttpStatusCode::OK, $response);
            }

            return $response;
        }

        throw new InvalidRouteValue(
            s('Could not resolve route value of type %s.', get_type($route->getHandler()))
        );
    }

    /**
     * @param IRouteInvoker $invoker
     */
    public function addInvoker(IRouteInvoker $invoker) {
        $this->invokers[] = $invoker;
    }

    /**
     * @return IRouteInvoker[]
     */
    public function getInvokers() {
        return $this->invokers;
    }

    /**
     * @param IRoute $route
     *
     * @return null|IRouteInvoker
     */
    protected function findInvoker(IRoute $route) {
        foreach ($this->getInvokers() as $invoker) {
            if ($invoker->supports($route)) {
                return $invoker;
            }
        }

        return null;
    }

    /**
     * Register default route invokers.
     */
    protected function registerDefaultInvokers() {
        $this->addInvoker(new ArraySyntaxRouteInvoker());
        $this->addInvoker(new CallableRouteInvoker());
    }
}
