<?php
use App\Model\Api;

require_once (BASE_DIR . '/vendor/autoload.php');

$app = new Silex\Application();

$app['api'] = function($app) {
    return new Api();
};