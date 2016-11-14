<?php
define('BASE_DIR', realpath(__DIR__));

$app = require_once (BASE_DIR . '/src/app.php');

$app['debug'] = false;

$app['json.data'] = BASE_DIR . "/data/vagas.json";

$app->run();