<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */

class Main
{
    /*
     * Returns single news item with specified id.
     * @param integer $id
     */
    public static function getNewsItemById($id)
    {
        $id = intval($id);

        if($id)
        {
            // Подключаемся к БД.
            $db = Db::getConnection();

            // Запрос к БД.

            $result = $db->query('SELECT * FROM user_posts WHERE id_post='.$id);

            $newsItem = $result->fetch();

            return $newsItem;
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