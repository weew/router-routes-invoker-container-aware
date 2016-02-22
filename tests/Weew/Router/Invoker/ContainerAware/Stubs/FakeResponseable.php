<?php

namespace Tests\Weew\Router\Invoker\ContainerAware\Stubs;

use Weew\Http\IHttpResponse;
use Weew\Http\IHttpResponseable;

class FakeResponseable implements IHttpResponseable {
    /**
     * @var IHttpResponse
     */
    private $response;

    public function __construct(IHttpResponse $response) {
        $this->response = $response;
    }

    /**
     * @return IHttpResponse
     */
    public function toHttpResponse() {
        return $this->response;
    }
}
