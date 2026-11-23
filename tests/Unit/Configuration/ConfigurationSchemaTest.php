<?php

declare(strict_types=1);

namespace Tests\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Rombt\ThemeCore\Configuration\ConfigurationSchema;
use Rombt\ThemeCore\Configuration\ConfigurationValidator;

final class ConfigurationSchemaTest extends TestCase
{
    public function testThemeArchitectureIsNotAProjectConfigurationField(): void
    {
        $schema = new ConfigurationSchema();

        self::assertArrayNotHasKey('architecture', $schema->rules()['theme']['fields']);

        (new ConfigurationValidator($schema))->validate([
            'project' => ['name' => 'test-project'],
            'theme' => [
                'packages_path' => 'config/themes',
                'package' => 'test-package',
                'resource_package' => 'config/themes/test-package/resources',
            ],
            'environment' => [],
            'paths' => [],
            'php_parser' => [],
            'logging' => [],
            'diagnostic' => [],
        ]);

    }
}
