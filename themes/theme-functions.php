<?php

use Ignaszak\Registry\RegistryFactory;

/**
 * This file includes theme functions
 */
defined('ACCESS') or die();

/**
 * 
 * loadFile function includes theme file
 * 
 * @param string $file
 * @throws Exception
 */
function loadFile($file)
{
    $cms = RegistryFactory::start()->get('cms');

    $file = THEME_PATH . '/' . $file;

    if (file_exists($file) && is_file($file) && is_readable($file)) {
        include_once($file);
    } else {
        throw new Exception("File <b>$file</b> not found");
    }
}

/**
 * 
 * @param unknown $file
 * @throws Exception
 */
function loadExtensionFile($file)
{
    $cms = RegistryFactory::start()->get('cms');

    $adminExtensionDir = $cms->getAdminExtensionDir();

    $file = "$adminExtensionDir/$file";

    if (file_exists($file) && is_file($file) && is_readable($file)) {
        include_once($file);
    } else {
        throw new Exception("File <b>$file</b> not found");
    }
}
