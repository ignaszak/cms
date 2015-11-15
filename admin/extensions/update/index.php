<?php

use VIPSoft\Unzip\Unzip;

$unzipper  = new Unzip();
$zipFilePath = 'https://github.com/ignaszak/cms/archive/master.zip';
$filenames = $unzipper->extract($zipFilePath, __DIR__ . '/tmp/');
