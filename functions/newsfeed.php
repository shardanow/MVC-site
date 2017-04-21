<?php
/**
 * Created by PhpStorm.
 * User: Denis Shardanov
 * Date: 20.10.2016
 * Time: 14:17:PM
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

function feedVKQuality($quality)
{
    session_start();
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $quality=(int)$quality;

    if (!empty($id) && !empty($quality) && $quality>=604 && $quality<=1280) {
        $result = $db->prepare('SELECT id FROM user_newsfeed_settings WHERE id_user=? LIMIT 1');
        $result->bindParam(1, $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('UPDATE user_newsfeed_settings SET vk_resolution = ? WHERE id_user = ?');
            $result->bindParam(1, $quality);
            $result->bindParam(2, $id);
            $result->execute();

            echo "<div id='response_mess'>Updated!</div>";
        }
        else
        {
            $result = $db->prepare('INSERT INTO user_newsfeed_settings (id_user, vk_resolution) VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $quality);
            $result->execute();

            echo "<div id='response_mess'>New user parameters inserted!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}


function feedVKPostCount($postCount)
{
    session_start();
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $postCount=(int)$postCount;

    if (!empty($id) && !empty($postCount) && $postCount>=4 && $postCount<=10) {
        $result = $db->prepare('SELECT id FROM user_newsfeed_settings WHERE id_user=? LIMIT 1');
        $result->bindParam(1, $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('UPDATE user_newsfeed_settings SET vk_post_count = ? WHERE id_user = ?');
            $result->bindParam(1, $postCount);
            $result->bindParam(2, $id);
            $result->execute();

            echo "<div id='response_mess'>Updated!</div>";
        }
        else
        {
            $result = $db->prepare('INSERT INTO user_newsfeed_settings (id_user, vk_post_count) VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $postCount);
            $result->execute();

            echo "<div id='response_mess'>New user parameters inserted!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}


function feedGrid($gridWidth)
{
    session_start();
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $gridWidth=(int)$gridWidth;

    if (!empty($id) && !empty($gridWidth) && $gridWidth>=3 && $gridWidth<=4) {
        $result = $db->prepare('SELECT id FROM user_newsfeed_settings WHERE id_user=? LIMIT 1');
        $result->bindParam(1, $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('UPDATE user_newsfeed_settings SET columsW = ? WHERE id_user = ?');
            $result->bindParam(1, $gridWidth);
            $result->bindParam(2, $id);
            $result->execute();

            echo "<div id='response_mess'>Updated!</div>";
        }
        else
        {
            $result = $db->prepare('INSERT INTO user_newsfeed_settings (id_user, columsW) VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $gridWidth);
            $result->execute();

            echo "<div id='response_mess'>New user parameters inserted!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function feedSocialFilter($social,$switcher)
{
    session_start();
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $switcher=(int)$switcher;

    if (!empty($id) && !empty($social) && $switcher>=0 && $switcher<=1) {
        $result = $db->prepare('SELECT id FROM user_newsfeed_settings WHERE id_user=? LIMIT 1');
        $result->bindParam(1, $id);
        $result->execute();

        if($social=='vk')
        {
            $social='filter_vk';
        }
        else if($social=='tw')
        {
            $social='filter_tw';
        }
        else if($social=='fb')
        {
            $social='filter_fb';
        }
        else
        {
            exit("<div id='response_mess'>Oops! Error!</div>");
        }

        if ($result->rowCount() > 0) {
            $result = $db->prepare('UPDATE user_newsfeed_settings SET '.$social.' = ? WHERE id_user = ?');
            $result->bindParam(1, $switcher);
            $result->bindParam(2, $id);
            $result->execute();

            echo "<div id='response_mess'>Updated!</div>";
        }
        else
        {
            $result = $db->prepare('INSERT INTO user_newsfeed_settings (id_user, '.$social.') VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $switcher);
            $result->execute();

            echo "<div id='response_mess'>New user parameters inserted!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}


//Check and select function.
if(isset($_POST['action']) && !empty($_POST['action']))
{
    $action = $_POST['action'];

    switch($action)
    {
        case 'setGrid':
            feedGrid($_POST['value']);
            break;
        case 'setVKPostCount':
            feedVKPostCount($_POST['value']);
            break;
        case 'setVKPostQuality':
            feedVKQuality($_POST['value']);
            break;
        case 'setSocialFilter':
            feedSocialFilter($_POST['social'],$_POST['value']);
            break;
    }
}