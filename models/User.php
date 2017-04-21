<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */

class User
{
    /*
     * Returns single news item with specified id.
     * @param integer $id
     */
    public static function getUserById($id)
    {
        //$id = (string)$id;
        //$id="'".$id."'";

        if(!$id)
        {
            $id=$_SESSION['login'];
        }
       // echo '<br>'.$id;

        function calculate_age($birthday)
        {
            $birthday_timestamp = strtotime($birthday);
            $age = date('Y') - date('Y', $birthday_timestamp);
            if (date('md', $birthday_timestamp) > date('md')) {
                $age--;
            }
            return $age;
        }

        function getLang($lang)
        {
            // Подключаемся к БД.
            $db = Db::getConnection();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $userCountry = $db->query('SELECT country_code FROM countries WHERE id='.$lang.' LIMIT 1');
            if ($userCountry->rowCount() > 0)
            {
                while ($userCou = $userCountry->fetch(PDO::FETCH_ASSOC)) {
                    return strtolower($userCou['country_code']);
                }
            }
        }

        function addhttp($url) {
            if(strlen($url)>12) {
                if (preg_match("#https?://#", $url) === 0) {
                    $url = 'http://' . $url;
                }
            }
            return $url;
        }

        function zodiac ( $birthdate,$lang )
        {
            // Подключаемся к БД.
            $db = Db::getConnection();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $zodiac = "";
            $zodiacArr= array();

            list ( $year, $month, $day ) = explode ( "-", $birthdate );

            if     ( ( $month == 3 && $day > 20 ) || ( $month == 4 && $day < 20 ) ) { $zodiac = 1; }
            elseif ( ( $month == 4 && $day > 19 ) || ( $month == 5 && $day < 21 ) ) { $zodiac = 2; }
            elseif ( ( $month == 5 && $day > 20 ) || ( $month == 6 && $day < 21 ) ) { $zodiac = 3; }
            elseif ( ( $month == 6 && $day > 20 ) || ( $month == 7 && $day < 23 ) ) { $zodiac = 4; }
            elseif ( ( $month == 7 && $day > 22 ) || ( $month == 8 && $day < 23 ) ) { $zodiac = 5; }
            elseif ( ( $month == 8 && $day > 22 ) || ( $month == 9 && $day < 23 ) ) { $zodiac = 6; }
            elseif ( ( $month == 9 && $day > 22 ) || ( $month == 10 && $day < 23 ) ) { $zodiac = 7; }
            elseif ( ( $month == 10 && $day > 22 ) || ( $month == 11 && $day < 22 ) ) { $zodiac = 8; }
            elseif ( ( $month == 11 && $day > 21 ) || ( $month == 12 && $day < 22 ) ) { $zodiac = 9; }
            elseif ( ( $month == 12 && $day > 21 ) || ( $month == 1 && $day < 20 ) ) { $zodiac = 10; }
            elseif ( ( $month == 1 && $day > 19 ) || ( $month == 2 && $day < 19 ) ) { $zodiac = 11; }
            elseif ( ( $month == 2 && $day > 18 ) || ( $month == 3 && $day < 21 ) ) { $zodiac = 12; }

            $userZod = $db->query('SELECT * FROM zodiac WHERE id='.$zodiac);
            if ($userZod->rowCount() > 0) {
                while ($userTyp = $userZod->fetch(PDO::FETCH_ASSOC)) {
                            if(!empty($userTyp[getLang($lang).'_name']))
                            {
                                $zodiacArr['zodName'] = $userTyp[getLang($lang).'_name'];
                            }
                            else
                            {
                                $zodiacArr['zodName'] = $userTyp['name'];
                            }
                            $zodiacArr['zodIcon'] = $userTyp['symbol'];
                }
            }

            return $zodiacArr;
        }

        if($id)
        {
            $id_u = (int)$_SESSION['uid'];
            $id = (string)$id;

            // Подключаемся к БД.
            $db = Db::getConnection();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {
                // Запрос к БД.

                $result = $db->prepare("SELECT * FROM users AS u, users_info AS uInf, user_gender AS uGen,countries as uCou,relationship AS uRel, orientation AS uOr, preferences AS uPref, habits AS uHab
                                    WHERE u.login LIKE :id AND u.id_user=uInf.id_user AND uInf.id_gender=uGen.id AND uCou.id=uInf.id_country AND uRel.id=uInf.id_relationship AND uOr.id=uInf.id_orientation
                                    AND uPref.id=uInf.id_pref AND uHab.id=uInf.id_hab LIMIT 1");
                $result->bindParam(':id', $id, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT, 12);
                $result->execute();

                $userItem = $result->fetch();

                if (isset($userItem['login'])) {

                    $search=0; $music=0; $game=0; $film=0; $soc=0; $relig=0; $work=0; $study=0;
                    $usersWorkArr = array();
                    $usersStudyArr = array();


                    $userSearch = $db->query('SELECT * FROM user_search');
                    if ($userSearch->rowCount() > 0) {
                        while ($userSear = $userSearch->fetch(PDO::FETCH_ASSOC)) {
                            if($userSear['id']==$userItem['id_search'])
                            {
                                $userItem['search'] = $userSear['search_name'];
                            }
                            $search++;
                        }
                    }

                    $userMusic = $db->query('SELECT * FROM user_music_genre');
                    if ($userMusic->rowCount() > 0) {
                        while ($userMus = $userMusic->fetch(PDO::FETCH_ASSOC)) {
                            if($userMus['id']==$userItem['id_music_g'])
                            {
                                $userItem['music'] = $userMus['genre_m_name'];
                            }
                            $music++;
                        }
                    }

                    $userGame = $db->query('SELECT * FROM user_game_genre');
                    if ($userGame->rowCount() > 0) {
                        while ($userGam = $userGame->fetch(PDO::FETCH_ASSOC)) {
                            if($userGam['id']==$userItem['id_game_g'])
                            {
                                $userItem['game'] = $userGam['genre_g_name'];
                            }
                            $game++;
                        }
                    }

                    $userFilm = $db->query('SELECT * FROM user_film_genre');
                    if ($userFilm->rowCount() > 0) {
                        while ($userFil = $userFilm->fetch(PDO::FETCH_ASSOC)) {
                            if($userFil['id']==$userItem['id_film_g'])
                            {
                                $userItem['film'] = $userFil['genre_f_name'];
                            }
                            $film++;
                        }
                    }

                    $userSocType = $db->query('SELECT * FROM user_soc_type');
                    if ($userSocType->rowCount() > 0) {
                        while ($userSoc = $userSocType->fetch(PDO::FETCH_ASSOC)) {
                            if($userSoc['id']==$userItem['id_soc_type'])
                            {
                                $userItem['social'] = $userSoc['type_soc_name'];
                            }
                            $soc++;
                        }
                    }

                    $userReligion = $db->query('SELECT * FROM user_religion');
                    if ($userReligion->rowCount() > 0) {
                        while ($userRelig = $userReligion->fetch(PDO::FETCH_ASSOC)) {
                            if($userRelig['id']==$userItem['id_religion'])
                            {
                                $userItem['religion'] = $userRelig['rel_name'];
                            }
                            $relig++;
                        }
                    }

                    $userStudy = $db->query('SELECT * FROM user_study WHERE id_user='.$id_u);
                    if ($userStudy->rowCount() > 0) {
                        while ($userStud = $userStudy->fetch(PDO::FETCH_ASSOC)) {
                                $userItem['studName'] = $userStud['stud_name'];
                                $userItem['studYearB'] = $userStud['year_b'];
                                $userItem['studYearE'] = $userStud['year_e'];
                        }
                    }

                    $userWork = $db->query('SELECT * FROM user_work WHERE id_user='.$id_u);
                    if ($userWork->rowCount() > 0) {
                        while ($userWor = $userWork->fetch(PDO::FETCH_ASSOC)) {
                                $userItem['workName'] = $userWor['work_name'];
                                $userItem['workYearB'] = $userWor['year_b'];
                                $userItem['workYearE'] = $userWor['year_e'];
                        }
                    }

                    if($userItem['type']==0) {
                        $userType = $db->query('SELECT * FROM user_type WHERE id='.$userItem['id_type']);
                        if ($userType->rowCount() > 0) {
                            while ($userTyp = $userType->fetch(PDO::FETCH_ASSOC)) {
                                    $userItem['typeName'] = $userTyp['name'];
                                    $userItem['typeIcon'] = $userTyp['icon'];
                                    $userItem['typeColor'] = $userTyp['color'];
                            }
                        }
                    }
                    else {
                        $userType = $db->query('SELECT * FROM administration_type WHERE id='.$userItem['id_type']);
                        if ($userType->rowCount() > 0) {
                            while ($userTyp = $userType->fetch(PDO::FETCH_ASSOC)) {
                                    $userItem['typeName'] = $userTyp['name'];
                                    $userItem['typeIcon'] = $userTyp['icon'];
                                    $userItem['typeColor'] = $userTyp['color'];
                            }
                        }
                    }

                    $userFriendStatus = $db->prepare('SELECT user_a FROM user_friendship_req WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?) LIMIT 1');
                    $userFriendStatus->bindParam(1, $_SESSION['uid']);
                    $userFriendStatus->bindParam(2, $_SESSION['uid']);
                    $userFriendStatus->bindParam(3, $userItem['id_user']);
                    $userFriendStatus->bindParam(4, $userItem['id_user']);
                    $userFriendStatus->execute();
                    if ($userFriendStatus->rowCount() > 0) {
                        while ($userSt = $userFriendStatus->fetch(PDO::FETCH_ASSOC)) {
                            if($userSt['user_a']==$_SESSION['uid'])
                            {
                                $userItem['friendStatus'] = 1;
                            }
                            else
                            {
                                $userItem['friendStatus'] = 3;
                            }
                        }
                    }
                    else
                    {
                        $userFriendStatus = $db->prepare('SELECT id FROM user_friendship WHERE (user_a=? OR user_b=?) AND (user_a=? OR user_b=?) LIMIT 1');
                        $userFriendStatus->bindParam(1, $_SESSION['uid']);
                        $userFriendStatus->bindParam(2, $_SESSION['uid']);
                        $userFriendStatus->bindParam(3, $userItem['id_user']);
                        $userFriendStatus->bindParam(4, $userItem['id_user']);
                        $userFriendStatus->execute();
                        if ($userFriendStatus->rowCount() > 0) {
                            while ($userSt = $userFriendStatus->fetch(PDO::FETCH_ASSOC)) {
                                $userItem['friendStatus'] = 2;
                            }
                        }
                        else
                        {
                            $userItem['friendStatus'] = 0;
                        }
                    }

                    $userFavStatus = $db->prepare('SELECT id FROM user_favorite WHERE user_id=? AND fav_id=? LIMIT 1');
                    $userFavStatus->bindParam(1, $_SESSION['uid']);
                    $userFavStatus->bindParam(2, $userItem['id_user']);
                    $userFavStatus->execute();
                    if ($userFavStatus->rowCount() > 0) {
                            $userItem['favUserStatus'] = 1;
                    }
                    else
                    {
                        $userItem['favUserStatus'] = 0;
                    }

                    $userRespectStatus = $db->prepare('SELECT id FROM user_respect WHERE user_id=? AND from_id=? LIMIT 1');
                    $userRespectStatus->bindParam(1, $userItem['id_user']);
                    $userRespectStatus->bindParam(2, $_SESSION['uid']);
                    $userRespectStatus->execute();
                    if ($userRespectStatus->rowCount() > 0) {
                            $userItem['respectUserStatus'] = 1;
                    }
                    else
                    {
                        $userItem['respectUserStatus'] = 0;
                    }

                    $userRate = $db->query('select count(*) from user_respect WHERE user_id='.$userItem['id_user'])->fetchColumn();
                            $userItem['userPPoints']=$userRate;



                    $result_user_info_l = $db->query('SELECT lang FROM users_info WHERE id_user=' . $_SESSION['uid']. ' LIMIT 1');
                    $userInfoLogged = $result_user_info_l->fetch();


                    $zodiacInf=zodiac($userItem['birthday'],$userInfoLogged['lang']);

                    $userItem['bdate'] = calculate_age($userItem['birthday']);
                    $userItem['zodiacName'] = $zodiacInf['zodName'];
                    $userItem['zodiacIcon'] = $zodiacInf['zodIcon'];

                    $userItem['vk_link'] = addhttp($userItem['vk_link']);
                    $userItem['fb_link'] = addhttp($userItem['fb_link']);
                    $userItem['tw_link'] = addhttp($userItem['tw_link']);
                    $userItem['inst_link'] = addhttp($userItem['inst_link']);

                    function ru_date($format, $date = false)
                    {
                        setlocale(LC_ALL, 'ru_RU.utf8');
                        if ($date === false)
                        {
                            $date = time();
                        }
                        if ($format === '')
                        {
                            $format = '%e&nbsp;%bg&nbsp;%Y&nbsp;г.';
                        }

                        $months = explode("|", '|января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря');
                        $format = preg_replace("/\%b/", $months[date('n', $date)], $format);
                        $res = strftime($format, $date);
                        return $res;

                    }

                    $userItem['birthday'] = ru_date('%e %b %Yг.', strtotime($userItem['birthday']));

                    if(!empty($userItem[getLang($userInfoLogged['lang']).'_or_name']))
                    {
                        $userItem['or_name'] = $userItem[getLang($userInfoLogged['lang']).'_or_name'];
                    }


                    $usersFriendsArray = array();
                    $iF = 0;

                    $userFriends = $db->prepare('SELECT * FROM user_friendship WHERE (user_a=? OR user_b=?) LIMIT 48');
                    $userFriends->bindParam(1, $userItem['id_user']);
                    $userFriends->bindParam(2, $userItem['id_user']);
                    $userFriends->execute();

                    if ($userFriends->rowCount() > 0) {
                        while ($userFriend = $userFriends->fetch(PDO::FETCH_ASSOC)) {
                            if($userItem['id_user']==$userFriend['user_b'])
                            {
                                $user=$userFriend['user_a'];
                            }
                            else if($userItem['id_user']==$userFriend['user_a'])
                            {
                                $user=$userFriend['user_b'];
                            }
                            $result_info = $db->query('SELECT name,sname,ava FROM users_info WHERE id_user=' . $user . ' LIMIT 1');
                            $userInfo = $result_info->fetch();

                            $result_infoL = $db->query('SELECT login FROM users WHERE id_user=' . $user . ' LIMIT 1');
                            $userInfoL = $result_infoL->fetch();

                            $usersFriendsArray[$iF]['name'] = $userInfo['name'];
                            $usersFriendsArray[$iF]['sname'] = $userInfo['sname'];
                            $usersFriendsArray[$iF]['ava'] = $userInfo['ava'];
                            $usersFriendsArray[$iF]['login'] = $userInfoL['login'];
                            $iF++;
                        }
                    }


                    // USER Achievements
                    $usersAchievementsArray = array();
                    $iAch = 0;

                    $userAchievements = $db->prepare('SELECT * FROM user_achievements WHERE id_user=? LIMIT 5');
                    $userAchievements->bindParam(1, $userItem['id_user']);
                    $userAchievements->execute();

                    if ($userAchievements->rowCount() > 0) {
                        while ($userAchievement = $userAchievements->fetch(PDO::FETCH_ASSOC)) {
                            $result_info = $db->query('SELECT name,description,icon FROM achievements WHERE id_achievement=' . $userAchievement['id_of_achievement'] . ' LIMIT 1');
                            $AchievementInfo = $result_info->fetch();

                            $usersAchievementsArray[$iAch]['icon'] = $AchievementInfo['icon'];
                            $usersAchievementsArray[$iAch]['name'] = $AchievementInfo['name'];
                            $usersAchievementsArray[$iAch]['description'] = $AchievementInfo['description'];
                            $usersAchievementsArray[$iAch]['date'] = $userAchievement['date_when_get'];
                            $iAch++;
                        }
                    }
                    
                    $usersPost = array();
                    $usersPostImgArr = array();
                    $usersPostLikeArr = array();
                    $usersPostDisLikeArr = array();
                    $usersPostFavArr = array();
                    $usersDraftImages = array();

                    // Запрос к БД.

                    $result = $db->query('SELECT id_post,title,date,short_content,full_content,id_user '
                        . 'FROM user_posts WHERE id_blog =  ' . $userItem['id_user']
                        . ' ORDER BY date DESC '
                        . 'LIMIT 10');

                    $i = 0;
                    $draftI = 0;
                    $likeI = 0;
                    $DislikeI = 0;
                    $favI = 0;
                    $imgI = 0;

                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $result_user_info = $db->query('SELECT name,sname,ava FROM users_info WHERE id_user=' . $row['id_user'] . ' LIMIT 1');
                            $userInfo = $result_user_info->fetch();

                            $result_user_like = $db->query('SELECT id_user FROM user_likes WHERE id_element=' . $row['id_post'] . ' AND type=1');
                            $userLike = $result_user_like->fetch();

                            $result_user_dislike = $db->query('SELECT id_user FROM user_dizlikes WHERE id_element=' . $row['id_post'] . ' AND type=1');
                            $userDisLike = $result_user_dislike->fetch();

                            $result_user_fav = $db->query('SELECT id_user FROM user_fav WHERE id_element=' . $row['id_post'] . ' AND type=1');
                            $userFav = $result_user_fav->fetch();

                            $result_user_info_login = $db->query('SELECT login FROM users WHERE id_user=' . $row['id_user'] . ' LIMIT 1');
                            $userInfoLogin = $result_user_info_login->fetch();

                            $userPostImgQ = $db->query('SELECT * FROM user_posts_images WHERE id_post=' . $row['id_post']);
                            if ($userPostImgQ->rowCount() > 0) {
                                while ($userPostImg = $userPostImgQ->fetch(PDO::FETCH_ASSOC)) {
                                    $usersPostImgArr[$imgI]['link'] = $userPostImg['link'];
                                    $usersPostImgArr[$imgI]['id_post'] = $userPostImg['id_post'];
                                    $imgI++;
                                }
                            }

                            $userPostLikes = $db->query('SELECT * FROM user_likes WHERE id_element=' . $row['id_post']);
                            if ($userPostLikes->rowCount() > 0) {
                                while ($userLikes = $userPostLikes->fetch(PDO::FETCH_ASSOC)) {
                                    $result_like_info = $db->query('SELECT name,sname,ava FROM users_info WHERE id_user=' . $userLikes['id_user'] . ' LIMIT 1');
                                    $userInfoLike = $result_like_info->fetch();

                                    $result_like_infoU = $db->query('SELECT login FROM users WHERE id_user=' . $userLikes['id_user'] . ' LIMIT 1');
                                    $userInfoLikeU = $result_like_infoU->fetch();

                                    $usersPostLikeArr[$likeI]['name'] = $userInfoLike['name'];
                                    $usersPostLikeArr[$likeI]['sname'] = $userInfoLike['sname'];
                                    $usersPostLikeArr[$likeI]['ava'] = $userInfoLike['ava'];
                                    $usersPostLikeArr[$likeI]['login'] = $userInfoLikeU['login'];
                                    $usersPostLikeArr[$likeI]['post'] = $userLikes['id_element'];
                                    $likeI++;
                                }
                            }

                            $userPostDisLikes = $db->query('SELECT * FROM user_dizlikes WHERE id_element=' . $row['id_post']);
                            if ($userPostDisLikes->rowCount() > 0) {
                                while ($userDisLikes = $userPostDisLikes->fetch(PDO::FETCH_ASSOC)) {
                                    $result_dislike_info = $db->query('SELECT name,sname,ava FROM users_info WHERE id_user=' . $userDisLikes['id_user'] . ' LIMIT 1');
                                    $userInfoDisLike = $result_dislike_info->fetch();

                                    $result_dislike_infoU = $db->query('SELECT login FROM users WHERE id_user=' . $userDisLikes['id_user'] . ' LIMIT 1');
                                    $userInfoDisLikeU = $result_dislike_infoU->fetch();

                                    $usersPostDisLikeArr[$DislikeI]['name'] = $userInfoDisLike['name'];
                                    $usersPostDisLikeArr[$DislikeI]['sname'] = $userInfoDisLike['sname'];
                                    $usersPostDisLikeArr[$DislikeI]['ava'] = $userInfoDisLike['ava'];
                                    $usersPostDisLikeArr[$DislikeI]['login'] = $userInfoDisLikeU['login'];
                                    $usersPostDisLikeArr[$DislikeI]['post'] = $userDisLikes['id_element'];
                                    $DislikeI++;
                                }
                            }

                            $userPostFav = $db->query('SELECT * FROM user_fav WHERE id_element=' . $row['id_post']);
                            if ($userPostFav->rowCount() > 0) {
                                while ($userFavs = $userPostFav->fetch(PDO::FETCH_ASSOC)) {
                                    $result_fav_info = $db->query('SELECT name,sname,ava FROM users_info WHERE id_user=' . $userFavs['id_user'] . ' LIMIT 1');
                                    $userInfoFav = $result_fav_info->fetch();

                                    $result_fav_infoU = $db->query('SELECT login FROM users WHERE id_user=' . $userFavs['id_user'] . ' LIMIT 1');
                                    $userInfoFavU = $result_fav_infoU->fetch();

                                    $usersPostFavArr[$favI]['name'] = $userInfoFav['name'];
                                    $usersPostFavArr[$favI]['sname'] = $userInfoFav['sname'];
                                    $usersPostFavArr[$favI]['ava'] = $userInfoFav['ava'];
                                    $usersPostFavArr[$favI]['login'] = $userInfoFavU['login'];
                                    $usersPostFavArr[$favI]['post'] = $userFavs['id_element'];
                                    $favI++;
                                }
                            }

                            $usersPost[$i]['id_post'] = $row['id_post'];
                            $usersPost[$i]['title'] = $row['title'];
                            $usersPost[$i]['date'] = $row['date'];
                            $usersPost[$i]['short_content'] = filter_var(strip_tags($row['short_content']), FILTER_SANITIZE_STRING);
                            $usersPost[$i]['full_content'] = filter_var(strip_tags($row['full_content']), FILTER_SANITIZE_STRING);
                            $usersPost[$i]['u_name'] = $userInfo['name'];
                            $usersPost[$i]['u_sname'] = $userInfo['sname'];
                            $usersPost[$i]['ava'] = $userInfo['ava'];
                            $usersPost[$i]['login'] = $userInfoLogin['login'];
                            $usersPost[$i]['fav'] = $userFav['id_user'];
                            $usersPost[$i]['like'] = $userLike['id_user'];
                            $usersPost[$i]['dislike'] = $userDisLike['id_user'];
                            $usersPost[$i]['col_fav'] = $result_user_fav->rowCount();
                            $usersPost[$i]['col_like'] = $result_user_like->rowCount();
                            $usersPost[$i]['col_dislike'] = $result_user_dislike->rowCount();
                            $i++;
                        }

                    }

                    $result = $db->query('SELECT * FROM user_draft WHERE id_user=' . $id_u);

                    if ($result->rowCount() > 0) {
                        while ($row_drft = $result->fetch(PDO::FETCH_ASSOC)) {
                                $usersDraftImages[$draftI]['draft_id'] = $row_drft['id_draft'];
                                $usersDraftImages[$draftI]['id_user_draft'] = $row_drft['id_touser'];
                                $usersDraftImages[$draftI]['draft_link'] = $row_drft['img_link_prev'];
                            $draftI++;
                        }

                    }

                    return array($userItem, $usersPost, $usersPostImgArr, $usersDraftImages, $usersPostLikeArr, $usersPostFavArr,$usersFriendsArray,$usersPostDisLikeArr,$usersAchievementsArray);
                }
                else
                {
                    require_once(ROOT.'/views/user/user_not_exist.php');
                    exit;
                }
            }
            catch (PDOexception $e) {

                echo "Error is ".$e->getmessage();

            }
        }

    }

    /*
     * Returns an array of news items.
     */
    public static function getUsersList()
    {
        // Подключаемся к БД.
        $db = Db::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{


            $usersList = array();

            // Запрос к БД.

            $result = $db->query('SELECT id_post,title,date,short_content,full_content,id_user '
                . 'FROM user_posts '
                . 'ORDER BY date DESC '
                . 'LIMIT 10');

            $i = 0;
            if ($result->rowCount() > 0) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $result_user_info = $db->query('SELECT * FROM users_info WHERE id_user=' . $row['id_user']);

                    $userInfo = $result_user_info->fetch();

                    $usersList[$i]['id_post'] = $row['id_post'];
                    $usersList[$i]['title'] = $row['title'];
                    $usersList[$i]['date'] = $row['date'];
                    $usersList[$i]['short_content'] = $row['short_content'];
                    $usersList[$i]['full_content'] = $row['full_content'];
                    $usersList[$i]['u_name'] = $userInfo['name'];
                    $usersList[$i]['u_sname'] = $userInfo['sname'];
                    $i++;
                }

                return $usersList;
            }
        }
        catch (PDOexception $e) {

            echo "Error is ".$e->getmessage();

        }
    }

    public static function getUserSettings()
    {
        function calculate_age($birthday)
        {
            $birthday_timestamp = strtotime($birthday);
            $age = date('Y') - date('Y', $birthday_timestamp);
            if (date('md', $birthday_timestamp) > date('md')) {
                $age--;
            }
            return $age;
        }


        function addhttp($url) {
            if (preg_match("#https?://#", $url) === 0) {
                $url = 'http://'.$url;
            }
            return $url;
        }

        function zodiac ( $birthdate,$lang )
        {
            // Подключаемся к БД.
            $db = Db::getConnection();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $zodiac = "";
            $zodiacArr= array();

            list ( $year, $month, $day ) = explode ( "-", $birthdate );

            if     ( ( $month == 3 && $day > 20 ) || ( $month == 4 && $day < 20 ) ) { $zodiac = 1; }
            elseif ( ( $month == 4 && $day > 19 ) || ( $month == 5 && $day < 21 ) ) { $zodiac = 2; }
            elseif ( ( $month == 5 && $day > 20 ) || ( $month == 6 && $day < 21 ) ) { $zodiac = 3; }
            elseif ( ( $month == 6 && $day > 20 ) || ( $month == 7 && $day < 23 ) ) { $zodiac = 4; }
            elseif ( ( $month == 7 && $day > 22 ) || ( $month == 8 && $day < 23 ) ) { $zodiac = 5; }
            elseif ( ( $month == 8 && $day > 22 ) || ( $month == 9 && $day < 23 ) ) { $zodiac = 6; }
            elseif ( ( $month == 9 && $day > 22 ) || ( $month == 10 && $day < 23 ) ) { $zodiac = 7; }
            elseif ( ( $month == 10 && $day > 22 ) || ( $month == 11 && $day < 22 ) ) { $zodiac = 8; }
            elseif ( ( $month == 11 && $day > 21 ) || ( $month == 12 && $day < 22 ) ) { $zodiac = 9; }
            elseif ( ( $month == 12 && $day > 21 ) || ( $month == 1 && $day < 20 ) ) { $zodiac = 10; }
            elseif ( ( $month == 1 && $day > 19 ) || ( $month == 2 && $day < 19 ) ) { $zodiac = 11; }
            elseif ( ( $month == 2 && $day > 18 ) || ( $month == 3 && $day < 21 ) ) { $zodiac = 12; }

            $userZod = $db->query('SELECT * FROM zodiac WHERE id='.$zodiac);
            if ($userZod->rowCount() > 0) {
                while ($userTyp = $userZod->fetch(PDO::FETCH_ASSOC)) {
                    $userCountry = $db->query('SELECT country_code FROM countries WHERE id='.$lang);
                    if ($userCountry->rowCount() > 0) {
                        while ($userCou = $userCountry->fetch(PDO::FETCH_ASSOC)) {
                            if(!empty($userTyp[strtolower($userCou['country_code']).'_name']))
                            {
                                $zodiacArr['zodName'] = $userTyp[strtolower($userCou['country_code']).'_name'];
                            }
                            else
                            {
                                $zodiacArr['zodName'] = $userTyp['name'];
                            }
                            $zodiacArr['zodIcon'] = $userTyp['symbol'];
                        }
                    }
                }
            }

            return $zodiacArr;
        }

        $id = (int)$_SESSION['uid'];

        // Подключаемся к БД.
        $db = Db::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            // Запрос к БД.



            $i=0; $rel=0; $gen=0; $pref=0; $hab=0; $orient=0; $coun=0; $search=0; $music=0; $game=0; $film=0; $soc=0; $relig=0; $work=0; $study=0; $type=0;

            $userItem = array();
            $userRelationshipArr = array();
            $usersGenderArr = array();
            $usersOrientArr = array();
            $usersHabitsArr = array();
            $usersPreferArr = array();
            $usersCountryArr = array();
            $usersSearchArr = array();
            $usersMusicArr = array();
            $usersGameArr = array();
            $usersFilmArr = array();
            $usersSocTypeArr = array();
            $usersReligionArr = array();
            $usersWorkArr = array();
            $usersStudyArr = array();
            $usersTypeArr = array();

            $result_user_info_l = $db->query('SELECT lang FROM users_info WHERE id_user=' . $_SESSION['uid']. ' LIMIT 1');
            $userInfoLogged = $result_user_info_l->fetch();

            $result = $db->query('SELECT * FROM users_info WHERE id_user='.$id.' LIMIT 1');
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $userItem[$i]['u_name'] = $row['name'];
                        $userItem[$i]['u_sname'] = $row['sname'];
                        $userItem[$i]['u_thname'] = $row['thname'];
                        $userItem[$i]['ava'] = $row['ava'];
                        $userItem[$i]['birthday'] = $row['birthday'];
                        $userItem[$i]['gender'] = $row['id_gender'];
                        $userItem[$i]['preferences'] = $row['id_pref'];
                        $userItem[$i]['habits'] = $row['id_hab'];
                        $userItem[$i]['orientation'] = $row['id_orientation'];
                        $userItem[$i]['relationship'] = $row['id_relationship'];
                        $userItem[$i]['country'] = $row['id_country'];
                        $userItem[$i]['search'] = $row['id_search'];
                        $userItem[$i]['music_genre'] = $row['id_music_g'];
                        $userItem[$i]['artist'] = $row['fav_comp'];
                        $userItem[$i]['film_genre'] = $row['id_film_g'];
                        $userItem[$i]['actor'] = $row['fav_act'];
                        $userItem[$i]['game_genre'] = $row['id_game_g'];
                        $userItem[$i]['game'] = $row['fav_game'];
                        $userItem[$i]['soc_type'] = $row['id_soc_type'];
                        $userItem[$i]['interests'] = $row['interests'];
                        $userItem[$i]['about'] = $row['about'];
                        $userItem[$i]['email_cont'] = $row['email_cont'];
                        $userItem[$i]['mobile_cont'] = $row['mobile_cont'];
                        $userItem[$i]['vk'] = $row['vk_link'];
                        $userItem[$i]['fb'] = $row['fb_link'];
                        $userItem[$i]['tw'] = $row['tw_link'];
                        $userItem[$i]['inst'] = $row['inst_link'];
                        $userItem[$i]['town'] = $row['live_adr'];
                        $userItem[$i]['religion'] = $row['id_religion'];
                        $userItem[$i]['id_type'] = $row['id_type'];
                        $userItem[$i]['type'] = $row['type'];

                        $userItem[$i]['years'] = calculate_age($row['birthday']);
                        $zodiacInf = zodiac($row['birthday'],$userInfoLogged['lang']);
                        $userItem[$i]['zodiacName'] = $zodiacInf['zodName'];
                        $userItem[$i]['zodiacIcon'] = $zodiacInf['zodIcon'];
                        $i++;
                    }
                }

            $userRelation = $db->query('SELECT * FROM relationship');
            if ($userRelation->rowCount() > 0) {
                while ($userRel = $userRelation->fetch(PDO::FETCH_ASSOC)) {

                    $userRelationshipArr[$rel]['id'] = $userRel['id'];
                    $userRelationshipArr[$rel]['name'] = $userRel['rel_name'];
                    $userRelationshipArr[$rel]['rel_gen'] = $userRel['gen'];
                    $rel++;
                }
            }

                        $userGender = $db->query('SELECT * FROM user_gender');
            if ($userGender->rowCount() > 0) {
                while ($userGen = $userGender->fetch(PDO::FETCH_ASSOC)) {

                    $usersGenderArr[$gen]['id'] = $userGen['id'];
                    $usersGenderArr[$gen]['name'] = $userGen['gender_name'];
                    $gen++;
                }
            }

                        $userOrient = $db->query('SELECT * FROM orientation');
            if ($userOrient->rowCount() > 0) {
                while ($userOr = $userOrient->fetch(PDO::FETCH_ASSOC)) {

                    $usersOrientArr[$orient]['id'] = $userOr['id'];
                    $usersOrientArr[$orient]['name'] = $userOr['or_name'];
                    $orient++;
                }
            }

                        $userHabits = $db->query('SELECT * FROM habits');
            if ($userHabits->rowCount() > 0) {
                while ($userHab = $userHabits->fetch(PDO::FETCH_ASSOC)) {

                    $usersHabitsArr[$hab]['id'] = $userHab['id'];
                    $usersHabitsArr[$hab]['name'] = $userHab['hab_name'];
                    $hab++;
                }
            }

                        $userPrefer = $db->query('SELECT * FROM preferences');
            if ($userPrefer->rowCount() > 0) {
                while ($userPref = $userPrefer->fetch(PDO::FETCH_ASSOC)) {

                    $usersPreferArr[$pref]['id'] = $userPref['id'];
                    $usersPreferArr[$pref]['name'] = $userPref['pre_name'];
                    $pref++;
                }
            }

                        $userCountry = $db->query('SELECT * FROM countries');
            if ($userCountry->rowCount() > 0) {
                while ($userCou = $userCountry->fetch(PDO::FETCH_ASSOC)) {

                    $usersCountryArr[$coun]['id'] = $userCou['id'];
                    $usersCountryArr[$coun]['name'] = $userCou['country_name'];
                    $coun++;
                }
            }

            //
            $userSearch = $db->query('SELECT * FROM user_search');
            if ($userSearch->rowCount() > 0) {
                while ($userSear = $userSearch->fetch(PDO::FETCH_ASSOC)) {

                    $usersSearchArr[$search]['id'] = $userSear['id'];
                    $usersSearchArr[$search]['name'] = $userSear['search_name'];
                    $search++;
                }
            }

            $userMusic = $db->query('SELECT * FROM user_music_genre');
            if ($userMusic->rowCount() > 0) {
                while ($userMus = $userMusic->fetch(PDO::FETCH_ASSOC)) {

                    $usersMusicArr[$music]['id'] = $userMus['id'];
                    $usersMusicArr[$music]['name'] = $userMus['genre_m_name'];
                    $music++;
                }
            }

            $userGame = $db->query('SELECT * FROM user_game_genre');
            if ($userGame->rowCount() > 0) {
                while ($userGam = $userGame->fetch(PDO::FETCH_ASSOC)) {

                    $usersGameArr[$game]['id'] = $userGam['id'];
                    $usersGameArr[$game]['name'] = $userGam['genre_g_name'];
                    $game++;
                }
            }

            $userFilm = $db->query('SELECT * FROM user_film_genre');
            if ($userFilm->rowCount() > 0) {
                while ($userFil = $userFilm->fetch(PDO::FETCH_ASSOC)) {

                    $usersFilmArr[$film]['id'] = $userFil['id'];
                    $usersFilmArr[$film]['name'] = $userFil['genre_f_name'];
                    $film++;
                }
            }

            $userSocType = $db->query('SELECT * FROM user_soc_type');
            if ($userSocType->rowCount() > 0) {
                while ($userSoc = $userSocType->fetch(PDO::FETCH_ASSOC)) {

                    $usersSocTypeArr[$soc]['id'] = $userSoc['id'];
                    $usersSocTypeArr[$soc]['name'] = $userSoc['type_soc_name'];
                    $soc++;
                }
            }

            $userReligion = $db->query('SELECT * FROM user_religion');
            if ($userReligion->rowCount() > 0) {
                while ($userRelig = $userReligion->fetch(PDO::FETCH_ASSOC)) {

                    $usersReligionArr[$relig]['id'] = $userRelig['id'];
                    $usersReligionArr[$relig]['name'] = $userRelig['rel_name'];
                    $relig++;
                }
            }

            $userStudy = $db->query('SELECT * FROM user_study WHERE id_user='.$id);
            if ($userStudy->rowCount() > 0) {
                while ($userStud = $userStudy->fetch(PDO::FETCH_ASSOC)) {

                    $usersStudyArr[$study]['id'] = $userStud['id'];
                    $usersStudyArr[$study]['name'] = $userStud['work_name'];
                    $usersStudyArr[$study]['yearB'] = $userStud['year_b'];
                    $usersStudyArr[$study]['yearE'] = $userStud['year_e'];
                    $study++;
                }
            }

            $userWork = $db->query('SELECT * FROM user_work WHERE id_user='.$id);
            if ($userWork->rowCount() > 0) {
                while ($userWor = $userWork->fetch(PDO::FETCH_ASSOC)) {

                    $usersWorkArr[$work]['id'] = $userWor['id'];
                    $usersWorkArr[$work]['name'] = $userWor['rel_name'];
                    $usersWorkArr[$work]['yearB'] = $userWor['year_b'];
                    $usersWorkArr[$work]['yearE'] = $userWor['year_e'];
                    $work++;
                }
            }

            if($userItem[0]['type']==0) {
                $userType = $db->query('SELECT * FROM user_type');
                if ($userType->rowCount() > 0) {
                    while ($userTyp = $userType->fetch(PDO::FETCH_ASSOC)) {
                        if($userItem[0]['id_type']==$userTyp['id'])
                        {
                            $userItem[0]['typeUn'] = $userTyp['name'];
                            $userItem[0]['typeUi'] = $userTyp['icon'];
                            $userItem[0]['typeUc'] = $userTyp['color'];
                        }
                        $usersTypeArr[$type]['id'] = $userTyp['id'];
                        $usersTypeArr[$type]['typeName'] = $userTyp['name'];
                        $usersTypeArr[$type]['typeIcon'] = $userTyp['icon'];
                        $usersTypeArr[$type]['typeColor'] = $userTyp['color'];
                        $type++;
                    }
                }
            }
            else {
                $userType = $db->query('SELECT * FROM administration_type');
                if ($userType->rowCount() > 0) {
                    while ($userTyp = $userType->fetch(PDO::FETCH_ASSOC)) {
                        if($userItem[0]['id_type']==$userTyp['id'])
                        {
                            $userItem[0]['typeUn'] = $userTyp['name'];
                            $userItem[0]['typeUi'] = $userTyp['icon'];
                            $userItem[0]['typeUc'] = $userTyp['color'];
                        }
                        $usersTypeArr[$type]['id'] = $userTyp['id'];
                        $usersTypeArr[$type]['typeName'] = $userTyp['name'];
                        $usersTypeArr[$type]['typeIcon'] = $userTyp['icon'];
                        $usersTypeArr[$type]['typeColor'] = $userTyp['color'];
                        $type++;
                    }
                }
            }

            return array($userItem, $usersCountryArr, $usersPreferArr, $usersHabitsArr, $usersOrientArr, $usersGenderArr, $userRelationshipArr, $usersSearchArr, $usersMusicArr, $usersGameArr, $usersFilmArr, $usersSocTypeArr, $usersReligionArr, $usersStudyArr, $usersWorkArr, $usersTypeArr);
        }
        catch (PDOexception $e) {

            echo "Error is ".$e->getmessage();

        }
    }
}