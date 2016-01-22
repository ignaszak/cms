<?php
try {

    require __DIR__ . '/constants.php';
    require __DIR__ . '/vendor/autoload.php';
    $app = new App\App;
    $app->run();
} catch (CMSException\DBException $e) {
    $app->catchException($e);
} catch (Doctrine\ORM\Query\QueryException $e) {
    $app->catchException($e);
} catch (Ignaszak\Router\Exception $e) {
    $app->catchException($e);
} catch (Exception $e) {
    $app->catchException($e);
}
