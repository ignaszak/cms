<?php

try {

    require __DIR__ . '/conf/constants.php';
    require __BASEDIR__ . '/vendor/autoload.php';
    $app = new App\App;
    $app->validConf();
    $app->run();

    $router = Ignaszak\Registry\RegistryFactory::start()->get('http')->router;
    echo "<div style=\"position:fixed; top:50px;\"><pre>";
    echo $router->group() . '<br>';
    echo $router->name() . '<br>';
    echo $router->controller();
    print_r($router->all());
    echo "</pre></div>";

} catch (Exception $e) {
    $app->catchException($e);
}
