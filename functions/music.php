<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 25.12.2015
 * Time: 12:56
 */
session_start();

if(isset($_GET['act'])&&$_GET['act']!='')
{
    function connect()
    {
        $paramsPath = '../config/db_params.php';
        $params = include($paramsPath);
        $opt = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
        $db = new PDO($dsn, $params['user'], $params['password'],$opt);

        return $db;
    }

    function getMusicByIdAdd($url, $img, $name)
    {
        $id_u = $_SESSION['uid'];
        $id_u = intval($id_u);

        if ($id_u&&$url&&$img&&$name) {
            // Подключаемся к БД.
            $db = connect();

            // Запрос к БД.

            $result = $db->prepare('INSERT INTO users_audio (url, img, name, id_usr) VALUES (?, ?, ?, ?)');
            $result->bindParam(1, $url);
            $result->bindParam(2, $img);
            $result->bindParam(3, $name);
            $result->bindParam(4, $id_u);
            $result->execute();

            echo ('Добавлено!');

        }
        else
        {
            echo ('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
        }

    }

    function getMusicByIdRem($url, $name)
    {
        $id_u = $_SESSION['uid'];
        $id_u = intval($id_u);

        if ($id_u&&$url&&$name) {
            // Подключаемся к БД.
            $db = connect();

            // Запрос к БД.

            $result = $db->prepare('DELETE FROM users_audio WHERE url =  ? AND name = ? AND id_usr = ?');
            $result->bindParam(1, $url);
            $result->bindParam(2, $name);
            $result->bindParam(3, $id_u);
            $result->execute();

            echo ('Удалено!');

        }
        else
        {
            echo ('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
        }
    }

    if($_GET['act']=='add_track')
    {
        getMusicByIdAdd($_GET['url'], $_GET['img'], $_GET['name']);
    }
    if($_GET['act']=='rem_track')
    {
        getMusicByIdRem($_GET['url'], $_GET['name']);
    }
}