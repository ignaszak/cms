<?php

use Ignaszak\Registry\RegistryFactory;

defined('ACCESS') or die();

// Path to curret theme folder
if (System\Router\Storage::isRouteName('admin')) {
    define('THEME_FOLDER', ADMIN_FOLDER . '/themes/Default');
} else {
    define('THEME_FOLDER',
        'themes/' . RegistryFactory::start('file')->register('Conf\Conf')->getTheme()
    );
}

define('THEME_PATH', dirname(__DIR__) . '/' . THEME_FOLDER);
