<?php

namespace Weew\Router\Invoker\ContainerAware\Contracts;

use Weew\Http\IHttpResponse;

interface IHttpResponseHolder {
    /**
     * @return IHttpResponse
     */
    function getHttpResponse();

    /**
     * @param IHttpResponse $httpResponse
     */
    function setHttpResponse(IHttpResponse $httpResponse);
}
