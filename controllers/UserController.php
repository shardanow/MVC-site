<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:11
 */

include_once ROOT.'/models/User.php';

class UserController
{
    public function actionList()
    {
        $usersList = array();
        $usersList = User::getUsersList();

        require_once(ROOT.'/views/user/list.php');

        return true;
    }

    public function actionView($id)
    {
            $userItem = User::getUserById($id);

            require_once(ROOT.'/views/user/index.php');

        return true;
    }

    public function actionSettings()
    {
            $userItem = User::getUserSettings();

            require_once(ROOT.'/views/user/user_settings.php');

        return true;
    }
}