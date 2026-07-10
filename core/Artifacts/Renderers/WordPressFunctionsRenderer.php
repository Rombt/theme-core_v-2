<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Artifacts\Renderers;

use Rombt\ThemeCore\Artifacts\Contracts\AssetRegistrationRendererInterface;
use Rombt\ThemeCore\WordPress\Assets\AssetRegistrationCollection;

final class WordPressFunctionsRenderer implements AssetRegistrationRendererInterface
{
    public function render(
        AssetRegistrationCollection $registrations,
    ): string {
        $lines = [
            '<?php',
            '',
            'declare(strict_types=1);',
            '',
            "add_action('wp_enqueue_scripts', static function (): void {",
        ];

        foreach ($registrations as $registration) {
            $function = $registration->type() === 'style'
                ? 'wp_enqueue_style'
                : 'wp_enqueue_script';

            $lines[] = sprintf(
                "    %s('%s');",
                $function,
                $registration->handle(),
            );
        }

        $lines[] = '});';

        return implode("\n", $lines);
    }
}
