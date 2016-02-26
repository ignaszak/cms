<?php

/**
 * CMS root dir
 *
 * @var string
 */
define('__BASEDIR__', dirname(dirname(__DIR__)));

/**
 * Conf dir '{root}/app/conf'
 *
 * @var string
 */
define('__CONFDIR__', __BASEDIR__ . '/app/conf');

/**
 * View dir '{root}/app/view'
 *
 * @var string
 */
define('__VIEWDIR__', __BASEDIR__ . '/app/view');

/**
 * Admin folder name
 *
 * @var string
 */
define('ADMIN_FOLDER', 'admin');

/**
 * Admin dir
 *
 * @var string
 */
define('__ADMINDIR__', __BASEDIR__ . '/app/' . ADMIN_FOLDER);

/**
 * Url to admin panel, example: www.mydomain.com/admin/
 *
 * @var string
 */
define('ADMIN_URL', 'admin');
