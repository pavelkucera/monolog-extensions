<?php

/** @var \Composer\Autoload\ClassLoader $autoload */
$autoload = require __DIR__ . '/../vendor/autoload.php';
$autoload->addPsr4('Kucera\Monolog\Tests\\', __DIR__ . '/Monolog', TRUE);
