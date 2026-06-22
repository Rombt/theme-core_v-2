<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Configuration;

use Rombt\ThemeCore\Configuration\Contracts\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private readonly array $data,
    ) {
    }

    public function get(string $key): mixed
    {
        $segments = explode('.', $key);

        $value = $this->data;

        foreach ($segments as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return null;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->data;
    }
}
