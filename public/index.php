<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 12/11/18
 * Time: 22:23
 */

use App\Src\Http\Router;

chdir(dirname(__DIR__));

header('Access-Control-Allow-Origin: *');

require_once('bootstrap.php');

startSession();

$router = new Router();

require_once('router/web.php');

$application = new App\Src\Application();
$application->run();