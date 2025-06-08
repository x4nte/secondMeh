<?php

namespace App\Kernel\Container;

use Closure;
use ReflectionClass;

class Container
{
    private static $instance;
    private array $instances = [];

    public function has($key): bool
    {
        return isset($this->instances[$key]);
    }
    public function bind($key,Closure $value) : void
    {
        $this->instances[$key] = $value($this);
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return $this->instances[$key];
        }
        $reflection = new ReflectionClass($key);
        $constructor = $reflection->getConstructor();
        $deps = [];
        if ($constructor) {
            $params = $constructor->getParameters();
            foreach ($params as $param) {
                $deps[] = $this->get($param->getType()->getName());
            }
        }
        $this->instances[$key] = $reflection->newInstanceArgs($deps);
        return $this->instances[$key];
    }

    public static function getInstance(): self
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        self::$instance = new self;
        return self::$instance;
    }
}