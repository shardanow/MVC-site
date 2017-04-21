<?php
/**
 * Created by PhpStorm.
 * User: Шардановы
 * Date: 09.06.2016
 * Time: 13:06
 */


function counter($arg)
{
    if(isset($_SESSION['login'])&&isset($_SESSION['uid'])&&isset($_SESSION['password'])&&isset($_SESSION['token'])&&isset($_SESSION['time'])) {
        $db = connect_to();

        if($arg=='user_messages')
        {
            $result = $db->prepare('SELECT id FROM user_messages WHERE reciver = ? AND flag = 0 AND sender!=?');
            $result->bindParam(1, $_SESSION['uid']);
            $result->bindParam(2, $_SESSION['uid']);
            $result->execute();
            $number_of_rows = $result->fetchColumn();

            return $number_of_rows;
        }
    }
    else
    {
        header("Location: http://linepuls.ru/login");
    }
}


//Check and select function.
if(isset($_POST['action']) && !empty($_POST['action']))
{
    $action = $_POST['action'];

    switch($action)
    {
        case 'countMess':
            counter('user_messages');
            break;
    }
}