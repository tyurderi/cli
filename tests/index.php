<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once __DIR__ . '/TestCommand.php';

$app = new \CLI\App();

$app->register(new TestCommand());

$app->run(array_splice($argv, 1));