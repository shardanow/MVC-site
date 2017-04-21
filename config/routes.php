<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 15:03
 */

return array(
    'user' => 'user/view',
    'news/(-?[0-9_]+)/(-?[0-9_]+)' => 'news/view/$1%2F$2', // actionView in NewsController

    'messages' => 'messages/view',
    'messages/([А-Яа-яЁёA-Za-z0-9-%*()+=#@!^&_$\s]+)' => 'messages/view/$1', // actionView in UserController

    'search' => 'search/view',
    'search/([А-Яа-яЁёA-Za-z0-9-%*()+=#@!^&_$\s]+)' => 'search/view/$1', // actionView in SearchController

    'music/([0-9]+)' => 'music/musicuser/$1', // actionIndex in MusicController

    'login' => 'login/login', // actionIndex in NewsController

    'news' => 'news/index', // actionIndex in NewsController
    //'users' => 'users/list', // actionList in ArticleController

    'users' => 'user/list', // actionIndex in UserController
    'settings' => 'user/settings', // actionIndex in UserController

    'music' => 'music/music', // actionIndex in MusicController

    'line' => 'main/index', // actionIndex in MainController
    '' => 'main/index', // actionIndex in MainController
);