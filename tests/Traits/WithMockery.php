<?php

namespace Tests\Traits;

use Mockery;

trait WithMockery
{

    public function withMock(string $class, string $call, array $return): void
    {
        $instance = Mockery::mock($class);
        $instance->shouldReceive($call)->andReturn(collect($return));
        $this->app->instance($class, $instance);
    }

}