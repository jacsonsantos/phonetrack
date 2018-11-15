<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 12/11/18
 * Time: 22:07
 */

/**
 * Dump Die
 */
function dd($arr) {
    echo '<pre>';
    var_dump($arr);
    die;
}
/**
 * Carrega configurações do config.json
 * @param string $key
 */
function config($key) {
    global $app;
    return $app['config']->$key;
}

/**
 * Load view
 */
function view($view, $data = [],$path = 'app/View') {
    ob_start();

    $view = str_replace('.','/',$view);
    $view = "{$path}/{$view}.phtml";

    if (!file_exists($view)) {
        return "view not exist.";
    }

    extract($data);
    require_once $view;

    return ob_get_clean();
}

/**
 * Response JSON
 * @param array|string $args
 * @return json
 */
function responseJson($args) {
    header('Content-Type: application/json');
    return json_encode($args);
}

/**
 * Start Session
 */
function startSession() {
    $_token = _token();
    if(empty($_token)) session_start();

    $_SESSION['token'] = _token();
}

/**
 * Token Session
 */
function _token() {
    $secret = md5($_SERVER['REMOTE_ADDR']);
    return session_id($secret);
}

/**
 * Redirect URL
 * @param string $url
 */
function redirect($url) {
    header("Location: {$url}");
}

/**
 * Format Date
 * @param string $format
 * @param string $date
 * @return string $date
 */

function dateFormat($format_out, $date, $format_input)
{
    if (is_null($date) || empty($date)) {
        return null;
    }

    $d = \DateTime::createFromFormat($format_input, $date);
    return $d->format($format_out);
}