<?php

use System\Server;
use System\Router\Storage as Router;
use Content\Controller\Factory;
use Content\Controller\PostController;

define('FORM_ACTION', Router::getRoute('formAction')) ;

$controller = new Factory(new PostController);
$catId = $_POST['categoryId'];
$controller->setReference('category', $catId);
$controller->setReference('author', 1);
$controller->setDate(new DateTime);
$controller->setTitle($_POST['title']);
$controller->setAlias($_POST['title']);
$controller->setContent($_POST['content']);

if (FORM_ACTION == 'new') {
    $controller->insert();
}

if (FORM_ACTION) Server::headerLocationReferer();
