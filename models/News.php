<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */
require $_SERVER['DOCUMENT_ROOT'].'/twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
require( $_SERVER['DOCUMENT_ROOT'].'/facebook-sdk-v5/src/Facebook/autoload.php');
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;

class News
{
    /*
     * Returns single news item with specified id.
     * @param integer $id
     */
    public static function getNewsItemById($id)
    {
        // Подключаемся к БД.
        $db = Db::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            //Получаем настройки ленты пользователя.
            $result_user_info = $db->query('SELECT * FROM user_newsfeed_settings WHERE id_user=' . $_SESSION['uid']. ' LIMIT 1');
            $userFeedSettings = $result_user_info->fetch();
        } catch (PDOexception $e) {
            echo "Error is " . $e->getmessage();
        }

        //Settings Feed
        $userFeedSettingsArr = array();

        if(isset($userFeedSettings['vk_post_count']))
        {
            $VKPostCountForPage=$userFeedSettings['vk_post_count'];
            $userFeedSettingsArr['vk_post_count']=$VKPostCountForPage;
        }
        else
        {
            $VKPostCountForPage=6;
            $userFeedSettingsArr['vk_post_count']=$VKPostCountForPage;
        }

        if(isset($userFeedSettings['vk_resolution']))
        {
            $VKPostResolution=$userFeedSettings['vk_resolution'];
            $userFeedSettingsArr['vk_resolution']=$VKPostResolution;
        }
        else
        {
            $VKPostResolution=807;
            $userFeedSettingsArr['vk_resolution']=$VKPostResolution;
        }

        if(isset($userFeedSettings['columsW']))
        {
            $VKPostColumnWidth=$userFeedSettings['columsW'];
            $userFeedSettingsArr['columsW']=$VKPostColumnWidth;
        }
        else
        {
            $VKPostColumnWidth=4;
            $userFeedSettingsArr['columsW']=$VKPostColumnWidth;
        }

        if(isset($userFeedSettings['filter_vk']))
        {
            $VKPostFilterVK=$userFeedSettings['filter_vk'];
            $userFeedSettingsArr['filter_vk']=$VKPostFilterVK;
        }
        else
        {
            $VKPostFilterVK=0;
            $userFeedSettingsArr['filter_vk']=$VKPostFilterVK;
        }

        if(isset($userFeedSettings['filter_tw']))
        {
            $VKPostFilterTW=$userFeedSettings['filter_tw'];
            $userFeedSettingsArr['filter_tw']=$VKPostFilterTW;
        }
        else
        {
            $VKPostFilterTW=0;
            $userFeedSettingsArr['filter_tw']=$VKPostFilterTW;
        }

        if(isset($userFeedSettings['filter_fb']))
        {
            $VKPostFilterFB=$userFeedSettings['filter_fb'];
            $userFeedSettingsArr['filter_fb']=$VKPostFilterFB;
        }
        else
        {
            $VKPostFilterFB=0;
            $userFeedSettingsArr['filter_fb']=$VKPostFilterFB;
        }

        //Twitter Feed
        $result_twitter = array();
        //FB Feed
        $result_fb = array();

