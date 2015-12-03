<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/config/kernel.php';
require __DIR__.'/config/kernel-oauth.php';



require __DIR__.'/src/controllers/controllers.lt.php';

require __DIR__.'/src/controllers/controllers.AG.php';

//require __DIR__.'/src/controllers/controllers.php';
require __DIR__.'/src/controllers/controllers.ff.php';




$app->run();
