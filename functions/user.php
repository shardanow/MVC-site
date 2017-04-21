<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 28.12.2015
 * Time: 17:40
 */

function connect_to()
{
    $paramsPath = $_SERVER['DOCUMENT_ROOT'].'/config/db_params.php';
    $params = include($paramsPath);
    $opt = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
    $db = new PDO($dsn, $params['user'], $params['password'],$opt);

    return $db;
}

//Random string.
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function user_active()
{
    if(isset($_SESSION['login'])&&isset($_SESSION['password'])&&isset($_SESSION['token'])&&isset($_SESSION['time'])) {
        $db = connect_to();

        $result = $db->prepare('SELECT login FROM users WHERE login = ? AND password = ? AND token = ? LIMIT 1');
        $result->bindParam(1, $_SESSION['login']);
        $result->bindParam(2, $_SESSION['password']);
        $result->bindParam(3, $_SESSION['token']);
        $result->execute();

        $datetime1 = new DateTime(date("Y-m-d H:i:s"));
        $datetime2 = new DateTime($_SESSION['time']);
        $datetime2->modify("+5 hours"); //or whatever value you want

        $now = $datetime1->format('Y-m-d H:i:s');
        $expired = $datetime2->format('Y-m-d H:i:s');

        //echo '1 NOW: '.$now.' OLD: '.$expired.'<br>';

        if($result->rowCount() > 0 && $datetime1 < $datetime2) {

            if ($datetime1 < $datetime2)
            {
                //$length = 18;
                //$token = bin2hex(openssl_random_pseudo_bytes($length));

                //$_SESSION['token'] = $token;
                $_SESSION['time'] = $now;

                $result = $db->prepare('UPDATE users SET last_login = ? WHERE login = ?');
                $result->bindParam(1, $now);
                $result->bindParam(2, $_SESSION['login']);
                $result->execute();
            }
            if ($datetime1 > $datetime2)
            {
                $_SESSION = array();
                session_unset();
                session_destroy();

                header("Location: https://linepuls.ru/login");
                die();
            }
        }
        else
        {
            $_SESSION = array();
            session_unset();
            session_destroy();

            header("Location: https://linepuls.ru/login");
        }
    }
    else
    {
        $_SESSION = array();
        session_unset();
        session_destroy();

        header("Location: https://linepuls.ru/login");
    }
}

function userExit()
{
    session_start();
    if(isset($_SESSION['login'])&&isset($_SESSION['password'])&&isset($_SESSION['token'])&&isset($_SESSION['time'])) {
        $db = connect_to();

        $result = $db->prepare('SELECT login FROM users WHERE login = ? AND password = ? AND token = ? LIMIT 1');
        $result->bindParam(1, $_SESSION['login']);
        $result->bindParam(2, $_SESSION['password']);
        $result->bindParam(3, $_SESSION['token']);
        $result->execute();

        $datetime1 = new DateTime(date("Y-m-d H:i:s"));

        $now = $datetime1->format('Y-m-d H:i:s');

        if($result->rowCount() > 0) {

                $_SESSION['time'] = $now;

                $result = $db->prepare('UPDATE users SET last_login = ? WHERE login = ?');
                $result->bindParam(1, $now);
                $result->bindParam(2, $_SESSION['login']);
                $result->execute();

                $_SESSION = array();
                session_unset();
                session_destroy();

                header("Location: https://linepuls.ru/login");
                die();
        }
        else
        {
            header("Location: https://linepuls.ru/login");
        }
    }
    else
    {
        header("Location: https://linepuls.ru/login");
    }
}

