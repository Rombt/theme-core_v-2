<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeIR\Domains\Assets;

use Rombt\ThemeCore\ThemeIR\Contracts\FunctionComponentInterface;
use Rombt\ThemeCore\ThemeIR\IrId;
use Rombt\ThemeCore\ThemeIR\ThemeConcept;

final readonly class AssetIr extends ThemeConcept
{
    public function __construct(
        IrId $id,
        private AssetCollection $assets,
    ) {
        parent::__construct($id);
    }

    public function assets(): AssetCollection
    {
        return $this->assets;
    }

    /**
     * @return list<FunctionComponentInterface>
     */
    public function functionComponents(): array
    {
        $components = [];

        foreach ($this->assets as $asset) {
            if ($asset->function() === null) {
                continue;
            }

            $function = $asset->function();

            $components[] = new class ($function) implements FunctionComponentInterface {
                public function __construct(
                    private readonly \Rombt\ThemeCore\ThemeIR\FunctionDefinition $function,
                ) {
                }

                public function function(): ?\Rombt\ThemeCore\ThemeIR\FunctionDefinition
                {
                    return $this->function;
                }
            };
        }

        return $components;
    }
}
