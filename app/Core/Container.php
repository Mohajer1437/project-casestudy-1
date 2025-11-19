<?php

namespace IdealBoresh\Core;

use Closure;
use InvalidArgumentException;
use ReflectionClass;

class Container
{
    /**
     * Registered bindings for the container.
     *
     * @var array<string, array{resolver: callable|string, shared: bool}>
     */
    private array $bindings = [];

    /**
     * Shared instances keyed by service identifier.
     *
     * @var array<string, mixed>
     */
    private array $instances = [];

    /**
     * Register a binding with the container.
     */
    public function set(string $id, callable|string $resolver, bool $shared = true): void
    {
        $this->bindings[$id] = [
            'resolver' => $resolver,
            'shared'   => $shared,
        ];
    }

    /**
     * Register a non-shared binding.
     */
    public function factory(string $id, callable|string $resolver): void
    {
        $this->set($id, $resolver, false);
    }

    /**
     * Resolve a service from the container.
     *
     * @return mixed
     */
    public function get(string $id)
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        $binding = $this->bindings[$id] ?? null;

        if ($binding === null) {
            $object = $this->autoResolve($id);
            $this->instances[$id] = $object;

            return $object;
        }

        $resolver = $binding['resolver'];
        $object   = $this->build($resolver, $id);

        if ($binding['shared']) {
            $this->instances[$id] = $object;
        }

        return $object;
    }

    /**
     * Build an object using the provided resolver.
     *
     * @return mixed
     */
    private function build(callable|string $resolver, string $id)
    {
        if (is_string($resolver)) {
            if (!class_exists($resolver)) {
                throw new InvalidArgumentException(sprintf('Class %s is not available for binding %s', $resolver, $id));
            }

            return new $resolver();
        }

        if ($resolver instanceof Closure) {
            return $resolver($this);
        }

        return $resolver;
    }

    /**
     * Attempt to automatically resolve a class that has not been bound.
     *
     * @return mixed
     */
    private function autoResolve(string $id)
    {
        if (!class_exists($id)) {
            throw new InvalidArgumentException(sprintf('Unable to resolve dependency: %s', $id));
        }

        $reflection = new ReflectionClass($id);
        $constructor = $reflection->getConstructor();
        if ($constructor === null || $constructor->getNumberOfRequiredParameters() === 0) {
            return new $id();
        }

        throw new InvalidArgumentException(sprintf('Class %s requires binding in the container.', $id));
    }
}
