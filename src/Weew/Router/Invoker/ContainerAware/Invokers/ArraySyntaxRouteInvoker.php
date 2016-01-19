<?php

namespace Weew\Router\Invoker\ContainerAware\Invokers;

use Weew\Container\IContainer;
use Weew\Router\Invoker\ContainerAware\Exceptions\InvalidControllerClass;
use Weew\Router\Invoker\ContainerAware\Exceptions\InvalidControllerMethod;
use Weew\Router\Invoker\ContainerAware\IRouteInvoker;
use Weew\Router\IRoute;

/**
 * Supports array syntax controller definitions: [controller::class, 'method'].
 */
class ArraySyntaxRouteInvoker implements IRouteInvoker {
    /**
     * @param IRoute $route
     *
     * @return mixed
     */
    public function supports(IRoute $route) {
        list($controller, $method) = $this->extractControllerAndMethod(
            $route->getHandler()
        );

        if ($controller !== null && $method !== null) {
            return true;
        }

        return false;
    }

    /**
     * @param IRoute $route
     * @param IContainer $container
     *
     * @return mixed
     */
    public function invoke(IRoute $route, IContainer $container) {
        list($controller, $method) = $this->extractControllerAndMethod(
            $route->getHandler()
        );

        $this->ensureClassExists($controller);
        $instance = $container->get($controller);
        $this->ensureMethodExists($instance, $method);

        return $container->callMethod(
            $instance, $method, $route->getParameters()
        );
    }

    /**
     * @param $abstract
     *
     * @return array
     */
    protected function extractControllerAndMethod($abstract) {
        if (is_array($abstract)) {
            return array_pad($abstract, 2, null);
        }

        return [null, null];
    }

    /**
     * @param $controller
     *
     * @throws InvalidControllerClass
     */
    protected function ensureClassExists($controller) {
        if ( ! class_exists($controller)) {
            throw new InvalidControllerClass(
                s('Controller class "%s" does not exist.', $controller)
            );
        }
    }

    /**
     * @param $instance
     * @param $method
     *
     * @throws InvalidControllerMethod
     */
    protected function ensureMethodExists($instance, $method) {
        if ( ! method_exists($instance, $method)) {
            throw new InvalidControllerMethod(
                s('Method "%s" is not defined on controller "%s".',
                    $method, get_type($instance))
            );
        }
    }
}
