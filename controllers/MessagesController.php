<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:11
 */

include_once ROOT.'/models/Messages.php';

class MessagesController
{
    public function actionList()
    {
        $usersList = array();
        $usersList = Search::getMainList();

        require_once(ROOT.'/views/messages/index.php');

        return true;
    }

    public function actionView($id)
    {
            $userItem = Messages::getUserById($id);

            require_once(ROOT.'/views/messages/index.php');

        return true;
    }
}