function userLogOutSocial($social)
{
    session_start();
    if(isset($_SESSION['login'])&&isset($_SESSION['password'])&&isset($_SESSION['token'])&&isset($_SESSION['time'])) {
        $db = connect_to();

        $result = $db->prepare('SELECT login FROM users WHERE login = ? AND password = ? AND token = ? LIMIT 1');
        $result->bindParam(1, $_SESSION['login']);
        $result->bindParam(2, $_SESSION['password']);
        $result->bindParam(3, $_SESSION['token']);
        $result->execute();

        if($result->rowCount() > 0) {
            $null=null;

            if($social=='vk')
            {
                $result = $db->prepare('UPDATE users SET vk_token = ? WHERE login = ?');
                $result->bindParam(1, $null);
                $result->bindParam(2, $_SESSION['login']);
                $result->execute();

                $_SESSION['vk_token']=null;
            }
            else if($social=='ok')
            {
                $result = $db->prepare('UPDATE users SET ok_token = ? WHERE login = ?');
                $result->bindParam(1, $null);
                $result->bindParam(2, $_SESSION['login']);
                $result->execute();

                $_SESSION['ok_token']=null;
            }
            else if($social=='fb')
            {
                $result = $db->prepare('UPDATE users SET fb_token = ? WHERE login = ?');
                $result->bindParam(1, $null);
                $result->bindParam(2, $_SESSION['login']);
                $result->execute();

                $_SESSION['fb_token']=null;
            }
            else if($social=='tw')
            {
                $result = $db->prepare('UPDATE users SET tw_token = ?, tw_token_secret = ? WHERE login = ?');
                $result->bindParam(1, $null);
                $result->bindParam(2, $null);
                $result->bindParam(3, $_SESSION['login']);
                $result->execute();

                $_SESSION['twitter_token']['oauth_token']=null;
                $_SESSION['twitter_token']['oauth_token_secret']=null;
                $_SESSION['tw_step']=null;
            }
        }
        else
        {
            header("Location: https://linepuls.ru/login");
        }
    }
    else
    {
        header("Location: https://linepuls.ru/login");
    }
}

function UserUploadPostImg()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    $ImgResizer = $_SERVER['DOCUMENT_ROOT'].'/functions/imageResize.php';
    include($ImgResizer);

    $datetime1 = new DateTime(date("Ymd"));
    $now = $datetime1->format('Ymd'); //Today (YearMonthDay)

    //Check for existing dir, if no - create it and set it to writable.
    if (!file_exists('user_uploads/posts/images/draft/'.$now.'/'.$_SESSION['login'])) {
        mkdir('user_uploads/posts/images/draft/'.$now.'/'.$_SESSION['login'], 0777, true);
    }

    //Send uploaded Post files to user dir with today date.
    for($i=0; $i<count($_FILES['file']['name']); $i++)
    {
        $target_path1 = 'user_uploads/posts/images/draft/'.$now.'/'.$_SESSION['login'];
        $ext = explode('.', basename( $_FILES['file']['name'][$i]));
        $target_path = $target_path1 . md5(uniqid()) . "." . $ext[count($ext)-1];

        $editedImg = $target_path1.generateRandomString() . "." . $ext[count($ext)-1];

        if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path))
        {
            smart_resize_image($target_path , null, 800 , 500 , false , $editedImg , false , false , 100);

                $target_path_fix = '/'.$target_path;
                $editedImg_fix = '/'.$editedImg;

            $result = $db->prepare('INSERT INTO user_draft (img_link, img_link_prev, id_user, id_touser) VALUES (?, ?, ?, ?)');
            $result->bindParam(1, $target_path_fix);
            $result->bindParam(2, $editedImg_fix);
            $result->bindParam(3, $id);
            $result->bindParam(4, $idTo);
            $result->execute();

            echo "<div class='alert'>The file has been uploaded successfully!</div>";
        }
        else
        {
            echo "<div class='alert'>There was an error uploading the file, please try again!</div>";
        }
    }
}

