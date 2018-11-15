<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 13/11/18
 * Time: 08:51
 */

/**
 * Show Form
 */
$router->get('/', 'App\Controller\IndexController@index');

/**
 * Save data
 */
$router->post('/store', 'App\Controller\IndexController@store');
/**
 * Get Cliente
 */
$router->post('/done', 'App\Controller\IndexController@done');