        if($VKPostFilterVK==1)
        {
            //VK Feed
            if (!empty($_SESSION['vk_token'])) {
                $params = array(
                    'filters' => 'post',
                    'count' => $VKPostCountForPage,
                    'access_token' => $_SESSION['vk_token'],
                    'start_from' => $id,
                    'v' => '5.53'
                );

                $userVKPosts = json_decode(file_get_contents('https://api.vk.com/method/newsfeed.get' . '?' . urldecode(http_build_query($params))), true);


                if (isset($userVKPosts['response']['items'])) {
                    $userVKPosts = $userVKPosts['response'];
                    $result = true;
                    $userVKPosts['result_resp'] = $result;

                    return array($userVKPosts, $result_twitter, $userFeedSettingsArr);
                } else {
                    $result = false;
                    $userVKPosts['result_resp'] = $result;

                    return array($userVKPosts, $result_twitter, $userFeedSettingsArr);
                }
            }
        }
        else
        {
            $result = false;
            $userVKPosts=array();
            $userVKPosts['result_resp']=$result;
            return array($userVKPosts,$result_twitter,$userFeedSettingsArr);
        }

    }



    /*
     * Returns an array of news items.
     */
    /**
     * @return array
     */
    public static function getNewsList()
    {

        /**
         *
         * Sending Facebook Request API
         *
         * @param array $parameters  List of API Method parameters
         * @param string $method  Name of API Method
         * @return object
         */
        function sendReqFacebook($method  = null,array $parameters = [])
        {
            $fbApp = new Facebook\FacebookApp('997999013660895', '1cfb02292ecf1530e54c5223eb69364b');

            $fb = new Facebook\Facebook([
                'app_id' => '997999013660895', // Replace {app-id} with your app id
                'app_secret' => '1cfb02292ecf1530e54c5223eb69364b',
                'default_graph_version' => 'v2.8',
            ]);

            if (!empty($parameters))
            {
                $request = new FacebookRequest(
                    $fbApp,
                    $_SESSION['fb_token'],
                    'GET',
                    $method,
                    $parameters
                );
            }
            else
            {
                $request = new FacebookRequest(
                    $fbApp,
                    $_SESSION['fb_token'],
                    'GET',
                    $method
                );
            }

            // Send the request to Graph
            try {
                $response = $fb->getClient()->sendRequest($request);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            if($method=='/me/feed')
            {
                return  $response->getGraphEdge();
            }
            else
            {
                return $response->getGraphNode();
            }

        }


        // Подключаемся к БД.
        $db = Db::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            //Получаем настройки ленты пользователя.
            $result_user_info = $db->query('SELECT * FROM user_newsfeed_settings WHERE id_user=' . $_SESSION['uid']. ' LIMIT 1');
            $userFeedSettings = $result_user_info->fetch();
        } catch (PDOexception $e) {
            echo "Error is " . $e->getmessage();
        }

        //Settings Feed
        $userFeedSettingsArr = array();

        if(isset($userFeedSettings['vk_post_count']))
        {
            $VKPostCountForPage=$userFeedSettings['vk_post_count'];
            $userFeedSettingsArr['vk_post_count']=$VKPostCountForPage;
        }
        else
        {
            $VKPostCountForPage=6;
            $userFeedSettingsArr['vk_post_count']=$VKPostCountForPage;
        }

        if(isset($userFeedSettings['vk_resolution']))
        {
            $VKPostResolution=$userFeedSettings['vk_resolution'];
            $userFeedSettingsArr['vk_resolution']=$VKPostResolution;
        }
        else
        {
            $VKPostResolution=807;
            $userFeedSettingsArr['vk_resolution']=$VKPostResolution;
        }

        if(isset($userFeedSettings['columsW']))
        {
            $VKPostColumnWidth=$userFeedSettings['columsW'];
            $userFeedSettingsArr['columsW']=$VKPostColumnWidth;
        }
        else
        {
            $VKPostColumnWidth=4;
            $userFeedSettingsArr['columsW']=$VKPostColumnWidth;
        }

        if(isset($userFeedSettings['filter_vk']))
        {
            $VKPostFilterVK=$userFeedSettings['filter_vk'];
            $userFeedSettingsArr['filter_vk']=$VKPostFilterVK;
        }
        else
        {
            $VKPostFilterVK=0;
            $userFeedSettingsArr['filter_vk']=$VKPostFilterVK;
        }

        if(isset($userFeedSettings['filter_tw']))
        {
            $VKPostFilterTW=$userFeedSettings['filter_tw'];
            $userFeedSettingsArr['filter_tw']=$VKPostFilterTW;
        }
        else
        {
            $VKPostFilterTW=0;
            $userFeedSettingsArr['filter_tw']=$VKPostFilterTW;
        }

        if(isset($userFeedSettings['filter_fb']))
        {
            $VKPostFilterFB=$userFeedSettings['filter_fb'];
            $userFeedSettingsArr['filter_fb']=$VKPostFilterFB;
        }
        else
        {
            $VKPostFilterFB=0;
            $userFeedSettingsArr['filter_fb']=$VKPostFilterFB;
        }



        if($VKPostFilterTW==1)
        {
            //Twitter Feed
            $result_twitter = array();
            if(isset($_SESSION['twitter_token'])&&!empty($_SESSION['twitter_token'])) {
                $access_token = $_SESSION['twitter_token'];

                $connection = new TwitterOAuth('GxiDCULjXF632A4KrNKPqywKs', 'b5QS3ayqM7WEAhEixVMeyPc82r78SMqjWCAZ9Gu7AmxTPATJEg', $access_token['oauth_token'], $access_token['oauth_token_secret']);

                //$user = $connection->get("account/verify_credentials");

                $user_feed = $connection->get("statuses/home_timeline", ["count" => "5"]);

                //print_r($user_feed);
                $result_twitter = json_decode(json_encode($user_feed), true);
            }
        }
        else
        {
            $result_twitter = array();
        }

        if($VKPostFilterFB==1)
        {
            $feedFB = sendReqFacebook('/me/feed',['fields=message,created_time,id','limit=10']);

            for ($i = 0; $i < count($feedFB); $i++) {
                $fb_user = strtok($feedFB[$i]['id'], '_');


                $fb = new Facebook\Facebook([
                    'app_id' => '997999013660895',
                    'app_secret' => '1cfb02292ecf1530e54c5223eb69364b',
                    'default_graph_version' => 'v2.8',
                ]);

// Since all the requests will be sent on behalf of the same user,
// we'll set the default fallback access token here.
                $fb->setDefaultAccessToken($_SESSION['fb_token']);

                /**
                 * Generate some requests and then send them in a batch request.
                 */



// Get the name of the logged in user
                $requestUserName = $fb->request('GET', $fb_user.'?fields=name&limit=1');

// Get user likes
                $requestUserPosts = $fb->request('GET', $feedFB[$i]['id'].'?fields=full_picture&limit=1');

// Get user events
                $requestUserPic = $fb->request('GET', $fb_user."/picture?fields=url&type=normal&redirect=false&limit=1");



                $batch = [
                    'user-profile' => $requestUserName,
                    'user-posts' => $requestUserPosts,
                    'user-pic' => $requestUserPic
                ];


                try {
                    $responses = $fb->sendBatchRequest($batch);
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                    // When Graph returns an error
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                    // When validation fails or other local issues
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }


                $feedFB[$i]['user_info'] = $responses['user-profile']->getDecodedBody();
                $feedFB[$i]['user_post'] = $responses['user-posts']->getDecodedBody();
                $feedFB[$i]['user_pic'] = $responses['user-pic']->getDecodedBody();

                /*$feedFB[$i]['user_info'] = sendReqFacebook($fb_user.'?fields=name');
                $feedFB[$i]['post_info'] = sendReqFacebook($feedFB[$i]['id'].'?fields=picture');
                $feedFB[$i]['user_pic'] = sendReqFacebook($fb_user.'/picture',['redirect'=>'false','type'=>'normal']);*/
            }


        }
        else
        {
            $result_fb = array();
        }

        if($VKPostFilterVK==1)
        {
            //VK Feed
            if (!empty($_SESSION['vk_token'])) {
                $params = array(
                    'filters' => 'post',
                    'count' => $VKPostCountForPage,
                    'access_token' => $_SESSION['vk_token'],
                    'start_from' => '0',
                    'v' => '5.62'
                );

                $userVKPosts = json_decode(file_get_contents('https://api.vk.com/method/newsfeed.get' . '?' . urldecode(http_build_query($params))), true);

                if (isset($userVKPosts['response']['items'])) {
                    $userVKPosts = $userVKPosts['response'];
                    $result = true;
                    $userVKPosts['result_resp']=$result;

                    return array($userVKPosts,$result_twitter,$userFeedSettingsArr,$feedFB);
                }
                else
                {
                    $result = false;
                    $userVKPosts['result_resp']=$result;

                    return array($userVKPosts,$result_twitter,$userFeedSettingsArr);
                }
            }
        }
        else
        {
            $result = false;
            $userVKPosts=array();
            $userVKPosts['result_resp']=$result;
            return array($userVKPosts,$result_twitter,$userFeedSettingsArr);
        }
    }
}