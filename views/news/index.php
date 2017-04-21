<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 20:33
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/functions/user.php';
user_active();



?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>LinePuls</title>

    <?php include $_SERVER['DOCUMENT_ROOT']."/views/top.html";?>

</head>

<body>


<?php include $_SERVER['DOCUMENT_ROOT']."/views/menu.php";?>

<div id="news_right_panel_full">
<div class="news_right_panel_min"><i class="fa fa-search"></i></div>
<div class="news_right_panel">
    <h5 class="news_right_panel_type">Сообщества</h5>

    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" data-src="holder.js/64x64" alt="64x64"
                     src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNGZhMzY5MzVhZiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE0ZmEzNjkzNWFmIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                     data-holder-rendered="true" style="width: 64px; height: 64px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">Название</h4>
            Сообщение из ленты (статус паблика).
        </div>
    </div>
    <h5 class="news_right_panel_type">Люди</h5>

    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" data-src="holder.js/64x64" alt="64x64"
                     src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNGZhMzY5MzVhZiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE0ZmEzNjkzNWFmIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                     data-holder-rendered="true" style="width: 64px; height: 64px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">Имя Фамилия</h4>
            Статус.
        </div>
    </div>
</div>
<button type="button" class="btn btn-default btn-xs  button-show-right">
    <span class="glyphicon glyphicon-chevron-right nav-open1"></span>
    <span class="glyphicon glyphicon-chevron-left nav-close1"></span>
</button>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";
$userVKPostsSettings=$userSocialPosts[2];
?>

<!-- Begin page content -->

