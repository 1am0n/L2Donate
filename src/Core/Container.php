<?php

namespace App\Core;

class Container {
    private array $instances = [];

    function set(string $id, object $instance): void
    {
        $this->instances[$id] = $instance;
    }

    function get(string $id): object
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $reflection = new \ReflectionClass($this);
        $constructor = $reflection->getConstructor();

        if ($constructor == null) {
            return $this->instances[$id] = new $id();
        }
    }
}