<?php
/**
 * Created by PhpStorm.
 * User: Шардановы
 * Date: 09.06.2016
 * Time: 14:19
 */

function connect_to()
{
    $paramsPath = $_SERVER['DOCUMENT_ROOT'].'/config/db_params.php';
    $params = include($paramsPath);
    $opt = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
    $db = new PDO($dsn, $params['user'], $params['password'],$opt);

    return $db;
}

function readMess()
{
    session_start();
    $db = connect_to();

    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['to'];

    $result = $db->prepare('UPDATE user_messages SET flag = 1 WHERE sender = ? AND reciver = ? AND flag=0');
    $result->bindParam(1, $idTo);
    $result->bindParam(2, $id);
    $result->execute();
}

//Check and select function.
if(isset($_POST['action']) && !empty($_POST['action']))
{
    $action = $_POST['action'];

    switch($action)
    {
        case 'readMess':
            readMess();
            break;
    }
}