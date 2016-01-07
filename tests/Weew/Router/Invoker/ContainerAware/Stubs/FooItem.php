<?php

namespace Tests\Weew\Router\Invoker\ContainerAware\Stubs;

class FooItem {
    public function test(FooItem $item, $bar) {
        return $bar;
    }
}
