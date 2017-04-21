<?php
/**
 * Created by PhpStorm.
 * User: Denis Shardanov
 * Date: 28.04.2016
 * Time: 10:45:AM
 */
session_start();

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

function trim_all( $str , $what = NULL , $with = '' )
{
    if( $what === NULL )
    {
        //  Character      Decimal      Use
        //  "\0"            0           Null Character
        //  "\t"            9           Tab
        //  "\n"           10           New line
        //  "\x0B"         11           Vertical Tab
        //  "\r"           13           New Line in Mac
        //  " "            32           Space

        $what   = "\\x00-\\x20";    //all white-spaces and control chars
    }

    return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
}

function checkSpaces($string) {
    $new=rtrim(ltrim($string));

    return $new;
}

function userSave()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];
    $userName = trim_all(strip_tags($_POST['name']));
    $userSName = trim_all(strip_tags($_POST['sname']));
    $userThName = trim_all(strip_tags($_POST['thname']));
    $userBdate = $_POST['bdate'];
    if($_POST['relation']<=0||$_POST['relation']>14)
    {
        $userRelation=1;
    }
    else
    {
        $userRelation=(int)$_POST['relation'];
    }
    if($_POST['gender']<=0||$_POST['gender']>2)
    {
        $userGender=1;
    }
    else
    {
        $userGender=(int)$_POST['gender'];
    }
    if($_POST['orient']<=0||$_POST['orient']>4)
    {
        $userOrient=1;
    }
    else
    {
        $userOrient=(int)$_POST['orient'];
    }
    if($_POST['habits']<=0||$_POST['habits']>5)
    {
        $userHabits=1;
    }
    else
    {
        $userHabits=(int)$_POST['habits'];
    }
    if($_POST['prefer']<=0||$_POST['prefer']>5)
    {
        $userPrefer=1;
    }
    else
    {
        $userPrefer=(int)$_POST['prefer'];
    }
    if($_POST['country']<=0||$_POST['country']>246)
    {
        $userCountry=1;
    }
    else
    {
        $userCountry=(int)$_POST['country'];
    }

    $userWork = (int)$_POST['work'];
    $userStudy = (int)$_POST['study'];

    $userTown =  checkSpaces(strip_tags($_POST['town']));
    $userSearch = (int)$_POST['search'];
    $userMusicGenre = (int)$_POST['music_genre'];
    $userArtist = checkSpaces(strip_tags($_POST['comp']));
    $userFilmGenre = (int)$_POST['film_genre'];
    $userActor = checkSpaces(strip_tags($_POST['actor']));
    $userGameGenre = (int)$_POST['game_genre'];
    $userGame = checkSpaces(strip_tags($_POST['game']));
    $userSocType = (int)$_POST['soc_type'];
    $userInterest = checkSpaces(strip_tags($_POST['interests']));
    $userAbout = checkSpaces(strip_tags($_POST['about']));
    $userReligion = (int)$_POST['religion'];
    $userEmail = checkSpaces(strip_tags($_POST['email']));
    $userMobile = checkSpaces(strip_tags($_POST['mobile']));
    $userVK = checkSpaces(strip_tags($_POST['vk']));
    $userTW = checkSpaces(strip_tags($_POST['twitter']));
    $userInst = checkSpaces(strip_tags($_POST['instagram']));
    $userFb = checkSpaces(strip_tags($_POST['facebook']));
    $userType = (int)$_POST['type'];

    if (!empty($userRelation)&&!empty($userGender)&&!empty($userBdate)&&!empty($userOrient)&&!empty($userHabits)&&!empty($userPrefer)&&!empty($userCountry)&&!empty($userName)&&!empty($userSName))
    {
        $result = $db->prepare('SELECT id_user FROM users_info WHERE id_user = ? LIMIT 1');
        $result->bindParam(1, $id);
        $result->execute();

        if ($result->rowCount() > 0)
        {
            $resultUPD = $db->prepare('UPDATE users_info SET id_gender = ?, id_pref = ?, id_hab = ?, id_orientation = ?, birthday = ?, id_relationship = ?, id_country = ?, lang = ?, name = ?,
sname = ?, thname = ?, live_adr = ?, id_search = ?, id_music_g = ?, fav_comp = ?, id_film_g = ?, fav_act = ?, id_game_g = ?, fav_game = ?, id_soc_type = ?, interests = ?, about = ?, id_religion = ?, email_cont = ?, mobile_cont = ?,
 vk_link = ?, tw_link = ?, inst_link = ?, fb_link = ?, id_type = ? WHERE id_user = ?');
            $resultUPD->bindParam(1, $userGender);
            $resultUPD->bindParam(2, $userPrefer);
            $resultUPD->bindParam(3, $userHabits);
            $resultUPD->bindParam(4, $userOrient);
            $resultUPD->bindParam(5, $userBdate);
            $resultUPD->bindParam(6, $userRelation);
            $resultUPD->bindParam(7, $userCountry);
            $resultUPD->bindParam(8, $userCountry);
            $resultUPD->bindParam(9, $userName);
            $resultUPD->bindParam(10, $userSName);
            $resultUPD->bindParam(11, $userThName);
            $resultUPD->bindParam(12, $userTown);
            $resultUPD->bindParam(13, $userSearch);
            $resultUPD->bindParam(14, $userMusicGenre);
            $resultUPD->bindParam(15, $userArtist);
            $resultUPD->bindParam(16, $userFilmGenre);
            $resultUPD->bindParam(17, $userActor);
            $resultUPD->bindParam(18, $userGameGenre);
            $resultUPD->bindParam(19, $userGame);
            $resultUPD->bindParam(20, $userSocType);
            $resultUPD->bindParam(21, $userInterest);
            $resultUPD->bindParam(22, $userAbout);
            $resultUPD->bindParam(23, $userReligion);
            $resultUPD->bindParam(24, $userEmail);
            $resultUPD->bindParam(25, $userMobile);
            $resultUPD->bindParam(26, $userVK);
            $resultUPD->bindParam(27, $userTW);
            $resultUPD->bindParam(28, $userInst);
            $resultUPD->bindParam(29, $userFb);
            $resultUPD->bindParam(30, $userType);
            $resultUPD->bindParam(31, $id);
            $resultUPD->execute();

            echo "<div id='response_mess'>updated</div>";
        }
    }
    else
    {
        echo('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
    }
}

function userAva()
{
    $db = connect_to();
    $id = (int)$_SESSION['uid'];

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

    function resize_image($file, $w, $h, $ext, $crop=FALSE) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width-($width*abs($r-$w/$h)));
            } else {
                $height = ceil($height-($height*abs($r-$w/$h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
        }

        switch ($ext) {
            case 'image/gif' :
                $src = imagecreatefromgif($file);
                break;
            case 'image/jpg' :
                $src = imagecreatefromjpeg($file);
                break;
            case 'image/jpeg' :
                $src = imagecreatefromjpeg($file);
                break;
            case 'image/pjpeg' :
                $src = imagecreatefromjpeg($file);
                break;
            case 'image/x-png' :
                $src = imagecreatefrompng($file);
                break;
            case 'image/png' :
                $src = imagecreatefrompng($file);
                break;
        }


        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagealphablending($dst, false);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagesavealpha($dst, true);

        return $dst;
    }

    $datetime1 = new DateTime(date("Ymd"));
    $now = $datetime1->format('Ymd'); //Today (YearMonthDay)

    $target_path1 = '../user_uploads/ava/'.$now.'/'.$_SESSION['login'];
    $ext = explode('.', basename( $_FILES['fileAva']['name']));
    $target_path = $target_path1 . md5(uniqid()) . "." . $ext[count($ext)-1];

    $editedImg = $target_path1.generateRandomString() . "." . $ext[count($ext)-1];

    $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["fileAva"]["name"]);
    $extension = end($temp);
    if (
            ($_FILES["fileAva"]["type"] == "image/gif")
            || ($_FILES["fileAva"]["type"] == "image/jpeg")
            || ($_FILES["fileAva"]["type"] == "image/jpg")
            || ($_FILES["fileAva"]["type"] == "image/pjpeg")
            || ($_FILES["fileAva"]["type"] == "image/x-png")
            || ($_FILES["fileAva"]["type"] == "image/png")
        && ($_FILES["fileAva"]["size"] < 2000000)
        && in_array($extension, $allowedExts)) {
        if ($_FILES["fileAva"]["error"] > 0) {
            echo "Return Code: " . $_FILES["fileAva"]["error"] . "<br>";
        } else {
            $filename = $_FILES["fileAva"]["name"];
            echo "Upload: " . $_FILES["fileAva"]["name"] . "<br>";
            echo "Type: " . $_FILES["fileAva"]["type"] . "<br>";
            echo "Size: " . ($_FILES["fileAva"]["size"] / 1024) . " kB<br>";
            echo "Temp file: " . $_FILES["fileAva"]["tmp_name"] . "<br>";

            //Check for existing dir, if no - create it and set it to writable.
            if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/user_uploads/ava/'.$now.'/'.$_SESSION['login'])) {
                mkdir($_SERVER['DOCUMENT_ROOT'].'/user_uploads/ava/'.$now.'/'.$_SESSION['login'], 0777, true);
            }

            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_uploads/ava/'.$now.'/'.$_SESSION['login'].$filename)) {
                echo "<div class='alert'>".$filename . " already exists. </div>";
            } else {


                if(move_uploaded_file($_FILES['fileAva']['tmp_name'], $target_path))
                {

                    $targ_w = $targ_h = 200;
                    $jpeg_quality = 100;

                    switch ($_FILES["fileAva"]["type"]) {
                        case 'image/gif' :
                            $img_r = imageCreateFromGif($target_path);
                            break;
                        case 'image/jpg' :
                            $img_r = imageCreateFromJpeg($target_path);
                            break;
                        case 'image/jpeg' :
                            $img_r = imageCreateFromJpeg($target_path);
                            break;
                        case 'image/pjpeg' :
                            $img_r = imageCreateFromJpeg($target_path);
                            break;
                        case 'image/x-png' :
                            $img_r = imageCreateFromPng($target_path);
                            break;
                        case 'image/png' :
                            $img_r = imageCreateFromPng($target_path);
                            break;
                    }

                    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

                    $img_r = resize_image($target_path, $_POST['w_src'], $_POST['h_src'],$_FILES["fileAva"]["type"]);

                    imagealphablending($dst_r, false);
                    imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'], $targ_w,$targ_h,$_POST['w'],$_POST['h']);
                    imagesavealpha($dst_r, true);

                    switch ($_FILES["fileAva"]["type"]) {
                        case 'image/gif' :
                            imagegif($dst_r, $editedImg);
                            break;
                        case 'image/jpg' :
                            imagejpeg($dst_r, $editedImg, $jpeg_quality);
                            break;
                        case 'image/jpeg' :
                            imagejpeg($dst_r, $editedImg, $jpeg_quality);
                            break;
                        case 'image/pjpeg' :
                            imagejpeg($dst_r, $editedImg, $jpeg_quality);
                            break;
                        case 'image/x-png' :
                            imagepng($dst_r, $editedImg);
                            break;
                        case 'image/png' :
                            imagepng($dst_r, $editedImg);
                            break;
                    }


                    $target_path_fix = '/'.$target_path;
                    $editedImg_fix = '/'.$editedImg;

                    $result = $db->prepare('INSERT INTO user_photos (link_orig, link_res, id_user) VALUES (?, ?, ?)');
                    $result->bindParam(1, $target_path_fix);
                    $result->bindParam(2, $editedImg_fix);
                    $result->bindParam(3, $id);
                    $result->execute();

                    $resultUPD = $db->prepare('UPDATE users_info SET ava = ? WHERE id_user = ?');
                    $resultUPD->bindParam(1, $editedImg_fix);
                    $resultUPD->bindParam(2, $id);
                    $resultUPD->execute();

                    echo "<div class='alert'>The file has been uploaded successfully!</div>".$target_path_fix." ".$editedImg_fix;
                }
                else
                {
                    echo "<div class='alert'>There was an error uploading the file, please try again!</div>";
                }
            }
        }
    } else {
        echo "<div class='alert'>Invalid file</div>";
    }
}

//Check and select function.
if(isset($_POST['action']) && !empty($_POST['action']))
{
    $action = $_POST['action'];

    switch($action)
    {
        case 'saveEdition':
            userSave();
            break;
        case 'saveAva':
            userAva();
            break;
    }
}