<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:11
 */

include_once ROOT.'/models/Search.php';

class SearchController
{
    public function actionList()
    {
        $usersList = array();
        $usersList = Search::getMainList();

        require_once(ROOT.'/views/search/index.php');

        return true;
    }

    public function actionView($id)
    {
            $userItem = Search::getUserById($id);

            require_once(ROOT.'/views/search/index.php');

        return true;
    }
}