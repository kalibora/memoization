<?php

namespace Kalibora\Memoization;

class Memoization
{
    /**
     * @var array<string, mixed>
     */
    private array $data = [];

    /**
     * @phpstan-template T
     *
     * @param callable(): T $fetch
     *
     * @return T
     */
    public function memoize(string $key, callable $fetch): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            $result = call_user_func($fetch);

            $this->data[$key] = $result;
        }

        return $this->data[$key];
    }

    public function clear(string $key): void
    {
        unset($this->data[$key]);
    }

    public function clearAll(): void
    {
        $this->data = [];
    }
}
