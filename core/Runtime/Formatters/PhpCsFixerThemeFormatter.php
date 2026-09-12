<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Formatters;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Runtime\Contracts\ExternalProcessRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\ThemeFormatterInterface;

final readonly class PhpCsFixerThemeFormatter implements ThemeFormatterInterface {

	public function __construct(
		private ExternalProcessRunnerInterface $processRunner,
		private Application $app,
	) {
	}

	/**
	 * @param list<string> $themePaths
	 */
	public function format( array $themePaths ): void {
		$projectRoot = $this->app
			->getContext()
			->get( ApplicationContextKeys::PROJECT_ROOT );

		$configPath = $projectRoot->value()
			. DIRECTORY_SEPARATOR . 'core'
			. DIRECTORY_SEPARATOR . 'Runtime'
			. DIRECTORY_SEPARATOR . 'Formatters'
			. DIRECTORY_SEPARATOR . '.php-cs-fixer.php';

		$phpCsFixerPath = $projectRoot->value()
			. DIRECTORY_SEPARATOR . 'vendor'
			. DIRECTORY_SEPARATOR . 'bin'
			. DIRECTORY_SEPARATOR . 'php-cs-fixer.bat';

		foreach ( $themePaths as $themePath ) {
			$this->processRunner->run(
				array(
					$phpCsFixerPath,
					'fix',
					'--config=' . $configPath,
					$themePath,
				)
			);
		}
	}
}
