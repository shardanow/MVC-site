<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 25.02.2016
 * Time: 22:28
 */

//DB connect params
$host='localhost';
$db='d28972_test';
$charset='utf8';
$user='d28972_test';
$pass='password';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO($dsn, $user, $pass, $opt);