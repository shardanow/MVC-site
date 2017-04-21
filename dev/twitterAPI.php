


<?php
/**
 * Created by PhpStorm.
 * User: Denis Shardanov
 * Date: 25.08.2016
 * Time: 12:03:PM
 */
session_start();

require '../twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'GxiDCULjXF632A4KrNKPqywKs');
define('CONSUMER_SECRET', 'b5QS3ayqM7WEAhEixVMeyPc82r78SMqjWCAZ9Gu7AmxTPATJEg');
define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));



if(!isset($_SESSION['tw_step'])&&!isset($_GET['oauth_verifier']))
{
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

    print_r($request_token);

    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
    echo '<a class="btn btn-primary" href="'.$url.'">Next step: authorize on twitter.com</a>';
}

if(isset($_REQUEST['oauth_token']))
{
    $request_token = [];
    $request_token['oauth_token'] = $_SESSION['oauth_token'];
    $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

    if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
        exit(" Tokens are not the same!");
    }

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);

    $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);

    $_SESSION['twitter_token'] = $access_token;
    $_SESSION['tw_step']=2;
}

if(isset($_SESSION['tw_step'])&&!empty($_SESSION['tw_step']))
{
    print_r('Step: '.$_SESSION['tw_step'].' Token: '.$_SESSION['oauth_token'].' Token Secret: '.$_SESSION['oauth_token_secret']);
    if($_SESSION['tw_step']==2)
    {
        $access_token = $_SESSION['twitter_token'];

        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

        $user = $connection->get("account/verify_credentials");

        $user_feed = $connection->get("statuses/home_timeline", ["count" => "5"]);
        echo '<br><pre>';
        print_r($user);
        echo '<br>';
        print_r($user_feed);
        echo '</pre>';
    }
}

?>
