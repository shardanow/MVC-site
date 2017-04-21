<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 14:23
 */

include_once ROOT.'/models/News.php';

class NewsController
{
    public function actionIndex()
    {
        $userSocialPosts = array();
        $userSocialPosts = News::getNewsList();

        require_once(ROOT.'/views/news/index.php');

        return true;
    }

    public function actionView($id)
    {
        if($id)
        {
            $userSocialPosts = array();
            $userSocialPosts = News::getNewsItemById($id);

            require_once(ROOT.'/views/news/index.php');
        }

        return true;
    }
}