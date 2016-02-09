<?php

namespace Weew\Router\Invoker\ContainerAware\Invokers;

use Weew\Container\IContainer;
use Weew\Router\Invoker\ContainerAware\IRouteInvoker;
use Weew\Router\IRoute;

/**
 * Supports callable definitions.
 */
class CallableRouteInvoker implements IRouteInvoker {
    /**
     * @param IRoute $route
     *
     * @return mixed
     */
    public function supports(IRoute $route) {
        return is_callable($route->getAction());
    }

    /**
     * @param IRoute $route
     * @param IContainer $container
     *
     * @return mixed
     */
    public function invoke(IRoute $route, IContainer $container) {
        return $container->call(
            $route->getAction(), $route->getParameters()
        );
    }
}
