<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:11
 */

include_once ROOT.'/models/Main.php';

class MainController
{
    public function actionIndex()
    {
        $mainList = array();
        $mainList = Main::getMainList();

        require_once(ROOT.'/views/main/index.php');

        return true;
    }
}