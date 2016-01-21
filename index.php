<?php
try {
    
    require __DIR__ . '/constants.php';
    require __DIR__ . '/vendor/autoload.php';
    require __DIR__ . '/conf-loader.php';
} catch (CMSException\DBException $e) {
    $exception->catchException($e);
} catch (Doctrine\ORM\Query\QueryException $e) {
    $exception->catchException($e);
} catch (Ignaszak\Router\Exception $e) {
    $exception->catchException($e);
} catch (Exception $e) {
    $exception->catchException($e);
}
