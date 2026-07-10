<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration\Domains\Assets;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\IrExportableInterface;

final readonly class AssetsConfiguration implements
    ConfigurationDomainInterface,
    IrExportableInterface
{
    /**
     * @param array<string, array<string, mixed>> $assets
     */
    public function __construct(
        private array $assets,
    ) {
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function assets(): array
    {
        return $this->assets;
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function toArray(): array
    {
        return $this->normalize($this->assets);
    }

    /**
     * @param array<string, array<string, mixed>> $assets
     *
     * @return array<string, array<string, mixed>>
     */
    private function normalize(
        array $assets,
    ): array {
        foreach ($assets as $id => &$asset) {
            $asset['type'] = (string) ($asset['type'] ?? '');

            $asset['entry'] = (string) ($asset['entry'] ?? '');

            $asset['dependencies'] = array_values(
                $asset['dependencies'] ?? [],
            );
        }

        return $assets;
    }
}
