<?php

namespace Weew\Router\Invoker\ContainerAware;

use Weew\Container\IContainer;
use Weew\Router\IRoute;

interface IRouteInvoker {
    /**
     * @param IRoute $route
     *
     * @return mixed
     */
    function supports(IRoute $route);

    /**
     * @param IRoute $route
     * @param IContainer $container
     *
     * @return mixed
     */
    function invoke(IRoute $route, IContainer $container);
}
