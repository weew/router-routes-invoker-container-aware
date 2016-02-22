<?php

namespace Tests\Weew\Router\Invoker\ContainerAware\Stubs;

use Weew\Http\IHttpResponse;
use Weew\Http\IHttpResponseHolder;

class FakeResponseHolder implements IHttpResponseHolder {
    private $httpResponse;

    public function __construct(IHttpResponse $httpResponse) {
        $this->httpResponse = $httpResponse;
    }

    public function getHttpResponse() {
        return $this->httpResponse;
    }

    public function setHttpResponse(IHttpResponse $httpResponse) {
        $this->httpResponse = $httpResponse;
    }
}
