<?php
$exception->errorReporting = E_ALL;
$exception->display = 'dev';
$exception->userReporting = E_ALL & ~ E_NOTICE;
$exception->userMessage = 'Error occured.';
$exception->userLocation = '';
$exception->createLogFile = false;
$exception->logFileDir = __BASEDIR__ . '/data/logs';
