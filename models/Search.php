<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */

class Search
{
    /*
     * Returns single news item with specified id.
     * @param integer $id
     */
    public static function getUserById($id)
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

        function ru2lat($str)
        {
            $tr = array(
                "А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
                "Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i",
                "Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n",
                "О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t",
                "У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch",
                "Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"",
                "Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b",
                "в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo",
                "ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k",
                "л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p",
                "р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f",
                "х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch",
                "ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu",
                "я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",
                ":"=>"", ";"=>"","—"=>"", "–"=>"-"
            );
            return strtr($str,$tr);
        }

        function transliterate($textcyr = null, $textlat = null) {
            $cyr = array(
                'ж',  'ч',  'щ',   'ш',  'ю',  'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
                'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я');
            $lat = array(
                'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q',
                'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q');
            if($textcyr) return str_replace($cyr, $lat, $textcyr);
            else if($textlat) return str_replace($lat, $cyr, $textlat);
            else return null;
        }

        function getUserInfo($result)
        {

            $db = Db::getConnection();

            $i = 0;
            $userItem = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $result_user_info = $db->query('SELECT * FROM users_info WHERE id_user=' . $row['id_user']. ' LIMIT 1');
                $userInfo = $result_user_info->fetch();

                $result_user_info_l = $db->query('SELECT lang FROM users_info WHERE id_user=' . $_SESSION['uid']. ' LIMIT 1');
                $userInfoLogged = $result_user_info_l->fetch();

                $result_user_infoG = $db->query('SELECT gender_name, icon, gender_type FROM user_gender WHERE id=' . $userInfo['id_gender']. ' LIMIT 1');
                $userInfoG = $result_user_infoG->fetch();

                $result_user_infoC = $db->query('SELECT country_name FROM countries WHERE id=' . $userInfo['id_country']. ' LIMIT 1');
                $userInfoC = $result_user_infoC->fetch();

                $result_user_infoT = $db->query('SELECT name, icon, color FROM user_type WHERE id=' . $userInfo['id_type']. ' LIMIT 1');
                $result_user_infoTA = $db->query('SELECT name, icon, color FROM administration_type WHERE id=' . $userInfo['id_type']. ' LIMIT 1');
                if($userInfo['type']==1)
                    $userInfoT = $result_user_infoTA->fetch();
                else
                    $userInfoT = $result_user_infoT->fetch();

                $userItem[$i]['id'] = $row['login'];
                $userItem[$i]['ava'] = $userInfo['ava'];
                $userItem[$i]['u_name'] = $userInfo['name'];
                $userItem[$i]['u_sname'] = $userInfo['sname'];
                $userItem[$i]['u_thname'] = $userInfo['thname'];
                $userItem[$i]['genderIcon'] = $userInfoG['icon'];
                $userItem[$i]['genderColor'] = $userInfoG['gender_type'];
                $userItem[$i]['country'] = $userInfoC['country_name'];
                $userItem[$i]['u_type'] = $userInfoT['name'];
                $userItem[$i]['u_typeColor'] = $userInfoT['color'];
                $userItem[$i]['u_typeIcon'] = $userInfoT['icon'];
                $userItem[$i]['bdate'] = calculate_age($userInfo['birthday']);
                $zodiacInf = zodiac($userInfo['birthday'],$userInfoLogged['lang']);
                $userItem[$i]['zodiacName'] = $zodiacInf['zodName'];
                $userItem[$i]['zodiacIcon'] = $zodiacInf['zodIcon'];
                $i++;
            }
            return $userItem;
        }

        function utf8_urldecode($str) {
            $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
            return html_entity_decode($str,null,'UTF-8');
        }

        if(!$id)
        {
            $id="%";
        }


        if($id)
        {
                $id = utf8_urldecode($id);

            // Подключаемся к БД.
            $db = Db::getConnection();

            // Запрос к БД.
            $result = $db->query('SELECT us.id_user, us.login '
                . 'FROM users AS us INNER JOIN users_info u ON u.id_user = us.id_user WHERE us.login LIKE "'
                . $id
                . '%" OR u.name LIKE "'
                . $id
                . '%" OR u.sname LIKE "'
                . $id
                . '%" OR u.thname LIKE "'
                . $id
                .'%" GROUP BY us.id_user ORDER BY us.login DESC '
                . 'LIMIT 50');


            if ($result->rowCount() > 0) {
                $userItem = getUserInfo($result);

                return $userItem;
            }
            else
            {
                $contains_cyrillic = (bool) preg_match('/[\p{Cyrillic}]/u', $id);
                if ($contains_cyrillic) {
                    $id = ru2lat($id);
                }
                else
                {
                    $id = transliterate(null,$id);
                }

                // Запрос к БД.
                $result = $db->query('SELECT us.id_user, us.login '
                    . 'FROM users AS us INNER JOIN users_info u ON u.id_user = us.id_user WHERE us.login LIKE "'
                    . $id
                    . '%" OR u.name LIKE "'
                    . $id
                    . '%" OR u.sname LIKE "'
                    . $id
                    . '%" OR u.thname LIKE "'
                    . $id
                    .'%" GROUP BY us.id_user ORDER BY us.login DESC '
                    . 'LIMIT 50');

                if ($result->rowCount() > 0) {
                $userItem = getUserInfo($result);

                    return $userItem;
                }
                else
                {
                    $userItem[0]['err'] = "К сожалению мы никого не нашли!";
                    return $userItem;
                }
            }
        }

    }

    /*
     * Returns an array of news items.
     */
    public static function getMainList()
    {
        // Подключаемся к БД.
        $db = Db::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{


            $newList = array();

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

                    $newList[$i]['id_post'] = $row['id_post'];
                    $newList[$i]['title'] = $row['title'];
                    $newList[$i]['date'] = $row['date'];
                    $newList[$i]['short_content'] = $row['short_content'];
                    $newList[$i]['full_content'] = $row['full_content'];
                    $newList[$i]['u_name'] = $userInfo['name'];
                    $newList[$i]['u_sname'] = $userInfo['sname'];
                    $i++;
                }

                return $newList;
            }
        }
        catch (PDOexception $e) {

            echo "Error is ".$e->getmessage();

        }
    }
}