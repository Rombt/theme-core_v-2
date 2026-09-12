<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Stages;

use RuntimeException;
use Throwable;
use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Runtime\Context\ExecutionContext;
use Rombt\ThemeCore\Runtime\Contracts\StageInterface;
use Rombt\ThemeCore\Runtime\Contracts\ThemeFormatterInterface;
use Rombt\ThemeCore\Runtime\Result\StageResult;
use Rombt\ThemeCore\Runtime\Session\SessionKeys;

final readonly class FormatThemeStage implements StageInterface
{
    public function __construct(
        private ThemeFormatterInterface $formatter,
    ) {
    }

    public function execute(
        ExecutionContext $context,
        Application $app,
    ): StageResult {
        try {
            $themePaths = $context
                ->session()
                ->getResource(SessionKeys::THEME_BUILD_PATHS);

            if (!is_array($themePaths)) {
                throw new RuntimeException(
                    'Theme build paths are not available.',
                );
            }

            /** @var list<string> $themePaths */
            $this->formatter->format($themePaths);

            return new StageResult(
                success: true,
            );
        } catch (Throwable $e) {
            return new StageResult(
                success: false,
                error: $e,
            );
        }
    }
}
