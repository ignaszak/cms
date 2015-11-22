<?php

use ContentController\Factory;
use ContentController\PostController;

$title = 'title';

$controller = new Factory(new PostController);

$controller->setPostCategoryId(1);
$controller->setPostAuthorId(1);
$controller->setPostDate(new DateTime);
$controller->setPostTitle($title);
$controller->setPostAlias($title);
$controller->setPostContent('treść');
$controller->insert();
