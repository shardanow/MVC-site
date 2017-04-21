<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 14:11
 */
session_start();

include_once $_SERVER['DOCUMENT_ROOT'].'/functions/user.php';
if(basename($_SERVER['REQUEST_URI']) != 'login'){
    user_active();
}

// FRONT CONTROLLER

// 1 - Общие настройки.
    ini_set('display_errors',1);
    error_reporting(E_ALL);

// 2 - Подключение файлов системы.
    define('ROOT',dirname(__FILE__));
    require_once(ROOT.'/components/Router.php');

// 3 - Установка соединения с БД.

require_once(ROOT.'/components/Db.php');


// 4 - Вызов Router.
    $router = new Router();
    $router->run();