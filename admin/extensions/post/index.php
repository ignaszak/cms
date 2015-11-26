<?php

use Content\Controller\Factory;
use Content\Controller\PostController;

$title = 'title';

$controller = new Factory(new PostController);

$controller->setPostCategoryId(1);
$controller->setPostAuthorId(1);
$controller->setPostDate(new DateTime);
$controller->setPostTitle($title);
$controller->setPostAlias($title);
$controller->setPostContent('treść');
//$controller->insert();
