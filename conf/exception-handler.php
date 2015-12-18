<?php

$exception = new Ignaszak\Exception\Start;

$exception->errorReporting = E_ALL;
$exception->display = 'dev';
$exception->userReporting = E_ALL & ~E_NOTICE;
$exception->userMessage = 'Error occured.';
$exception->userLocation = '';
$exception->createLogFile = false;
$exception->logFileDir = __DIR__ . '/logs';

$exception->run();
