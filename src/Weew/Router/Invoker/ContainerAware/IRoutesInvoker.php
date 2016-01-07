<?php

namespace Weew\Router\Invoker\ContainerAware;

use Weew\Http\IHttpResponse;
use Weew\Router\IRoute;

interface IRoutesInvoker {
    /**
     * @param $route
     *
     * @return IHttpResponse
     */
    function invoke($route);

    /**
     * @param IRoute $route
     *
     * @return IHttpResponse
     */
    function invokeRoute(IRoute $route);

    /**
     * @param IRouteInvoker $invoker
     */
    function addInvoker(IRouteInvoker $invoker);

    /**
     * @return IRouteInvoker[]
     */
    function getInvokers();
}
