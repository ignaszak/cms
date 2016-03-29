<?php

use App\Resource\RouterStatic;
try {

    require __DIR__ . '/conf/constants.php';
    require __BASEDIR__ . '/vendor/autoload.php';
    $app = new App\App;
    $app->validConf();
    $app->run();


    ?>

    <div style="position: fixed; top: 50px;">
    <pre>
<b>Name:</b> <?php echo RouterStatic::getName(); ?>

<b>Group:</b> <?php echo RouterStatic::getGroup(); ?>

<b>Controller:</b> <?php echo RouterStatic::getController(); ?>

<b>Params:</b> <?php print_r(RouterStatic::getParams()); ?>
    </pre>
    </div>

    <?php

} catch (Exception $e) {
    $app->catchException($e);
}
