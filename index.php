<?php

try {

    require __DIR__ . '/constants.php';
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/error-handler.php';

    Conf\DB\DBDoctrine::configure();
    $conf = Conf\Conf::instance();

    require __DIR__ . '/routs-loader.php';
    require __DIR__ . '/modules-loader.php';
    require __DIR__ . '/themes/theme-constants.php';

    $controllerFile = System\Router\Storage::getControllerFile();
    if (file_exists($controllerFile) && is_file($controllerFile) && is_readable($controllerFile))
        require_once $controllerFile;

    require __DIR__ . '/themes/theme-loader.php';

}
catch (CMSException\DBException $e) {
    $exception->catchException($e);
}
catch (Doctrine\ORM\Query\QueryException $e) {
    $exception->catchException($e);
}
catch (Ignaszak\Router\Exception $e) {
    $exception->catchException($e);
}
catch (Exception $e) {
    $exception->catchException($e);
}

?>