<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 20:33
 */

?>

<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Настройки <?php echo $userItem[0][0]['u_name'];?> <?php echo $userItem[0][0]['u_sname'];?></title>

    <?php include $_SERVER['DOCUMENT_ROOT']."/views/top.html";?>

  </head>

  <body>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/menu.php";?>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";

  ?>


  <div id="main_content" class="container-fluid">
      <div class="row settings">
          <div class="col-md-12 col-sm-12 col-xs-12 top_settings">
              <div class="user_image">
                  <img class="profile-top-rounded" src="<?php echo $userItem[0][0]['ava'];?>">
                  <div class="image-upload">
                      <label data-toggle="modal" data-target="#avaModal">
                          <i class="fa fa-cloud-upload"></i>
                      </label>
                  </div>
              </div>
              <div class="profile-top-name"><h3><?php echo $userItem[0][0]['u_name'].' '.$userItem[0][0]['u_sname'].' '.$userItem[0][0]['u_thname'];?></h3></div><div class="profile-top-description">
                  <h5><?php echo $userItem[0][0]['years'].' ('.$userItem[0][0]['zodiacName'].' '.$userItem[0][0]['zodiacIcon'].')';?><b> · <?php if($userItem[0][0]['gender']==1) {?><i class="fa fa-mars male"></i><?php }else{?><i class="fa fa-venus female"></i><?php }?> ·</b>
                      <?php foreach ($userItem[1] as $userCountry):?>
                          <?php if($userCountry['id']==$userItem[0][0]['country']) echo $userCountry['name']; ?>
                      <?php endforeach; ?>
                  </h5>
                  <p><i class="fa fa-<?php echo $userItem[0][0]['typeUi'];?>" style="color: <?php echo $userItem[0][0]['typeUc'];?>"></i> <?php echo $userItem[0][0]['typeUn'];?></p>
              </div>
              <?php
              require($_SERVER['DOCUMENT_ROOT']."/dev/odnoklassniki_sdk.php");
              if (!OdnoklassnikiSDK::checkCurlSupport()){
                  print "У вас не установлен модуль curl, который требуется для работы с SDK одноклассников.  Инструкция по установке есть, например, <a href=\"http://www.php.net/manual/en/curl.installation.php\">здесь</a>.";
                  return;
              }

              require_once( $_SERVER['DOCUMENT_ROOT'].'/facebook-sdk-v5/src/Facebook/autoload.php');


              require $_SERVER['DOCUMENT_ROOT'].'/twitteroauth/autoload.php';
              use Abraham\TwitterOAuth\TwitterOAuth;

              define('CONSUMER_KEY', 'GxiDCULjXF632A4KrNKPqywKs');
              define('CONSUMER_SECRET', 'b5QS3ayqM7WEAhEixVMeyPc82r78SMqjWCAZ9Gu7AmxTPATJEg');
              define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));
              $special='"';



              //TWITTER ACCOUNT
              if(!isset($_SESSION['tw_step'])&&!isset($_GET['oauth_verifier'])&&empty($_SESSION['twitter_token']['oauth_token']))
              {
                  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

                  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

                  $_SESSION['oauth_token'] = $request_token['oauth_token'];
                  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

                  $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
                  echo '<p class="tw-auth-btn"><a class="btn btn-primary" href="'.$url.'" onclick="window.opener=self;window.close();">Привязать Твиттер</a></p>';
              }
              else
              {
                  echo "<p class='tw-auth-btn'><a class='btn btn-primary' onclick='logOutSocial(".$special."tw".$special.")' href='#'>Отвязать Твиттер</a></p>";
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
                  ?>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                  <script type="text/javascript">
                      function twAuth($token,$tokenSecret)
                      {
                          //alert($token+' Secret:'+$tokenSecret);
                          tok = $token;
                          tok_sec= $tokenSecret;
                          actionText = 'twAuth';

                          $.ajax({
                              url: '/functions/login.php',  //Server script to process data
                              type: 'POST', //Data send type
                              data: ({act: actionText, token: tok, token_secret: tok_sec}), //Data variables
                              dataType: "html", //Type of recived Data
                              success: function(data) {
                                 // $('.tw-auth-btn').remove();
                              },
                              //Options to tell jQuery not to process data or worry about content-type.
                              cache: false
                          });
                      }
                      twAuth('<?php echo $access_token['oauth_token'];?>','<?php echo $access_token['oauth_token_secret'];?>');
                  </script>
              <?php
              }


              //OK ACCOUNT
              $ok_client_id = '1249773056'; // Application ID
              $ok_public_key = 'CBAHAPHLEBABABABA'; // Публичный ключ приложения
              $ok_client_secret = '22B1E47122B106DAEB2B6329'; // Секретный ключ приложения
              $ok_redirect_uri = 'https://linepuls.ru/settings/ok/'; // Ссылка на приложение

              $ok_url = 'https://connect.ok.ru/oauth/authorize';
              $ok_params = array(
                  'client_id'     => $ok_client_id,
                  'scope' =>  'VALUABLE_ACCESS;LONG_ACCESS_TOKEN;PHOTO_CONTENT;GROUP_CONTENT;VIDEO_CONTENT',
                  'response_type' => 'code',
                  'redirect_uri'  => $ok_redirect_uri
              );

              if(empty($_SESSION['ok_token'])) {
                  echo $ok_link = '<p class="ok-auth-btn"><a class="btn btn-primary" href="' . $ok_url . '?' . urldecode(http_build_query($ok_params)) . '" onclick="window.opener=self;window.close();">Привязать Одноклассники</a></p>';
              }
              else
              {
                  if (isset($_SESSION['ok_token']) && isset($ok_public_key)) {
                      $sign = md5("application_key={$ok_public_key}format=jsonmethod=users.getCurrentUser" . md5("{$_SESSION['ok_token']}{$ok_client_secret}"));

                      $params = array(
                          'method'          => 'users.getCurrentUser',
                          'access_token'    => $_SESSION['ok_token'],
                          'application_key' => $ok_public_key,
                          'format'          => 'json',
                          'sig'             => $sign
                      );

                      $userInfo = json_decode(file_get_contents('http://api.odnoklassniki.ru/fb.do' . '?' . urldecode(http_build_query($params))), true);

                      if (isset($userInfo['uid'])) {
                          $result = true;
                      }
                  }

                  echo "<p class='ok-auth-btn'><a class='btn btn-primary' onclick='logOutSocial(".$special."ok".$special.")' href='#'>Отвязать Одноклассники</a> $userInfo[name]</p>";


              }

              if (!empty($_GET['code'])&&empty($_SESSION['ok_token'])&&basename(strtok($_SERVER["REQUEST_URI"],'?'))=='ok') {

                  if(empty($_SESSION['ok_token']))
                  {
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

                      $_SESSION['ok_token'] = $ok_token['access_token'];
                      ?>
                      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                      <script type="text/javascript">function okAuth($token)
                          {
                              Token = $token;
                              actionText = 'okAuth';

                              $.ajax({
                                  url: '/functions/login.php',  //Server script to process data
                                  type: 'POST', //Data send type
                                  data: ({act: actionText, token: Token}), //Data variables
                                  dataType: "html", //Type of recived Data
                                  success: function(data) {
                                      location.reload();
                                  },
                                  //Options to tell jQuery not to process data or worry about content-type.
                                  cache: false
                              });
                          }
                          okAuth('<?php echo $ok_token['access_token'];?>');
                      </script>
                  <?php
                  }
              }

              // FACEBOOK ACCOUNT
              $fb = new Facebook\Facebook([
                  'app_id' => '997999013660895', // Replace {app-id} with your app id
                  'app_secret' => '1cfb02292ecf1530e54c5223eb69364b',
                  'default_graph_version' => 'v2.8',
              ]);

              $helper = $fb->getRedirectLoginHelper();

              if(empty($_GET['code'])&&empty($_SESSION['fb_token'])) {
                  $permissions = ['email,user_posts,public_profile']; // Optional permissions
                  $loginUrl = $helper->getLoginUrl('https://linepuls.ru/settings/fb/', $permissions);

                echo $fb_link = '<p class="fb-auth-btn"><a class="btn btn-primary" href="' . $loginUrl . '" onclick="window.opener=self;window.close();">Привязать Facebook</a></p>';
              }
              elseif(!empty($_SESSION['fb_token']))
              {
                  try {
                      // Returns a `Facebook\FacebookResponse` object
                      $response = $fb->get('/me?fields=id,name', $_SESSION['fb_token']);
                  } catch(Facebook\Exceptions\FacebookResponseException $e) {
                      echo 'Graph returned an error: ' . $e->getMessage();
                      exit;
                  } catch(Facebook\Exceptions\FacebookSDKException $e) {
                      echo 'Facebook SDK returned an error: ' . $e->getMessage();
                      exit;
                  }

                  $userFB = $response->getGraphUser();

                  echo "<p class='fb-auth-btn'><a class='btn btn-primary' onclick='logOutSocial(".$special."fb".$special.")' href='#'>Отвязать Facebook</a>  $userFB[name]</p>";
              }

              if (!empty($_GET['code'])&&empty($_SESSION['fb_token'])&&basename(strtok($_SERVER["REQUEST_URI"],'?'))=='fb') {

                  if(empty($_SESSION['fb_token']))
                  {
                      try {
                          $accessToken = $helper->getAccessToken();
                      } catch(Facebook\Exceptions\FacebookResponseException $e) {
                          // When Graph returns an error
                          echo 'Graph returned an error: ' . $e->getMessage();
                          exit;
                      } catch(Facebook\Exceptions\FacebookSDKException $e) {
                          // When validation fails or other local issues
                          echo 'Facebook SDK returned an error: ' . $e->getMessage();
                          exit;
                      }

                      if (! isset($accessToken)) {
                          if ($helper->getError()) {
                              header('HTTP/1.0 401 Unauthorized');
                              echo "Error: " . $helper->getError() . "\n";
                              echo "Error Code: " . $helper->getErrorCode() . "\n";
                              echo "Error Reason: " . $helper->getErrorReason() . "\n";
                              echo "Error Description: " . $helper->getErrorDescription() . "\n";
                          } else {
                              header('HTTP/1.0 400 Bad Request');
                              echo 'Bad request';
                          }
                          exit;
                      }



                        /*// Logged in
                      echo '<h3>Access Token</h3>';
                      var_dump($accessToken->getValue());

                        // The OAuth 2.0 client handler helps us manage access tokens
                      $oAuth2Client = $fb->getOAuth2Client();

                      // Get the access token metadata from /debug_token
                      $tokenMetadata = $oAuth2Client->debugToken($accessToken);
                      echo '<h3>Metadata</h3>';
                      var_dump($tokenMetadata);

                        // Validation (these will throw FacebookSDKException's when they fail)
                      $tokenMetadata->validateAppId('997999013660895'); // Replace {app-id} with your app id
                        // If you know the user ID this access token belongs to, you can validate it here
                        //$tokenMetadata->validateUserId('123');
                      $tokenMetadata->validateExpiration();

                        if (! $accessToken->isLongLived()) {
                            // Exchanges a short-lived access token for a long-lived one
                            try {
                                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                                exit;
                            }

                            echo '<h3>Long-lived</h3>';
                            var_dump($accessToken->getValue());
                        }




                        // User is logged in with a long-lived access token.
                        // You can redirect them to a members-only page.
                        //header('Location: https://example.com/members.php');*/
                      $_SESSION['fb_token'] = (string) $accessToken;
                      ?>

                      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
                      <script type="text/javascript">function fbAuth($token)
                          {
                              Token = $token;
                              actionText = 'fbAuth';

                              $.ajax({
                                  url: '/functions/login.php',  //Server script to process data
                                  type: 'POST', //Data send type
                                  data: ({act: actionText, token: Token}), //Data variables
                                  dataType: "html", //Type of recived Data
                                  success: function(data) {
                                      location.reload();
                                  },
                                  //Options to tell jQuery not to process data or worry about content-type.
                                  cache: false
                              });
                          }
                          fbAuth('<?php echo $_SESSION['fb_token'];?>');
                      </script>
                  <?php
                  }
              }

              $client_id = '5500858'; // ID приложения
              $client_secret = 'AULvYm9JPGyZ7JmHjFSO'; // Защищённый ключ
              $redirect_uri = 'https://linepuls.ru/settings/'; // Адрес сайта

              $url = 'https://oauth.vk.com/authorize';

              //VK ACCOUNT
              $params = array(
                  'client_id'     => $client_id,
                  'redirect_uri'  => $redirect_uri,
                  'response_type' => 'code',
                  'scope' => 'wall,friends,offline'
              );

              if(empty($_SESSION['vk_token'])) {
                  echo $link = '<p class="vk-auth-btn"><a class="btn btn-primary" href="' . $url . '?' . urldecode(http_build_query($params)) . '" onclick="window.opener=self;window.close();">Привязать ВКонтакте</a></p>';
              }
              else
              {
                  echo "<p class='vk-auth-btn'><a class='btn btn-primary' onclick='logOutSocial(".$special."vk".$special.")' href='#'>Отвязать Вконтакте</a></p>";
              }

              if (!empty($_GET['code'])&&empty($_SESSION['vk_token'])) {

              if(empty($_SESSION['vk_token']))
              {
              $params = array(
              'client_id' => $client_id,
              'client_secret' => $client_secret,
              'v' => '5.53',
              'code' => $_GET['code'],
              'redirect_uri' => $redirect_uri
              );

              $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
              $_SESSION['vk_token'] = $token['access_token'];
              ?>
                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
              <script type="text/javascript">function vkAuth($token)
                  {
                      Token = $token;
                      actionText = 'vkAuth';

                      $.ajax({
                          url: '/functions/login.php',  //Server script to process data
                          type: 'POST', //Data send type
                          data: ({act: actionText, token: Token}), //Data variables
                          dataType: "html", //Type of recived Data
                          success: function(data) {
                              location.reload();
                          },
                          //Options to tell jQuery not to process data or worry about content-type.
                          cache: false
                      });
                  }
                  vkAuth('<?php echo $token['access_token'];?>');
              </script>
              <?php
              }
              }?>

              <div class="profile-top-right save-editions">
                  <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="tooltip4" data-toggle="tooltip" data-placement="bottom" data-original-title="Сохранить" onclick="updSettings()"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
              </div>
          </div>
          <form id="userSettingForm" method="post">
          <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="input-group">
                    <span class="input-group-addon row_editable">Имя:</span>
                    <input type="text" class="form-control" value="<?php echo $userItem[0][0]['u_name'];?>" name="name">
              </div>
              <div class="input-group">
                    <span class="input-group-addon row_editable">Фамилия:</span>
                    <input type="text" class="form-control" value="<?php echo $userItem[0][0]['u_sname'];?>" name="sname">
              </div>
              <div class="input-group">
                    <span class="input-group-addon row_editable">Отчество:</span>
                    <input type="text" class="form-control" value="<?php echo $userItem[0][0]['u_thname'];?>" name="thname">
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Дата рождения:</span>
                  <input type="text" id="birthday" class="form-control" value="<?php echo $userItem[0][0]['birthday'];?>" name="bdate">
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Страна:</span>
                  <select class="selectpicker" data-live-search="true" name="country" data-size="10">
                      <?php foreach ($userItem[1] as $userCountry):?>
                      <option <?php if($userCountry['id']==$userItem[0][0]['country']) echo "selected"; ?> value="<?php echo $userCountry['id'];?>"><?php echo $userCountry['name'];?></option>
                          <?php endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Город/улица/дом:</span>
                  <input type="text" class="form-control" value="<?php echo $userItem[0][0]['town'];?>" name="town">
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Место учебы:</span>
                  <select class="selectpicker" name="study" data-size="10">
                      <option value="0">Не выбрано</option>
                      <?php foreach ($userItem[13] as $userStudy):?>
                          <option <?php if($userStudy['id']==$userItem[0][0]['religion']) echo "selected"; ?> value="<?php echo $userStudy['id'];?>"><?php echo $userStudy['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>

          <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="input-group">
                  <span class="input-group-addon row_editable">Пол:</span>
                  <select class="selectpicker" name="gender" data-size="10">
                      <?php foreach ($userItem[5] as $userGen):?>
                          <option <?php if($userGen['id']==$userItem[0][0]['gender']) echo "selected"; ?> value="<?php echo $userGen['id'];?>"><?php echo $userGen['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Ориентация:</span>
                  <select class="selectpicker" name="orient" data-size="10">
                      <?php foreach ($userItem[4] as $userOr):?>
                          <option <?php if($userOr['id']==$userItem[0][0]['orientation']) echo "selected"; ?> value="<?php echo $userOr['id'];?>"><?php echo $userOr['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Семейное положение:</span>
                  <select class="selectpicker" name="relation" data-size="10">
                      <?php foreach ($userItem[6] as $userRel): if($userRel['rel_gen']==$userItem[0][0]['gender']){?>
                          <option <?php if($userRel['id']==$userItem[0][0]['relationship']) echo "selected"; ?> value="<?php echo $userRel['id'];?>"><?php echo $userRel['name'];?></option>
                      <?php } endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Вредные привычки:</span>
                  <select class="selectpicker" name="habits" data-size="10">
                      <?php foreach ($userItem[3] as $userHab):?>
                          <option <?php if($userHab['id']==$userItem[0][0]['habits']) echo "selected"; ?> value="<?php echo $userHab['id'];?>"><?php echo $userHab['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Предпочтения:</span>
                  <select class="selectpicker" name="prefer" data-size="10">
                      <?php foreach ($userItem[2] as $userPref):?>
                          <option <?php if($userPref['id']==$userItem[0][0]['preferences']) echo "selected"; ?> value="<?php echo $userPref['id'];?>"><?php echo $userPref['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Вероисповедание:</span>
                  <select class="selectpicker" data-live-search="true" name="religion" data-size="10">
                      <option value="0">Не выбрано</option>
                      <?php foreach ($userItem[12] as $userReligion):?>
                          <option <?php if($userReligion['id']==$userItem[0][0]['religion']) echo "selected"; ?> value="<?php echo $userReligion['id'];?>"><?php echo $userReligion['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
              <div class="input-group">
                  <span class="input-group-addon row_editable">Место работы:</span>
                  <select class="selectpicker" name="work" data-size="10">
                      <option value="0">Не выбрано</option>
                      <?php foreach ($userItem[14] as $userWork):?>
                          <option <?php if($userWork['id']==$userItem[0][0]['religion']) echo "selected"; ?> value="<?php echo $userWork['id'];?>"><?php echo $userWork['name'];?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                  <b>О себе:</b>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Кто я?:</span>
                      <select class="selectpicker" data-live-search="true" name="type" data-size="10">
                          <option value="0">Не выбрано</option>
                          <?php foreach ($userItem[15] as $userType):?>
                              <option <?php if($userType['id']==$userItem[0][0]['id_type']) echo "selected"; ?> value="<?php echo $userType['id'];?>"><?php echo $userType['typeName'];?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Ищу:</span>
                      <select class="selectpicker" name="search" data-size="10">
                          <option value="0">Не выбрано</option>
                          <?php foreach ($userItem[7] as $userSearch):?>
                              <option <?php if($userSearch['id']==$userItem[0][0]['search']) echo "selected"; ?> value="<?php echo $userSearch['id'];?>"><?php echo $userSearch['name'];?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Любимый жанр музыки:</span>
                      <select class="selectpicker" data-live-search="true" name="music_genre" data-size="10">
                          <option value="0">Не выбрано</option>
                          <?php foreach ($userItem[8] as $userMusic):?>
                              <option <?php if($userMusic['id']==$userItem[0][0]['music_genre']) echo "selected"; ?> value="<?php echo $userMusic['id'];?>"><?php echo $userMusic['name'];?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Любимый исполнитель:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['artist'];?>" name="comp">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Любимый жанр фильма:</span>
                      <select class="selectpicker" data-live-search="true" name="film_genre" data-size="10">
                          <option value="0">Не выбрано</option>
                          <?php foreach ($userItem[10] as $userFilm):?>
                              <option <?php if($userFilm['id']==$userItem[0][0]['film_genre']) echo "selected"; ?> value="<?php echo $userFilm['id'];?>"><?php echo $userFilm['name'];?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Любимый актер:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['actor'];?>" name="actor">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Любимый жанр игр:</span>
                      <select class="selectpicker" data-live-search="true" name="game_genre" data-size="10">
                          <option value="0">Не выбрано</option>
                          <?php foreach ($userItem[9] as $userGame):?>
                              <option <?php if($userGame['id']==$userItem[0][0]['game_genre']) echo "selected"; ?> value="<?php echo $userGame['id'];?>"><?php echo $userGame['name'];?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Любимая игра:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['game'];?>" name="game">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Соционический тип:</span>
                      <select class="selectpicker" data-live-search="true" name="soc_type" data-size="10">
                          <option value="0">Не выбрано</option>
                          <?php foreach ($userItem[11] as $userSoc):?>
                              <option <?php if($userSoc['id']==$userItem[0][0]['soc_type']) echo "selected"; ?> value="<?php echo $userSoc['id'];?>"><?php echo $userSoc['name'];?></option>
                          <?php endforeach; ?>
                      </select>
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Интересы:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['interests'];?>" name="interests">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">О себе:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['about'];?>" name="about">
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                  <b>Контакты:</b>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Email:</span>
                      <input type="text" class="form-control" value="<?php  echo $userItem[0][0]['email_cont'];?>" name="email">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Мобильный:</span>
                      <input type="text" class="form-control" value="<?php if($userItem[0][0]['mobile_cont']!=0){echo $userItem[0][0]['mobile_cont'];}?>" name="mobile">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">VK:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['vk'];?>" name="vk">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Twitter:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['tw'];?>" name="twitter">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Instagram:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['inst'];?>" name="instagram">
                  </div>
                  <div class="input-group">
                      <span class="input-group-addon row_editable">Facebook:</span>
                      <input type="text" class="form-control" value="<?php echo $userItem[0][0]['fb'];?>" name="facebook">
                  </div>
              </div>
              <input type="hidden" value="saveEdition" name="action">
              </form>
</div>
      <!-- Modal -->
      <div class="modal fade" id="avaModal" role="dialog" tabindex='-1'>
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Загрузить аватар</h4>
                  </div>
                  <div class="modal-body">
                      <form enctype="multipart/form-data" id="userAvaForm" method="post">
                          <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                Добавить изображение <input type="file" name="fileAva" required onchange="readURL(this)">
                                            </span>
                                        </span>
                              <input type="text" class="form-control" readonly id="filename">
                                         <span class="input-group-btn">
                                             <button class="btn btn-secondary btn-info" type="button" onclick="uploadAva()">Отправить</button>
                                         </span>
                          </div>
                          <input type="hidden" id="x" name="x">
                          <input type="hidden" id="y" name="y">
                          <input type="hidden" id="w" name="w">
                          <input type="hidden" id="h" name="h">
                          <input type="hidden" id="h_src" name="h_src">
                          <input type="hidden" id="w_src" name="w_src">
                          <input type="hidden" value="saveAva" name="action">
                      </form>
                      <progress id="imgDraftUpl" class="avaProgress"></progress>
                      <div id="imageContainter" class="img-responsive imageContainterAva"></div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                  </div>
              </div>
          </div>
      </div>
</div>

    <footer class="footer">
      <div class="container-fluid">
        <p class="text-muted">LinePuls &copy; 2015-<?php echo date("Y") ?></p>
      </div>
    </footer>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/bottom.html";?>

</body>
</html>