<div id="main_content" class="container-fluid news">
<div id="top-news-line">
    <div class="top-news-hide-button"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>
    <div class="top-news-line-button-block">
        <div onclick="feedPostCounter('<?php if($userVKPostsSettings['vk_post_count']>4&&$userVKPostsSettings['vk_post_count']<=10){echo $userVKPostsSettings['vk_post_count'];}else{echo $userVKPostsSettings['vk_post_count'];} ?>', 'minus')" class="top-news-filter-button minus-post-button"><i class="fa fa-minus-square" aria-hidden="true"></i></div>
        <div class="top-news-filter-text top-news-filter-button-counter"><?php echo $userVKPostsSettings['vk_post_count']; ?></div>
        <div onclick="feedPostCounter('<?php if($userVKPostsSettings['vk_post_count']>=4&&$userVKPostsSettings['vk_post_count']<10){echo $userVKPostsSettings['vk_post_count'];}else{echo $userVKPostsSettings['vk_post_count'];} ?>', 'plus')" class="top-news-filter-button plus-post-button"><i class="fa fa-plus-square" aria-hidden="true"></i></div>
        <div data-toggle='tooltip' data-placement='bottom' data-original-title='Кол-во прогружаемых постов' class="top-news-filter-text top-news-line-button-block-count-text">Кол-во</div>
    </div>
    <div class="top-news-line-button-block top-news-hide-block">
        <div onclick="feedSetter('setGrid','4')" data-toggle='tooltip' data-placement='bottom' data-original-title='3х1' class="top-news-filter-button grid-button-w <?php if($userVKPostsSettings['columsW']==4) {echo "top-news-filter-button-act";}?>"><i class="fa fa-th-large grid-button-i-w <?php if($userVKPostsSettings['columsW']==4) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div onclick="feedSetter('setGrid','3')" data-toggle='tooltip' data-placement='bottom' data-original-title='4х1' class="top-news-filter-button grid-button-w <?php if($userVKPostsSettings['columsW']==3) {echo "top-news-filter-button-act top-news-filter-button-act-first-ungroup";}?>"><i class="fa fa-th grid-button-i-w <?php if($userVKPostsSettings['columsW']==3) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div data-toggle='tooltip' data-placement='bottom' data-original-title='Вид сетки постов' class="top-news-filter-text top-news-line-button-block-grid-text">Вид</div>
    </div>
    <div class="top-news-line-button-block">
        <div onclick="feedSetter('setVKPostQuality','1280')" data-toggle='tooltip' data-placement='bottom' data-original-title='Высокое' class="top-news-filter-button resolution-vk-button <?php if($userVKPostsSettings['vk_resolution']==1280) {echo "top-news-filter-button-act";}?>"><i class="fa fa-star resolution-vk-i-button <?php if($userVKPostsSettings['vk_resolution']==1280) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div onclick="feedSetter('setVKPostQuality','807')" data-toggle='tooltip' data-placement='bottom' data-original-title='Среднее' class="top-news-filter-button resolution-vk-button <?php if($userVKPostsSettings['vk_resolution']==807) {echo "top-news-filter-button-act";}?>"><i class="fa fa-star-half-o fa-star resolution-vk-i-button <?php if($userVKPostsSettings['vk_resolution']==807) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div onclick="feedSetter('setVKPostQuality','604')" data-toggle='tooltip' data-placement='bottom' data-original-title='Низкое' class="top-news-filter-button resolution-vk-button <?php if($userVKPostsSettings['vk_resolution']==604) {echo "top-news-filter-button-act top-news-filter-button-act-first-ungroup";}?>"><i class="fa fa-star-o fa-star resolution-vk-i-button <?php if($userVKPostsSettings['vk_resolution']==604) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div data-toggle='tooltip' data-placement='bottom' data-original-title='Кач-во изображений' class="top-news-filter-text top-news-line-button-block-qt-text">Кач-во</div>
    </div>
    <div class="top-news-line-button-block">
        <div onclick="feedSetter('setSocialFilter','<?php if($userVKPostsSettings['filter_tw']==1) {echo "0";} else {echo "1";}?>','tw')" data-toggle='tooltip' data-placement='bottom' data-original-title='Twitter' class="top-news-filter-button social-button-tw <?php if($userVKPostsSettings['filter_tw']==1) {echo "top-news-filter-button-act";}?>"><i class="fa fa-twitter social-button-i-tw <?php if($userVKPostsSettings['filter_tw']==1) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div onclick="feedSetter('setSocialFilter','<?php if($userVKPostsSettings['filter_vk']==1) {echo "0";} else {echo "1";}?>','vk')" data-toggle='tooltip' data-placement='bottom' data-original-title='VK' class="top-news-filter-button social-button-vk <?php if($userVKPostsSettings['filter_vk']==1) {echo "top-news-filter-button-act";} else if($userVKPostsSettings['filter_tw']==1&&$userVKPostsSettings['filter_vk']==1){echo "top-news-filter-button-act top-news-filter-button-act-first";}?>"><i class="fa fa-vk social-button-i-vk <?php if($userVKPostsSettings['filter_vk']==1) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>
        <div onclick="feedSetter('setSocialFilter','<?php if($userVKPostsSettings['filter_fb']==1) {echo "0";} else {echo "1";}?>','fb')" data-toggle='tooltip' data-placement='bottom' data-original-title='Facebook' class="top-news-filter-button social-button-fb <?php if($userVKPostsSettings['filter_fb']==1) {echo "top-news-filter-button-act";} else if($userVKPostsSettings['filter_fb']==1&&$userVKPostsSettings['filter_fb']==1){echo "top-news-filter-button-act top-news-filter-button-act-first";}?>"><i class="fa fa-facebook-official social-button-i-fb <?php if($userVKPostsSettings['filter_fb']==1) {echo "top-news-filter-button-i-act";}?>" aria-hidden="true"></i></div>

        <div class="top-news-filter-text">Фильтры</div>
    </div>
