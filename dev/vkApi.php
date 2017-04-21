<?php
session_start();
if (!isset($_SESSION['counter'])) $_SESSION['counter']=0;
echo "Вы обновили эту страницу ".$_SESSION['counter']++." раз. ";
echo "<br><a href=".$_SERVER['PHP_SELF'].">обновить";

print_r($_SESSION);



$client_id = '5500858'; // ID приложения
$client_secret = 'AULvYm9JPGyZ7JmHjFSO'; // Защищённый ключ
$redirect_uri = 'http://linepuls.ru/dev/vkApi.php'; // Адрес сайта

$url = 'http://oauth.vk.com/authorize';

$params = array(
    'client_id'     => $client_id,
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'scope' => 'wall,friends,offline'
);

echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через ВКонтакте</a></p>';

if (!empty($_GET['code'])&&empty($_SESSION['vk_token'])) {

    if(empty($_SESSION['vk_token']))
    {
        $params = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $_GET['code'],
            'redirect_uri' => $redirect_uri
        );

        $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
        $_SESSION['vk_token'] = $token['access_token'];
    }
}

if (!empty($_SESSION['vk_token'])) {
    $params = array(
        'filters' => 'audio',
        'count' => '3',
        'access_token' => $_SESSION['vk_token']
    );

    $userInfo = json_decode(file_get_contents('https://api.vk.com/method/newsfeed.get' . '?' . urldecode(http_build_query($params))), true);

    if (isset($userInfo['response']['items'][0])) {
        $userInfoArr=$userInfo;
        $userInfo = $userInfo['response']['items'];
        $result = true;
    }
}

if ($result) {
    echo '<pre>',print_r($userInfoArr,1),'</pre>';

    for ($i = 0; $i < count($userInfo); $i++) {
        if (isset($userInfo[$i]['attachment']))
        {
            echo "<div><br>";

            if (isset($userInfo[$i]['attachment']['photo'])) {

                $photoURL = $userInfo[$i]['attachment']['photo']['src_big'];
                $data = getimagesize($photoURL);
                $width = $data[0];
                $height = $data[1];

                if($width>=50&&$height>=50)
                {
                    echo $userInfo[$i]['text'] . "<img src='{$photoURL}'/>" . '<br>';
                }
            }
            if(isset($userInfo[$i]['attachment']['audio']))
            {
                $songName = $userInfo[$i]['attachment']['audio']['artist'].' - '.$userInfo[$i]['attachment']['audio']['title'];
                echo "<br>";
                echo "<audio title='{$songName}' controls preload='none'><source src='{$userInfo[$i]['attachment']['audio']['url']}' type='audio/mpeg'></audio>";
                echo "<br>";
            }

                for ($iAtt = 1; $iAtt < count($userInfo[$i]['attachments']); $iAtt++) {
                    if (isset($userInfo[$i]['attachments'][$iAtt]['photo'])) {
                        echo "<br>";
                        echo "<img src='{$userInfo[$i]['attachments'][$iAtt]['photo']['src_big']}'/>";
                        echo "<br>";
                    }
                }

            for ($iAtt = 0; $iAtt < count($userInfo[$i]['attachments']); $iAtt++) {
                if (isset($userInfo[$i]['attachments'][$iAtt]['audio'])) {
                    $songName = $userInfo[$i]['attachments'][$iAtt]['audio']['artist'].' - '.$userInfo[$i]['attachments'][$iAtt]['audio']['title'];
                    echo "<br>";
                    echo "<audio title='{$songName}' controls preload='none'><source src='{$userInfo[$i]['attachments'][$iAtt]['audio']['url']}' type='audio/mpeg'></audio>";
                    echo "<br>";
                }
            }
            echo "</div><br>";
        }
    }
}

?>
<?php

function get_web_page($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
    );

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}

?>