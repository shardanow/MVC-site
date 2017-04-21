<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 17:08
 */

class Db
{
    public static function getConnection()
    {
        try {
            $paramsPath = ROOT.'/config/db_params.php';
            $params = include($paramsPath);
            $opt = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'"
            );
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
            $db = new PDO($dsn, $params['user'], $params['password'],$opt);
            return $db;

        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

    }
}
