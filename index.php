<?php

// Composer
require_once __DIR__.'/vendor/autoload.php';

// Kernel
$app = require __DIR__.'/web/config/kernel.php';

// OAuth
require __DIR__.'/web/config/kernel-oauth.php';

// Controllers
require __DIR__.'/web/src/controllers/controllers.lt.php';
require __DIR__.'/web/src/controllers/controllers.AG.php';
require __DIR__.'/web/src/controllers/controllers.ff.php';
require __DIR__.'/web/src/controllers/api-requests.php';

$app->run();
