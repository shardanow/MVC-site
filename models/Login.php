<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */

class Login
{

    /*
     * Returns an array of items.
     */
    public static function getLogin()
    {
        // Подключаемся к БД.
        $db = Db::getConnection();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
                $newList = array();
                $i = 0; $c = 0; $f = 0;

                $result = $db->prepare('SELECT id, name FROM user_type');
                $result->execute();

                $result1 = $db->prepare('SELECT id, country_name FROM countries');
                $result1->execute();

                $result2 = $db->prepare('SELECT id, or_name FROM orientation');
                $result2->execute();

                if($result2->rowCount() > 0) {
                    while ($row = $result2->fetch(PDO::FETCH_OBJ)) {
                        /*its getting data in line.And its an object*/
                        $newList[2][$f]['or_id'] = $row->id;
                        $newList[2][$f]['or_name'] = $row->or_name;
                        $f++;
                    }
                }

                if($result1->rowCount() > 0) {
                    while ($row = $result1->fetch(PDO::FETCH_OBJ)) {
                        /*its getting data in line.And its an object*/
                        $newList[1][$c]['c_id'] = $row->id;
                        $newList[1][$c]['c_name'] = $row->country_name;
                        $c++;
                    }
                }

                if($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                        /*its getting data in line.And its an object*/
                        $newList[0][$i]['id'] = $row->id;
                        $newList[0][$i]['name'] = $row->name;
                        $i++;
                    }
                }

            return $newList;
        }
        catch (PDOexception $e) {

            echo "Error is ".$e->getmessage();

        }
    }
}