function UserNewBlogPost()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $blogId = (int)$_POST['blog'];
    $title = strip_tags($_POST['title']);
    $short = strip_tags($_POST['text']);
    $full = strip_tags($_POST['text']);

    if (!empty($id) && !empty($blogId)) {
        //Insert Post
        $result = $db->prepare('INSERT INTO user_posts (id_user, title, short_content, full_content, id_blog) VALUES (?, ?, ?, ?, ?)');
        $result->bindParam(1, $id);
        $result->bindParam(2, $title);
        $result->bindParam(3, $short);
        $result->bindParam(4, $full);
        $result->bindParam(5, $blogId);
        $result->execute();

        //Get last insertion Post id.
        $lastId = $db->lastInsertId();

        //Get user draft
        $result = $db->prepare('SELECT * FROM user_draft WHERE id_user = ? AND id_touser = ?');
        $result->bindParam(1, $id);
        $result->bindParam(2, $blogId);
        $result->execute();

        //Insert all images attached in draft.
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $result_insrt = $db->prepare('INSERT INTO user_posts_images (id_post, link, link_small) VALUES (?, ?, ?)');
                $result_insrt->bindParam(1, $lastId);
                $result_insrt->bindParam(2, $row->img_link);
                $result_insrt->bindParam(3, $row->img_link_prev);
                $result_insrt->execute();
            }

            //Delete draft.
            $result = $db->prepare('DELETE FROM user_draft WHERE id_user =  ? AND id_touser = ?');
            $result->bindParam(1, $id);
            $result->bindParam(2, $blogId);
            $result->execute();
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserNewDraftImgUrl()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];
    $urlImg = $_POST['urlImg'];

    if (!empty($id) && !empty($urlImg)) {
        //Insert Post
        $result = $db->prepare('INSERT INTO user_draft (img_link, img_link_prev, id_user, id_touser) VALUES (?, ?, ?,?)');
        $result->bindParam(1, $urlImg);
        $result->bindParam(2, $urlImg);
        $result->bindParam(3, $id);
        $result->bindParam(4, $idTo);
        $result->execute();
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserDeleteBlogPost()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $blogId = (int)$_POST['blog'];
    $postId = (int)$_POST['post'];

    if (!empty($id) && !empty($blogId) && !empty($postId)) {
        $result = $db->prepare('SELECT id_user FROM user_posts WHERE id_blog = ? AND id_post = ?');
        $result->bindParam(1, $blogId);
        $result->bindParam(2, $postId);
        $result->execute();

        $userItem = $result->fetch();

        if ($userItem['id_user'] == $id || $blogId == $id) {
            if ($result->rowCount() > 0) {
                $resultIMG = $db->prepare('SELECT link,link_small FROM user_posts_images WHERE id_post = ?');
                $resultIMG->bindParam(1, $postId);
                $resultIMG->execute();

                if ($resultIMG->rowCount() > 0)
                {
                    while ($postImg = $resultIMG->fetch(PDO::FETCH_OBJ))
                    {
                        $DelFilePath = $_SERVER['DOCUMENT_ROOT']. $postImg->link;
                        $DelFilePathPrev = $_SERVER['DOCUMENT_ROOT'] . $postImg->link_small;
                        if (file_exists($DelFilePath) && file_exists($DelFilePathPrev)) {
                            unlink($DelFilePath);
                            unlink($DelFilePathPrev);
                        }
                    }
                } else {
                    echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
                }

                $resultDel = $db->prepare('DELETE FROM user_posts WHERE id_post =  ?');
                $resultDel->bindParam(1, $postId);
                $resultDel->execute();

                $resultDelImg = $db->prepare('DELETE FROM user_posts_images WHERE id_post =  ?');
                $resultDelImg->bindParam(1, $postId);
                $resultDelImg->execute();
            }
        }
    }
}

function UserDeleteDraftItem()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $draftId = (int)$_POST['draft'];

    if (!empty($id) && !empty($draftId)) {
        $result = $db->prepare('SELECT id_user,img_link,img_link_prev FROM user_draft WHERE id_user = ? AND id_draft = ?');
        $result->bindParam(1, $id);
        $result->bindParam(2, $draftId);
        $result->execute();

        $userItem = $result->fetch();

        if($userItem['id_user']==$id)
        {
            if ($result->rowCount() > 0) {
                $DelFilePath = $_SERVER['DOCUMENT_ROOT'].$userItem['img_link'];
                $DelFilePathPrev = $_SERVER['DOCUMENT_ROOT'].$userItem['img_link_prev'];
                if (file_exists($DelFilePath) && file_exists($DelFilePathPrev))
                {
                    unlink ($DelFilePath);
                    unlink ($DelFilePathPrev);
                }

                $result = $db->prepare('DELETE FROM user_draft WHERE id_draft =  ?');
                $result->bindParam(1, $draftId);
                $result->execute();


            } else {
                echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
            }
        }
    }
}


