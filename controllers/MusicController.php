<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:11
 */

include_once ROOT.'/models/Music.php';

class MusicController
{
    public function actionMusic()
    {
        $musicList = array();
        $musicList = Music::getMusicList();

        require_once(ROOT.'/views/music/music.php');

        return true;
    }

    public function actionMusicUser($id)
    {
        if($id)
        {
        $musicList = array();
        $musicList = Music::getMusicListUser($id);

        require_once(ROOT.'/views/music/music_user.php');
        }

        return true;
    }

}