<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */

    class Music
    {

        /*
         * Returns single song item with specified id.
         * @param integer $id
         */

        public static function getMusicList()
        {

        }


        /*
         * Returns an array of song items.
         */
        public static function getMusicListUser($id)
        {
            // Подключаемся к БД.
            $db = Db::getConnection();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try {


                $newList = array();

                // Запрос к БД.

                $result = $db->query('SELECT * '
                    . 'FROM users_audio WHERE id_usr='
                    . $id
                    . ' ORDER BY date DESC '
                    . 'LIMIT 50');

                $i = 0;
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $result_user_info = $db->query('SELECT * FROM users_info WHERE id_user=' . $id. ' LIMIT 1');

                        $userInfo = $result_user_info->fetch();

                        $newList[$i]['id_track'] = $row['id_track'];
                        $newList[$i]['url'] = $row['url'];
                        $newList[$i]['name'] = $row['name'];
                        $newList[$i]['img'] = $row['img'];
                        $newList[$i]['id_usr'] = $row['id_usr'];
                        $newList[$i]['u_name'] = $userInfo['name'];
                        $newList[$i]['u_sname'] = $userInfo['sname'];
                        $newList[$i]['u_thname'] = $userInfo['thname'];
                        $i++;
                    }

                    return $newList;
                }
                else
                {
                    $newList[0]['name'] ='Nothing...';
                    return $newList;
                }
            } catch (PDOexception $e) {

                echo "Error is " . $e->getmessage();

            }
        }
    }

