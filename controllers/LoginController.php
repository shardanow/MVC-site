<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:11
 */

include_once ROOT.'/models/Login.php';

class LoginController
{
    public function actionLogin()
    {
        $uList = array();
        $uList = Login::getLogin();

        require_once(ROOT.'/views/login/login.php');

        return true;
    }
}