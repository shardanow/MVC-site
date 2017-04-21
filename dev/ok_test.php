<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 10.02.2017
 * Time: 23:43
 */

$ok_client_id = '1249773056'; // Application ID
$ok_public_key = 'CBAHAPHLEBABABABA'; // Публичный ключ приложения
$ok_client_secret = '22B1E47122B106DAEB2B6329'; // Секретный ключ приложения
$ok_redirect_uri = 'https://linepuls.ru/dev/ok_test.php'; // Ссылка на приложение

$ok_url = 'https://connect.ok.ru/oauth/authorize';
$ok_params = array(
    'client_id'     => $ok_client_id,
    'scope' =>  'VALUABLE_ACCESS;LONG_ACCESS_TOKEN;PHOTO_CONTENT;GROUP_CONTENT;VIDEO_CONTENT',
    'response_type' => 'code',
    'redirect_uri'  => $ok_redirect_uri
);

if(empty($_SESSION['ok_token'])) {
    echo $ok_link = '<p class="ok-auth-btn"><a class="btn btn-primary" href="' . $ok_url . '?' . urldecode(http_build_query($ok_params)) . '">Привязать Одноклассники</a></p>';
}
else
{
    echo "<p class='ok-auth-btn'><a class='btn btn-primary' onclick='logOutSocial(".$special."ok".$special.")' href='#'>Отвязать Одноклассники</a></p>";
}


if (!empty($_GET['code'])&&empty($_SESSION['ok_token'])) {

if(empty($_SESSION['ok_token']))
{
print_r($_GET['code']);
$ok_params = array(
    'code' => $_GET['code'],
    'redirect_uri' => $ok_redirect_uri,
    'grant_type' => 'authorization_code',
    'client_id' => $ok_client_id,
    'client_secret' => $ok_client_secret
);

$ok_url = 'https://api.ok.ru/oauth/token.do';

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $ok_url); // url, куда будет отправлен запрос
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($ok_params))); // передаём параметры
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$ok_result = curl_exec($curl);
curl_close($curl);

$ok_token = json_decode($ok_result, true);

//$ok_token = json_decode(file_get_contents('https://api.ok.ru/oauth/token.do' . '?' . urldecode(http_build_query($ok_params))), true);

    print_r($ok_token);

}
}