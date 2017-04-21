<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 13.02.2017
 * Time: 15:31
 */

session_start();
require_once( $_SERVER['DOCUMENT_ROOT'].'/facebook-sdk-v5/src/Facebook/autoload.php');



$fb = new Facebook\Facebook([
    'app_id' => '997999013660895', // Replace {app-id} with your app id
    'app_secret' => '1cfb02292ecf1530e54c5223eb69364b',
    'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://linepuls.ru/settings/', $permissions);

echo $fb_link = '<p class="vk-auth-btn"><a class="btn btn-primary" href="' . $loginUrl . '">Привязать Facebook</a></p>';