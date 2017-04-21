<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 25.12.2015
 * Time: 12:56
 */
session_start();

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

if(isset($_POST['act'])&&$_POST['act']!='')
{
    function connect()
    {
        $paramsPath = '../config/db_params.php';
        $params = include($paramsPath);
        $opt = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
        $db = new PDO($dsn, $params['user'], $params['password'],$opt);

        return $db;
    }

    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_,', '+/='));
    }

    function check_exist($string, $minlen, $maxlen, $strname)
    {
        if (!preg_match('/[^A-Za-z0-9]/', $string)) // '/[^a-z\d]/i' should also work.
        {
            if(ctype_alnum($string))
            {
                if (strlen($string)<$minlen)
                {
                    echo $strname." не должен быть короче ".$minlen." символов.";
                    exit;
                }
                elseif(strlen($string)>$maxlen)
                {
                    echo $strname." не должен быть длинее ".$maxlen." символов.";
                    exit;
                }
            }
            else
            {
                echo $strname." может содержать только английские символы и цифры от 0-9.";
                exit;
            }
        }
        else
        {
            echo $strname." может содержать только английские символы и цифры от 0-9.";
            exit;
        }
    }

    function login($login, $password)
    {

        check_exist($login,4,50,'Логин');
        check_exist($password,4,50,'Пароль');

        if ($login&&$password) {
            // Подключаемся к БД.
            $db = connect();


            $result = $db->prepare('SELECT password, login FROM users WHERE login = ?');
            $result->bindParam(1, $login);
            $result->execute();

            if($result->rowCount() > 0)
            {
                while($row=$result->fetch(PDO::FETCH_OBJ)) {
                    /*its getting data in line.And its an object*/
                    $pass_for_check=$row->password;
                }
            }
            else if($result->rowCount() <=0)
            {
                echo ('Такого пользователя не существует!');
                exit;
            }


        $key = 'die when try to encrypt this';
            $string = $pass_for_check; // note the spaces

            $data = base64_url_decode($string);
            $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));

            $decrypted = rtrim(
                mcrypt_decrypt(
                    MCRYPT_RIJNDAEL_128,
                    hash('sha256', $key, true),
                    substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
                    MCRYPT_MODE_CBC,
                    $iv
                ),
                "\0"
            );


            if($decrypted == $password)
            {

                // Запрос к БД.

                $result = $db->prepare('SELECT login,password,id_user,vk_token,ok_token,fb_token,tw_token,tw_token_secret FROM users WHERE login = ? LIMIT 1');
                $result->bindParam(1, $login);
                $result->execute();

                if($result->rowCount() > 0)
                {
                    $length = 18;
                    $token = bin2hex(openssl_random_pseudo_bytes($length));
                    $time_now = date("Y-m-d H:i:s");
                    $_SESSION['twitter_token']=array();

                    while($row=$result->fetch(PDO::FETCH_OBJ)) {
                        /*its getting data in line.And its an object*/
                        $_SESSION['login']=$row->login;
                        $_SESSION['uid']=$row->id_user;
                        $_SESSION['password']=$row->password;
                        $_SESSION['vk_token']=$row->vk_token;
                        $_SESSION['ok_token']=$row->ok_token;
                        $_SESSION['fb_token']=$row->fb_token;
                        $_SESSION['twitter_token']['oauth_token']=$row->tw_token;
                        $_SESSION['twitter_token']['oauth_token_secret']=$row->tw_token_secret;
                    }


                    $result = $db->prepare('UPDATE users SET token = ?, last_login = ? WHERE login = ?');
                    $result->bindParam(1, $token);
                    $result->bindParam(2, $time_now);
                    $result->bindParam(3, $login);
                    $result->execute();

                    $_SESSION['token']=$token;
                    $_SESSION['time'] = $time_now;

                    echo (' Вы успешно вошли!');
                    exit;
                }
            }
            else
            {
                echo ('Неверный пароль!');
                exit;
            }

        }
        else
        {
            echo ('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
            exit;
        }

    }

    function register($login, $password, $email, $name, $sname, $gender)
    {
        check_exist($login,4,50,'Логин');
        check_exist($password,4,50,'Пароль');

        if ($login&&$password&&$email) {
            // Подключаемся к БД.
            $db = connect();

            $result = $db->prepare('SELECT login FROM users WHERE login = ? LIMIT 1');
            $result->bindParam(1, $login);
            $result->execute();

            if($result->rowCount() > 0)
            {
                echo ('Такой логин уже занят!');
                exit;
            }

            $key = 'die when try to encrypt this';
            $string = $password; // note the spaces


            $iv = mcrypt_create_iv(
                mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
                MCRYPT_DEV_URANDOM
            );

            $encrypted_pass = base64_encode(
                $iv .
                mcrypt_encrypt(
                    MCRYPT_RIJNDAEL_128,
                    hash('sha256', $key, true),
                    $string,
                    MCRYPT_MODE_CBC,
                    $iv
                )
            );

            $name=checkSpaces($name);
            $sname=checkSpaces($sname);
            if($gender<=0||$gender>2)
            {
                $gender=1;
            }
            else
            {
                $gender=(int)$gender;
            }

            // Запрос к БД.

            $result = $db->prepare('INSERT INTO users (login, password, email) VALUES (?, ?, ?)');
            $result->bindParam(1, $login);
            $result->bindParam(2, $encrypted_pass);
            $result->bindParam(3, $email);
            $result->execute();

            $result = $db->prepare('INSERT INTO users_info (name, sname, id_gender) VALUES (?, ?, ?)');
            $result->bindParam(1, $name);
            $result->bindParam(2, $sname);
            $result->bindParam(3, $gender);
            $result->execute();

            if($result)
            {
                echo ('Теперь вы зарегестрированы! Расскажите еще немного о себе.');
                $_SESSION['step']=2;
                login($login, $password);

                exit;
            }
            else
            {
                echo ('Ошибка при регистрации!');
                exit;
            }

        }
        else
        {
            echo ('<i class="fa fa-exclamation" style="color: red;"> Oops, error!</i>');
            exit;
        }
    }

    if($_POST['act']=='reg')
    {
        if(isset($_POST['reg_gender']))
        {
            $gender = $_POST['reg_gender'];
        }

        register($_POST['reg_username'], $_POST['reg_password'], $_POST['reg_email'], $_POST['reg_fullname'], $_POST['reg_surname'], $gender);
    }
    if($_POST['act']=='login')
    {
        login($_POST['lg_username'], $_POST['lg_password']);
    }

    function userAva()
    {
        $db = connect();
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

        function resize_image($file, $w, $h, $crop=FALSE) {
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
            $src = imagecreatefromjpeg($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

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
                echo "<html><body><div class='log'>Return Code: " . $_FILES["fileAva"]["error"] . "<br></div></body></html>";
            } else {
                $filename = $_FILES["fileAva"]["name"];
                //echo "<html><body><div class='log'>Upload: " . $_FILES["fileAva"]["name"] . "<br>";
               // echo "Type: " . $_FILES["fileAva"]["type"] . "<br>";
              //  echo "Size: " . ($_FILES["fileAva"]["size"] / 1024) . " kB<br>";
               // echo "Temp file: " . $_FILES["fileAva"]["tmp_name"] . "<br></div>";

                //Check for existing dir, if no - create it and set it to writable.
                if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/user_uploads/ava/'.$now.'/'.$_SESSION['login'])) {
                    mkdir($_SERVER['DOCUMENT_ROOT'].'/user_uploads/ava/'.$now.'/'.$_SESSION['login'], 0777, true);
                }

                if (file_exists($_SERVER['DOCUMENT_ROOT'].'/user_uploads/ava/'.$now.'/'.$_SESSION['login'].$filename)) {
                    echo "<html><body><div class='alert'>".$filename . " already exists. </div></body></html>";
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
                            case 'image/bmp' :
                                $img_r = imageCreateFromBmp($target_path);
                                break;
                        }

                        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

                        $img_r = resize_image($target_path, $_POST['w_src'], $_POST['h_src']);

                        imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'], $targ_w,$targ_h,$_POST['w'],$_POST['h']);

                        imagejpeg($dst_r, $editedImg, $jpeg_quality);

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

                        $_SESSION['avaLink']=$editedImg_fix;
                        $_SESSION['step']=3;

                     //   echo "<div class='alert'>The file has been uploaded successfully! ".$target_path_fix." ".$editedImg_fix."</div>";
                        echo "<div id='avaLink'>$editedImg_fix</div></body></html>";
                    }
                    else
                    {
                        echo "<html><body><div class='alert'>There was an error uploading the file, please try again!</div></body></html>";
                    }
                }
            }
        } else {
            echo "<html><body><div class='alert'>Invalid file</div></body></html>";
        }
    }

    function lastStep()
    {
        $db = connect();

        $type=(int)$_POST['who'];
        if($_POST['country']<=0||$_POST['country']>246)
        {
            $country=1;
        }
        else
        {
            $country=(int)$_POST['country'];
        }

        if($_POST['orientation']<=0||$_POST['orientation']>4)
        {
            $orientation=1;
        }
        else
        {
            $orientation=(int)$_POST['orientation'];
        }

        $about=checkSpaces(strip_tags($_POST['about']));

        $result = $db->prepare('UPDATE users_info SET birthday = ?, id_type = ?, id_country=?, id_orientation=?, about = ? WHERE id_user = ?');
        $result->bindParam(1, $_POST['birthday']);
        $result->bindParam(2, $type);
        $result->bindParam(3, $country);
        $result->bindParam(4, $orientation);
        $result->bindParam(5, $about);
        $result->bindParam(6, $_SESSION['uid']);
        $result->execute();

        $_SESSION['step']=0;

        echo ('Ура! Теперь вы часть нас! Спасибо!');
    }

    function vkAuth($token)
    {
        $db = connect();

        $result = $db->prepare('UPDATE users SET vk_token = ? WHERE id_user = ?');
        $result->bindParam(1, $token);
        $result->bindParam(2, $_SESSION['uid']);
        $result->execute();

        echo ('Вы успешно авторизировались через VK!');
    }

    function okAuth($token)
    {
        $db = connect();

        $result = $db->prepare('UPDATE users SET ok_token = ? WHERE id_user = ?');
        $result->bindParam(1, $token);
        $result->bindParam(2, $_SESSION['uid']);
        $result->execute();

        echo ('Вы успешно авторизировались через OK!');
    }

    function fbAuth($token)
    {
        $db = connect();

        $result = $db->prepare('UPDATE users SET fb_token = ? WHERE id_user = ?');
        $result->bindParam(1, $token);
        $result->bindParam(2, $_SESSION['uid']);
        $result->execute();

        echo ('Вы успешно авторизировались через Facebook!');
    }

    function twAuth($token,$token_secret)
    {
        $db = connect();

        $result = $db->prepare('UPDATE users SET tw_token = ?, tw_token_secret = ? WHERE id_user = ?');
        $result->bindParam(1, $token);
        $result->bindParam(2, $token_secret);
        $result->bindParam(3, $_SESSION['uid']);
        $result->execute();

        echo ('Вы успешно авторизировались через Twitter!');
    }


    //Check and select function.
    if(isset($_POST['act']) && !empty($_POST['act']))
    {
        $action = $_POST['act'];

        switch($action)
        {
            case 'saveAva':
                userAva();
                break;
            case 'lastStep':
                lastStep();
                break;
            case 'vkAuth':
                vkAuth($_POST['token']);
                break;
            case 'okAuth':
                okAuth($_POST['token']);
                break;
            case 'fbAuth':
                fbAuth($_POST['token']);
                break;
            case 'twAuth':
                twAuth($_POST['token'],$_POST['token_secret']);
                break;
        }
    }
}