</div>
    <div class="modal_news"></div>
    <input type="hidden" id="nextVKPage" value="<?php echo $userSocialPosts[0]['next_from'];?>">

    <div id="posts" class="row">
        <?php

        if(isset($_SESSION['fb_token']))
        {
            $result_fb = $userSocialPosts[3];

          /*  var_dump($result_fb[1]);
            var_dump($result_fb[1]['user_post']['picture']);
            var_dump($result_fb[1]['user_pic']['data']['url']);
            var_dump($result_fb[1]['user_info']['name']);
           // print_r($result_fb[2]['post_info']['picture']);*/
           // print_r($result_fb[0]['user_pic']['url']);


            //print_r($userSocialPosts[3]);
            /*print_r($result_fb[0]);
            print_r(strtok($result_fb[0]['id'], '_'));
            print_r(substr($result_fb[0]['id'], strpos($result_fb[0]['id'], "_") + 1));
            print_r($result_fb[0]['message']);
            print_r($result_fb[0]['id']);
            print_r($result_fb[0]['created_time']->format('Y-m-d H:i:s'));*/



            for ($i = 0; $i < count($result_fb); $i++) {
                $fb_user=strtok($result_fb[$i]['id'], '_');
                if(!empty($text)||!empty($result_fb[$i]['user_post']['full_picture'])) {
                    echo "<div id='{$i}' class='item col-md-6 col-lg-" . $userVKPostsSettings['columsW'] . " col-sm-6 col-xs-12 col-xl-" . $userVKPostsSettings['columsW'] . "'><div class='well facebook-block'>";
                    echo '<i class="fa fa-facebook-official post-icon-social post-icon-fb" aria-hidden="true"></i>';
                    echo "<a class='facebook-block-link' href='https://fb.com/{$fb_user}' target='_blank'><img data-toggle='tooltip' data-placement='bottom' data-original-title='{$result_fb[$i]['user_info']['name']}' class='thumbnail img-responsive facebook-block-img' src='{$result_fb[$i]['user_pic']['data']['url']}'/></a>";
                    $text = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2" target="_blank">$3</a>', $result_fb[$i]['message']);
                    if (!empty($result_fb[$i]['user_post']['full_picture'])) {
                        echo "<div class='post-image-block'><img class='img-responsive' src='{$result_fb[$i]['user_post']['full_picture']}'/></div>";
                    } else {
                        echo "<div class='facebook-block-ava'></div>";
                    }
                    if (!empty($text)) {
                        echo "<div class='info twitter-block-info '><p style='word-wrap: break-word;'>{$text}</p></div>";
                    }
                    echo "</div></div>";
                }
            }
        }

        if(isset($_SESSION['twitter_token'])&&!empty($_SESSION['twitter_token']['oauth_token']))
        {
            $result_twitter = $userSocialPosts[1];

            for ($i = 0; $i < count($result_twitter); $i++) {
                $twUImg = $result_twitter[$i]['user']['profile_image_url_https'];
                echo "<div id='{$i}' class='item col-md-6 col-lg-".$userVKPostsSettings['columsW']." col-sm-6 col-xs-12 col-xl-".$userVKPostsSettings['columsW']."'><div class='well twitter-block'>";
                echo '<i class="fa fa-twitter post-icon-social post-icon-tw" aria-hidden="true"></i>';
                echo "<a href='https://twitter.com/{$result_twitter[$i]['user']['screen_name']}?lang=ru' target='_blank'><img data-toggle='tooltip' data-placement='bottom' data-original-title='{$result_twitter[$i]['user']['name']}' class='thumbnail img-responsive twitter-block-img' src='{$twUImg}'/></a>";
                $text = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2" target="_blank">$3</a>', $result_twitter[$i]['text']);
                echo "<div class='info twitter-block-info '><p style='word-wrap: break-word;'>{$text}</p></div>";
                echo "</div></div>";
            }
        }

        if ($userSocialPosts[0]['result_resp']) {
            //print_r($userVKPosts['next_from']);
            //print_r($userVKPosts['profiles']);
            //print_r($userVKPosts['items']);
            //print_r($userVKPosts['groups']);
            $userVKPostsResp=$userSocialPosts[0];
            $userVKPosts=$userSocialPosts[0]['items'];
            $userVKPostsGroups=$userVKPostsResp['groups'];
            $userVKPostsProfiles=$userVKPostsResp['profiles'];

            for ($i = 0; $i < count($userVKPosts); $i++) {
                if (isset($userVKPosts[$i]['copy_history'])) {
                    $postID=$userSocialPosts[0]['next_from'].'_num_'.$i;

                    $counterHiddenContent=0;
                    $counterHiddenImgCurr=0;
                    $counterHiddenImgTotal=0; //Резервируем переменную под общее кол-во изображений прикрепленных к посту
                    echo "<div id='{$postID}' class='item col-md-6 col-lg-".$userVKPostsSettings['columsW']." col-sm-6 col-xs-12 col-xl-".$userVKPostsSettings['columsW']."'><div class='well'>";
                    echo '<i class="fa fa-vk post-icon-social" aria-hidden="true"></i>';

                    for ($iFP = 0; $iFP < count($userVKPosts); $iFP++) {
                        if ('-' . $userVKPostsProfiles[$iFP]['id'] == $userVKPosts[$i]['source_id']) {
                            $postOwnerName = $userVKPostsProfiles[$iFP]['first_name'] . ' ' . $userVKPostsProfiles[$iFP]['last_name'];
                            $postOwnerId = $userVKPostsProfiles[$iFP]['screen_name'];
                        }
                    }

                    for ($iFG = 0; $iFG < count($userVKPosts); $iFG++) {
                        if ('-' . $userVKPostsGroups[$iFG]['id'] == $userVKPosts[$i]['source_id']) {
                            $postOwnerName = $userVKPostsGroups[$iFG]['name'];
                            $postOwnerId = $userVKPostsGroups[$iFG]['screen_name'];
                        }
                    }

                    echo "<h4><a href='https://new.vk.com/{$postOwnerId}' target='_blank'>{$postOwnerName}</a></h4>";

                    for ($iAttH = 0; $iAttH < count($userVKPosts[$i]['copy_history']); $iAttH++) {

                        for ($iAtt = 0; $iAtt < count($userVKPosts[$i]['copy_history'][$iAttH]['attachments']); $iAtt++)
                        {
                            //$data = getimagesize($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_130']);
                            $width = $data[0];
                            $height = $data[1];

                            //if (isset($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']) && $width >= 50 && $height >= 50)
                            if (isset($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']))
                            {
                                $counterHiddenImgTotal+=1; //Считаем общее кол-во изображений прикрепленных к посту
                            }
                        }

                        //$counterHiddenContentAttachments = count($userVKPosts[$i]['copy_history'][$iAttH]['attachments']);
                        for ($iAtt = 0; $iAtt < count($userVKPosts[$i]['copy_history'][$iAttH]['attachments']); $iAtt++) {

                            //$data = getimagesize($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_130']);
                            $width = $data[0];
                            $height = $data[1];
                            $photoURL = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_604'];

                            //if (isset($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']) && $width >= 50 && $height >= 50)
                            if (isset($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']))
                            {
                                $counterHiddenImgCurr+=1; //Считаем текущий номер изображения прикрепленных к посту

                                if ($userVKPostsSettings['vk_resolution']==1280)
                                {
                                    if($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_1280'])
                                    {
                                        $fullPhoto = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_1280'];
                                    }
                                    else
                                    {
                                        $fullPhoto = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_807'];
                                    }
                                }
                                else if ($userVKPostsSettings['vk_resolution']==807)
                                {
                                    if($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_807'])
                                    {
                                        $fullPhoto = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_807'];
                                    }
                                    else
                                    {
                                        $fullPhoto = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_604'];
                                    }
                                }
                                else if ($userVKPostsSettings['vk_resolution']==604)
                                {
                                    if($userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_604'])
                                    {
                                        $fullPhoto = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_604'];
                                    }
                                    else
                                    {
                                        $fullPhoto = $userVKPosts[$i]['copy_history'][$iAttH]['attachments'][$iAtt]['photo']['photo_130'];
                                    }
                                }

                                $fullPhoto = preg_replace("/^http:/i", "https:", $fullPhoto);
                                $photoURL = preg_replace("/^http:/i", "https:", $photoURL);


                                if ($counterHiddenImgCurr > 1)
                                {
                                    if($counterHiddenImgCurr <= 2)
                                    {
                                        echo "<div id='post-image-block-vk' class='post-image-block'><a href='https://www.google.com/searchbyimage?site=search&sa=X&image_url=$photoURL' target='_blank'><i data-toggle='tooltip' data-placement='left' data-original-title='Искать похожее' class='fa fa-search post-icon-search' aria-hidden='true'></i></a><a href='{$fullPhoto}' data-gallery><img class='thumbnail img-responsive nextPostImg' src='{$photoURL}'/></a></div>";
                                    }
                                    else if($counterHiddenImgCurr > 2)
                                    {
                                        if($counterHiddenImgCurr == 3)
                                        {
                                            $counterHiddenContent+=1;
                                            $currHiddID=$postID.'_numHidd_'.$counterHiddenContent;
                                            echo "<input class='hide' id='hd-{$currHiddID}' type='checkbox' onclick='IzoImages(1);'><label for='hd-{$currHiddID}'>Развернуть</label><div class='hidden-content-post'>";
                                        }
                                        echo "<div id='post-image-block-vk' class='post-image-block'><a href='https://www.google.com/searchbyimage?site=search&sa=X&image_url=$photoURL' target='_blank'><i data-toggle='tooltip' data-placement='left' data-original-title='Искать похожее' class='fa fa-search post-icon-search' aria-hidden='true'></i></a><a href='{$fullPhoto}' data-gallery><img class='thumbnail img-responsive nextPostImg' src='{$photoURL}'/></a></div>";
                                    }

                                }
                                else if ($counterHiddenImgCurr == 1)
                                {
                                    echo "<div id='post-image-block-vk' class='post-image-block'><a href='https://www.google.com/searchbyimage?site=search&sa=X&image_url=$photoURL' target='_blank'><i data-toggle='tooltip' data-placement='left' data-original-title='Искать похожее' class='fa fa-search post-icon-search' aria-hidden='true'></i></a><a href='{$fullPhoto}' data-gallery><img class='thumbnail img-responsive' src='{$photoURL}'/></a></div>";
                                }
                                if($counterHiddenImgCurr > 2 && $counterHiddenImgCurr == $counterHiddenImgTotal)
                                {
                                    echo "<input class='hide' id='hd-{$currHiddID}' type='checkbox' onclick='IzoImages(1);' checked><label for='hd-{$currHiddID}'>Свернуть</label>";
                                    echo '</div>';
                                    $counterHiddenImgCurr=0;
                                    $counterHiddenImgTotal=0;
                                }
                            }

                        }

                        if(strlen($userVKPosts[$i]['copy_history'][$iAttH]['text'])>=3)
                        {
                            if(preg_match_all('/\[]*\w+.[a-zA-Z0-9А-Яа-я !,=^&:"№;%*()+_@.-]*./u', $userVKPosts[$i]['copy_history'][$iAttH]['text']))
                            {
                                if(preg_match_all('/(?<=\[)[\w+.-]+/u', $userVKPosts[$i]['copy_history'][$iAttH]['text'], $firstPartL, PREG_PATTERN_ORDER))
                                {
                                    if(preg_match_all('/(?<=\|)[\w\s!,=^&:"№;%*()+_@.-]+/u', $userVKPosts[$i]['copy_history'][$iAttH]['text'], $secondPartL, PREG_PATTERN_ORDER))
                                    {
                                        $firstPart=$firstPartL[0];
                                        $secondPart=$secondPartL[0];

                                    }
                                }
                            }

                            if (preg_match_all('/#[#a-zA-Z_0-9а-яА-Я@.-\x{4e00}-\x{9fa5}\p{Han}+]*/u', $userVKPosts[$i]['copy_history'][$iAttH]['text'], $tags, PREG_PATTERN_ORDER))
                                $matches = $tags[0]; // reduce the multi-dimensional array to the array of full matches only

                            $text = preg_replace('/\[]*\w+.[a-zA-Z0-9А-Яа-я !,=^&:"№;%*()+_@.-]*./u', ' ', $userVKPosts[$i]['copy_history'][$iAttH]['text']);
                            $text = preg_replace('/#[#a-zA-Z_0-9а-яА-Я@.-\x{4e00}-\x{9fa5}\p{Han}+]*/u', '', $text);
                            $text = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2" target="_blank">$3</a>', $text);
                            echo "<div class='info'>";
                            if(strlen($text)>1)
                            {
                                echo "<p style='word-wrap: break-word;'>{$text}";
                                if(count($firstPart)>=1)
                                {
                                    for ($iLink = 0; $iLink < count($firstPart); $iLink++) {
                                        echo "<br><a href='https://vk.com/$firstPart[$iLink]' target='_blank'>$secondPart[$iLink]</a>";
                                    }
                                }
                                echo "</p>";
                            }
                            echo '<i data-toggle="tooltip" data-placement="left" data-original-title="В избранное" class="fa fa-star post-button-fav" aria-hidden="true"></i>';

                            for ($iTag = 0; $iTag < count($matches); $iTag++) {
                                echo"<span class='badge'>$matches[$iTag]</span>";
                            }
                            echo"<span class='badge'>#$postOwnerName</span>";
                            echo "</div>";
                        }
                        else
                        {
                            echo "<div class='info'>";
                            echo '<i data-toggle="tooltip" data-placement="left" data-original-title="В избранное" class="fa fa-star post-button-fav" aria-hidden="true"></i>';
                            echo "<span class='badge'>#$postOwnerName</span></div>";
                        }
                    }
                    echo "</div></div>";
                }


                if (isset($userVKPosts[$i]['attachments'])) {
                    if (isset($userVKPosts[$i]['attachments'][0]['photo']) && isset($userVKPosts[$i]['attachments'][0]['audio']) && isset($userVKPosts[$i]['text'])
                        || isset($userVKPosts[$i]['attachments'][0]['photo']) && isset($userVKPosts[$i]['attachments'][0]['audio'])
                        || isset($userVKPosts[$i]['attachments'][0]['audio']) && isset($userVKPosts[$i]['text'])
                        || isset($userVKPosts[$i]['attachments'][0]['photo']) && isset($userVKPosts[$i]['text'])
                        || isset($userVKPosts[$i]['attachments'][0]['audio'])
                        || isset($userVKPosts[$i]['attachments'][0]['photo'])
                        || isset($userVKPosts[$i]['text']) && !isset($userVKPosts[$i]['attachments'][0]['video'])) {
                        echo "<div id='{$postID}' class='item col-md-6 col-lg-".$userVKPostsSettings['columsW']." col-sm-6 col-xs-12 col-xl-".$userVKPostsSettings['columsW']."'><div class='well'>";
                        echo '<i class="fa fa-vk post-icon-social" aria-hidden="true"></i>';

                        for ($iFP = 0; $iFP < count($userVKPosts); $iFP++) {
                            if ('-' . $userVKPostsProfiles[$iFP]['id'] == $userVKPosts[$i]['source_id']) {
                                $postOwnerName = $userVKPostsProfiles[$iFP]['first_name'] . ' ' . $userVKPostsProfiles[$iFP]['last_name'];
                                $postOwnerId = $userVKPostsProfiles[$iFP]['screen_name'];
                            }
                        }

                        for ($iFG = 0; $iFG < count($userVKPosts); $iFG++) {
                            if ('-' . $userVKPostsGroups[$iFG]['id'] == $userVKPosts[$i]['source_id']) {
                                $postOwnerName = $userVKPostsGroups[$iFG]['name'];
                                $postOwnerId = $userVKPostsGroups[$iFG]['screen_name'];
                            }
                        }


                        echo "<h4><a href='https://new.vk.com/{$postOwnerId}' target='_blank'>{$postOwnerName}</a></h4>";

                        $counterHiddenContentImgNum=0;
                        $counterHiddenContentImg=0; //Общее кол-во изображений прикрепленных к посту
                        if (isset($userVKPosts[$i]['attachments'][0]['photo'])) {

                            for ($iAtt = 0; $iAtt < count($userVKPosts[$i]['attachments']); $iAtt++) {
                                //$data = getimagesize($userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_130']);
                                $width = $data[0];
                                $height = $data[1];
                                //if (isset($userVKPosts[$i]['attachments'][$iAtt]['photo'])&&$width>=50&&$height>=50) {
                                if (isset($userVKPosts[$i]['attachments'][$iAtt]['photo'])) {
                                    $counterHiddenContentImg +=1; //Считаем общее кол-во изображений прикрепленных к посту
                                }
                            }



                            for ($iAtt = 0; $iAtt < count($userVKPosts[$i]['attachments']); $iAtt++) {
                                $counterHiddenContent=0;

                               // $data = getimagesize($userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_130']);
                                $width = $data[0];
                                $height = $data[1];
                                $photoURL = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_604'];

                                //if (isset($userVKPosts[$i]['attachments'][$iAtt]['photo'])&&$width>=50&&$height>=50)
                                if (isset($userVKPosts[$i]['attachments'][$iAtt]['photo']))
                                {
                                    $counterHiddenContentImgNum+=1;

                                    if ($userVKPostsSettings['vk_resolution']==1280)
                                    {
                                        if($userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_1280'])
                                        {
                                            $fullPhoto = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_1280'];
                                        }
                                        else
                                        {
                                            $fullPhoto = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_807'];
                                        }
                                    }
                                    else if ($userVKPostsSettings['vk_resolution']==807)
                                    {
                                        if($userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_807'])
                                        {
                                            $fullPhoto = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_807'];
                                        }
                                        else
                                        {
                                            $fullPhoto = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_604'];
                                        }
                                    }
                                    else if ($userVKPostsSettings['vk_resolution']==604)
                                    {
                                        if($userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_604'])
                                        {
                                            $fullPhoto = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_604'];
                                        }
                                        else
                                        {
                                            $fullPhoto = $userVKPosts[$i]['attachments'][$iAtt]['photo']['photo_130'];
                                        }
                                    }

                                    $fullPhoto = preg_replace("/^http:/i", "https:", $fullPhoto);
                                    $photoURL = preg_replace("/^http:/i", "https:", $photoURL);

                                    if ($counterHiddenContentImgNum > 1)
                                    {
                                        if($counterHiddenContentImgNum <= 2)
                                        {
                                            echo "<div id='post-image-block-vk' class='post-image-block'><a href='https://www.google.com/searchbyimage?site=search&sa=X&image_url=$photoURL' target='_blank'><i data-toggle='tooltip' data-placement='left' data-original-title='Искать похожее' class='fa fa-search post-icon-search' aria-hidden='true'></i></a><a href='{$fullPhoto}' data-gallery><img class='thumbnail img-responsive nextPostImg' src='{$photoURL}'/></a></div>";
                                        }
                                        else if($counterHiddenContentImgNum > 2)
                                        {
                                            if($counterHiddenContentImgNum == 3)
                                            {
                                                $currHiddID=$postID.'_numHiddPost_'.$counterHiddenContentImgNum.mt_rand(1,1000);
                                                echo "<input class='hide' id='hd-{$currHiddID}' type='checkbox' onclick='IzoImages(1);'><label for='hd-{$currHiddID}'>Развернуть</label><div class='hidden-content-post'>";
                                            }
                                            echo "<div id='post-image-block-vk' class='post-image-block'><a href='https://www.google.com/searchbyimage?site=search&sa=X&image_url=$photoURL' target='_blank'><i data-toggle='tooltip' data-placement='left' data-original-title='Искать похожее' class='fa fa-search post-icon-search' aria-hidden='true'></i></a><a href='{$fullPhoto}' data-gallery><img class='thumbnail img-responsive nextPostImg' src='{$photoURL}'/></a></div>";
                                        }
                                    }
                                    else if ($counterHiddenContentImgNum == 1)
                                    {
                                        echo "<div id='post-image-block-vk' class='post-image-block'><a href='https://www.google.com/searchbyimage?site=search&sa=X&image_url=$photoURL' target='_blank'><i data-toggle='tooltip' data-placement='left' data-original-title='Искать похожее' class='fa fa-search post-icon-search' aria-hidden='true'></i></a><a href='{$fullPhoto}' data-gallery><img class='thumbnail img-responsive' src='{$photoURL}'/></a></div>";
                                    }
                                }

                            }

                        }
                        if (isset($userVKPosts[$i]['attachment'][0]['audio']) && strlen($userVKPosts[$i]['attachment'][0]['audio']['url'])>30) {
                            $songName = $userVKPosts[$i]['attachment'][0]['audio']['artist'] . ' - ' . $userVKPosts[$i]['attachment'][0]['audio']['title'];

                            echo "<audio title='{$songName}' controls preload='none'><source src='{$userVKPosts[$i]['attachment'][0]['audio']['url']}' type='audio/mpeg'></audio>";
                            echo "<br>";
                        }



                        for ($iAtt = 0; $iAtt < count($userVKPosts[$i]['attachments']); $iAtt++) {
                            if (isset($userVKPosts[$i]['attachments'][$iAtt]['audio']) && strlen($userVKPosts[$i]['attachments'][$iAtt]['audio']['url'])>30) {
                                $songName = $userVKPosts[$i]['attachments'][$iAtt]['audio']['artist'] . ' - ' . $userVKPosts[$i]['attachments'][$iAtt]['audio']['title'];

                                echo "<audio title='{$songName}' controls preload='none'><source src='{$userVKPosts[$i]['attachments'][$iAtt]['audio']['url']}' type='audio/mpeg'></audio>";
                                echo "<br>";
                            }
                        }
                        if($counterHiddenContentImg > 2 && $counterHiddenContentImgNum == $counterHiddenContentImg)
                        {
                            echo "<input class='hide' id='hd-{$currHiddID}' type='checkbox' onclick='IzoImages(1);' checked><label for='hd-{$currHiddID}'>Свернуть</label>";
                            echo '</div>';
                            $counterHiddenContentImgNum=0;
                            $counterHiddenContentImg=0;
                        }
                        //echo $userVKPosts[$i]['text'];
                        if(strlen($userVKPosts[$i]['text'])>=3)
                        {
                            if(preg_match_all('/\[]*\w+.[a-zA-Z0-9А-Яа-я !,=^&:"№;%*()+_@.-]*./u', $userVKPosts[$i]['text']))
                            {
                                if(preg_match_all('/(?<=\[)[\w+.-]+/u', $userVKPosts[$i]['text'], $firstPartL, PREG_PATTERN_ORDER))
                                {
                                    if(preg_match_all('/(?<=\|)[\w\s!,=^&:"№;%*()+_@.-]+/u', $userVKPosts[$i]['text'], $secondPartL, PREG_PATTERN_ORDER))
                                    {
                                        $firstPart=$firstPartL[0];
                                        $secondPart=$secondPartL[0];

                                    }
                                }
                            }

                            if (preg_match_all('/#[#a-zA-Z_0-9а-яА-Я@.-\x{4e00}-\x{9fa5}\p{Han}+]*/u', $userVKPosts[$i]['text'], $tags, PREG_PATTERN_ORDER))
                                $matches = $tags[0]; // reduce the multi-dimensional array to the array of full matches only

                            $text = preg_replace('/\[]*\w+.[a-zA-Z0-9А-Яа-я !,=^&:"№;%*()+_@.-]*./u', ' ', $userVKPosts[$i]['text']);
                            $text = preg_replace('/#[#a-zA-Z_0-9а-яА-Я@.-\x{4e00}-\x{9fa5}\p{Han}+]*/u', '', $text);
                            $text = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', '$1 <a href="$2" target="_blank">$3</a>', $text);
                            echo "<div class='info'>";

                            if(strlen($text)>1)
                            {
                                echo "<p style='word-wrap: break-word;'>{$text}";
                                if(count($firstPart)>=1)
                                {
                                    for ($iLink = 0; $iLink < count($firstPart); $iLink++) {
                                        echo "<br><a href='https://vk.com/$firstPart[$iLink]' target='_blank'>$secondPart[$iLink]</a>";
                                    }
                                }
                                echo "</p>";
                            }

                            echo '<i data-toggle="tooltip" data-placement="left" data-original-title="В избранное" class="fa fa-star post-button-fav" aria-hidden="true"></i>';

                            for ($iTag = 0; $iTag < count($matches); $iTag++) {
                                echo"<span class='badge'>$matches[$iTag]</span>";
                            }
                            echo"<span class='badge'>#$postOwnerName</span>";
                            echo "</div>";
                        }
                        else
                        {
                            echo "<div class='info'>";
                            echo '<i data-toggle="tooltip" data-placement="left" data-original-title="В избранное" class="fa fa-star post-button-fav" aria-hidden="true"></i>';
                            echo "<span class='badge'>#$postOwnerName</span></div>";
                        }
                        echo "</div></div>";
                    }
                }
                $tags=null;
                $matches=null;
                $firstPartL=null;
                $secondPartL=null;
                $firstPart=null;
                $secondPart=null;
            }
        }
        ?>

    </div>

    <footer class="footer">
        <div class="container-fluid">
            <p class="text-muted">LinePuls &copy; 2015-<?php echo date("Y") ?></p>
        </div>
    </footer>

    <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
        <!-- The modal dialog, which will be used to wrap the lightbox content -->
        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next">
                            Next
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<?php include $_SERVER['DOCUMENT_ROOT']."/views/bottom.html";?>


</body>
</html>