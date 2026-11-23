<?php

declare(strict_types=1);

/** Theme Core v2 configuration package entry point. */
return [
    'name' => 'tc2-test',
    'description' => 'Classic Basic starter theme built with Theme Core v2.',
    'version' => '1.0.0',
    'author' => 'Temforge',
    'text_domain' => 'tc2-test',
    'domains' => [
        'nodes' => 'nodes.php',
        'compositions' => 'compositions.php',
        'design-systems' => 'design-system.php',
        'assets' => 'assets.php',
        'integrations' => 'integrations.php',
        'functions' => 'functions.php',
    ],
];