function UserLike()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $elementType = (int)$_POST['type'];
    $elementId = (int)$_POST['element'];

    if (!empty($id) && !empty($elementType) && !empty($elementId))
    {
        $result = $db->prepare('SELECT id_element FROM user_likes WHERE id_user = ? AND id_element = ? AND type = ? LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $elementId);
        $result->bindParam(3, $elementType);
        $result->execute();

        if ($result->rowCount() > 0)
        {
            $result = $db->prepare('DELETE FROM user_likes WHERE id_user =  ? AND id_element = ? AND type = ?');
            $result->bindParam(1, $id);
            $result->bindParam(2, $elementId);
            $result->bindParam(3, $elementType);
            $result->execute();

            echo "<div id='response_mess'>unset</div>";
        }
        else
        {
            //Insert Like
            $result = $db->prepare('INSERT INTO user_likes (id_user, type, id_element) VALUES (?, ?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $elementType);
            $result->bindParam(3, $elementId);
            $result->execute();

            echo "<div id='response_mess'>set</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserDisLike()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $elementType = (int)$_POST['type'];
    $elementId = (int)$_POST['element'];

    if (!empty($id) && !empty($elementType) && !empty($elementId))
    {
        $result = $db->prepare('SELECT id_element FROM user_dizlikes WHERE id_user = ? AND id_element = ? AND type = ? LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $elementId);
        $result->bindParam(3, $elementType);
        $result->execute();

        if ($result->rowCount() > 0)
        {
            $result = $db->prepare('DELETE FROM user_dizlikes WHERE id_user =  ? AND id_element = ? AND type = ?');
            $result->bindParam(1, $id);
            $result->bindParam(2, $elementId);
            $result->bindParam(3, $elementType);
            $result->execute();

            echo "<div id='response_mess'>unset</div>";
        }
        else
        {
            //Insert Like
            $result = $db->prepare('INSERT INTO user_dizlikes (id_user, type, id_element) VALUES (?, ?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $elementType);
            $result->bindParam(3, $elementId);
            $result->execute();

            echo "<div id='response_mess'>set</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserFavorite()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $elementType = (int)$_POST['type'];
    $elementId = (int)$_POST['element'];

    if (!empty($id) && !empty($elementType) && !empty($elementId))
    {
        $result = $db->prepare('SELECT id_element FROM user_fav WHERE id_user = ? AND id_element = ? AND type = ? LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $elementId);
        $result->bindParam(3, $elementType);
        $result->execute();

        if ($result->rowCount() > 0)
        {
            $result = $db->prepare('DELETE FROM user_fav WHERE id_user =  ? AND id_element = ? AND type = ?');
            $result->bindParam(1, $id);
            $result->bindParam(2, $elementId);
            $result->bindParam(3, $elementType);
            $result->execute();

            echo "<div id='response_mess'>unset</div>";
        }
        else
        {
            //Insert Like
            $result = $db->prepare('INSERT INTO user_fav (id_user, type, id_element) VALUES (?, ?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $elementType);
            $result->bindParam(3, $elementId);
            $result->execute();

            echo "<div id='response_mess'>set</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserNewMessage()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $reciverId = (int)$_POST['to'];
    $full = strip_tags($_POST['text']);

    if (!empty($id) && !empty($reciverId)) {
        //Insert Post
        $result = $db->prepare('INSERT INTO user_messages (sender, reciver, text) VALUES (?, ?, ?)');
        $result->bindParam(1, $id);
        $result->bindParam(2, $reciverId);
        $result->bindParam(3, $full);
        $result->execute();
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserNewFriendReq()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_friendship_req WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?) LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $id);
        $result->bindParam(3, $idTo);
        $result->bindParam(4, $idTo);
        $result->execute();

        if ($result->rowCount() <= 0) {
            $result = $db->prepare('INSERT INTO user_friendship_req (user_a, user_b) VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $idTo);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}



function UserNewFriendAdd()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_friendship_req WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?) LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $id);
        $result->bindParam(3, $idTo);
        $result->bindParam(4, $idTo);
        $result->execute();

        if ($result->rowCount() > 0)
        {
            $result = $db->prepare('INSERT INTO user_friendship (user_a, user_b) VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $idTo);
            $result->execute();

            $result = $db->prepare('DELETE FROM user_friendship_req WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $id);
            $result->bindParam(3, $idTo);
            $result->bindParam(4, $idTo);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo("<div id='response_mess'><i class='fa fa-exclamation' style='color: red;'></i>Oops, error!</div>");
    }
}

function UserFriendDelReq()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_friendship_req WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?) LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $id);
        $result->bindParam(3, $idTo);
        $result->bindParam(4, $idTo);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('DELETE FROM user_friendship_req WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $id);
            $result->bindParam(3, $idTo);
            $result->bindParam(4, $idTo);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function UserFriendDel()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_friendship WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?) LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $id);
        $result->bindParam(3, $idTo);
        $result->bindParam(4, $idTo);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('DELETE FROM user_friendship WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $id);
            $result->bindParam(3, $idTo);
            $result->bindParam(4, $idTo);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}


function FavoriteUserAdd()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_favorite WHERE user_id=? AND fav_id=? LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $idTo);
        $result->execute();

        if ($result->rowCount() <= 0) {
            $result = $db->prepare('INSERT INTO user_favorite (user_id, fav_id) VALUES (?, ?)');
            $result->bindParam(1, $id);
            $result->bindParam(2, $idTo);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}


function FavoriteUserDel()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_favorite WHERE user_id=? AND fav_id=? LIMIT 1');
        $result->bindParam(1, $id);
        $result->bindParam(2, $idTo);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('DELETE FROM user_favorite WHERE user_id=? AND fav_id=?');
            $result->bindParam(1, $id);
            $result->bindParam(2, $idTo);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function RespectUserAdd()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_respect WHERE user_id=? AND from_id=? LIMIT 1');
        $result->bindParam(1, $idTo);
        $result->bindParam(2, $id);
        $result->execute();

        if ($result->rowCount() <= 0) {
            $result = $db->prepare('INSERT INTO user_respect (user_id, from_id) VALUES (?, ?)');
            $result->bindParam(1, $idTo);
            $result->bindParam(2, $id);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}


function RespectUserDel()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $idTo = (int)$_POST['idto'];

    if (!empty($id) && !empty($idTo)) {
        $result = $db->prepare('SELECT id FROM user_respect WHERE user_id=? AND from_id=? LIMIT 1');
        $result->bindParam(1, $idTo);
        $result->bindParam(2, $id);
        $result->execute();

        if ($result->rowCount() > 0) {
            $result = $db->prepare('DELETE FROM user_respect WHERE user_id=? AND from_id=?');
            $result->bindParam(1, $idTo);
            $result->bindParam(2, $id);
            $result->execute();

            echo "<div id='response_mess'>Done!</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

//Check and select function.
if(isset($_POST['action']) && !empty($_POST['action']))
{
        $action = $_POST['action'];

    switch($action)
    {
        case 'logout':
            userExit();
            break;
        case 'socLogOut':
            userLogOutSocial($_POST['socialName']);
            break;
        case 'uplImgPost':
            UserUploadPostImg();
            break;
        case 'newBlogPost':
            UserNewBlogPost();
            break;
        case 'deleteBlogPost':
            UserDeleteBlogPost();
            break;
        case 'deleteDraftItem':
            UserDeleteDraftItem();
            break;
        case 'newUrlImg':
            UserNewDraftImgUrl();
            break;
        case 'UserLike':
            UserLike();
            break;
        case 'UserDisLike':
            UserDisLike();
            break;
        case 'UserFav':
            UserFavorite();
            break;
        case 'newMessage':
            UserNewMessage();
            break;
        case 'newFriendReq':
            UserNewFriendReq();
            break;
        case 'newFriendAdd':
            UserNewFriendAdd();
            break;
        case 'newFriendDel':
            UserFriendDel();
            break;
        case 'newFriendDelReq':
            UserFriendDelReq();
            break;
        case 'addRespect':
            RespectUserAdd();
            break;
        case 'delRespect':
            RespectUserDel();
            break;
        case 'addFavoriteUser':
            FavoriteUserAdd();
            break;
        case 'delFavoriteUser':
            FavoriteUserDel();
            break;
    }
}