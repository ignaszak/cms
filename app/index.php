<?php

require __DIR__ . '/conf/constants.php';
require __BASEDIR__ . '/vendor/autoload.php';

$app = new App\App();

try {
    $app->validConf();
    $app->run();
} catch (Exception $e) {
    $app->catchException($e);
}
