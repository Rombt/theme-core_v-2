<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\Runtime\Formatters;

use Rombt\ThemeCore\Application\Application;
use Rombt\ThemeCore\Application\Contracts\ApplicationContextKeys;
use Rombt\ThemeCore\Runtime\Contracts\ExternalProcessRunnerInterface;
use Rombt\ThemeCore\Runtime\Contracts\ThemeFormatterInterface;

final readonly class PhpcbfThemeFormatter implements ThemeFormatterInterface {

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

		$projectRootPath = $projectRoot->value();

		$phpCbfPath = $projectRootPath
			. DIRECTORY_SEPARATOR . 'vendor'
			. DIRECTORY_SEPARATOR . 'bin'
			. DIRECTORY_SEPARATOR . 'phpcbf.bat';

		$configPath = $projectRootPath
			. DIRECTORY_SEPARATOR . '.phpcs.xml';

		foreach ( $themePaths as $themePath ) {
			$this->processRunner->run(
				array(
					$phpCbfPath,
					'--standard=' . $configPath,
					$themePath,
				)
			);
		}
	}
}
