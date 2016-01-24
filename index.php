<?php
try {

    require __DIR__ . '/constants.php';
    require __DIR__ . '/vendor/autoload.php';
    $app = new App\App;
    $app->validConf();
    $app->run();
} catch (Exception $e) {
    $app->catchException($e);
}
