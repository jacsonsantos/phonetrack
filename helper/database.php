<?php
/**
 * Created by PhpStorm.
 * User: jacson
 * Date: 12/11/18
 * Time: 22:42
 */

function connection($app){
    try{
        $dsn = sprintf("%s:host=%s;dbname=%s",
            $app['config']->database->driver,
            $app['config']->database->host,
            $app['config']->database->dbname
        );

        $user = $app['config']->database->username;

        $password = $app['config']->database->password;

        $conn = new \PDO($dsn, $user, $password);
        $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (\PDOException $exception) {
        dd("Connection error");
    }

    return null;
};