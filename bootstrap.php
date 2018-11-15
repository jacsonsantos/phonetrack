<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 12/11/18
 * Time: 22:25
 */

ini_set('error_reporting', 0);

if (!file_exists('config.json')) {
    dd("config.json not exist");
}

$app["config"] = json_decode(file_get_contents('config.json'));

if ($app['config']->debug) {
    ini_set('error_reporting', E_ALL);
}

require_once "vendor/autoload.php";
require_once "helper/database.php";
require_once "helper/functions.php";

$app['pdo'] = connection($app);