#!/usr/bin/env php
<?php
use AutoShell\Console;

$autoload = null;

$autoloadFiles = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../autoload.php'
];

foreach ($autoloadFiles as $autoloadFile) {
    if (file_exists($autoloadFile)) {
        $autoload = $autoloadFile;
        break;
    }
}

if (! $autoload) {
    echo "Autoload file not found; try 'composer dump-autoload' first." . PHP_EOL;
    exit(1);
}

require $autoload;

$console = Console::new(
    namespace: 'PhpStyler\Command',
    directory: dirname(__DIR__) . '/src/Command',
    help: 'PHPStyler by Paul M. Jones' . PHP_EOL . PHP_EOL,
);

$code = $console($_SERVER['argv']);
exit($code);
