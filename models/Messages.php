<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 16:56
 */

class Messages
{
    /*
     * Returns list of users and messages for current user with specified login.
     * @param string $login
     */
    public static function getUserById($login)
    {
        function getUserInfo($result,$arg)
        {
            $db = Db::getConnection();

            $i = 0;
            $userItem = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
               // echo $row['sender'].' => '.$row['reciver'].' ';
                $result_user_info = $db->query('SELECT u.login, ui.name, ui.sname, ui.ava FROM users_info AS ui INNER JOIN users u ON u.id_user = ui.id_user WHERE ui.id_user=' . $row['sender']. ' LIMIT 1');
                $userInfo = $result_user_info->fetch();

                // Запрос к БД.
                if($arg=="list")
                {
                    $resultMess = $db->prepare('SELECT text, sended, id, flag FROM user_messages WHERE id = ? AND reciver=? OR sender=? ORDER BY sended DESC');
                    $resultMess->bindParam(1, $row['id']);
                    $resultMess->bindParam(2, $row['sender']);
                    $resultMess->bindParam(3, $row['sender']);
                }
                else
                {
                    $resultMess = $db->prepare('SELECT text, sended, id, flag FROM user_messages WHERE id = ?');
                    $resultMess->bindParam(1, $row['id']);
                }
                $resultMess->execute();

                if($resultMess->rowCount() > 0)
                {
                    $userMess = $resultMess->fetch();

                    if ($row['sender'] == $_SESSION['uid']) {
                        $userItem[$i]['sender'] = 1;
                    } else {
                        $userItem[$i]['sender'] = 0;
                    }
                    $userItem[$i]['flag'] = $userMess['flag'];
                    $userItem[$i]['text'] = $userMess['text'];
                    $userItem[$i]['id'] = $userInfo['login'];
                    $userItem[$i]['text'] = $userMess['text'];
                    $userItem[$i]['sended'] = $userMess['sended'];
                    $userItem[$i]['messId'] = $userMess['id'];
                    $userItem[$i]['ava'] = $userInfo['ava'];
                    $userItem[$i]['u_name'] = $userInfo['name'];
                    $userItem[$i]['u_sname'] = $userInfo['sname'];
                }
                else
                {
                    $userItem[0]['err'] = "Сообщений с данным пользователем - нет!";
                }

                $i++;
            }
            return $userItem;
        }

            $id = $_SESSION['uid'];

            //echo $id.' => '.$to.' ';

            // Подключаемся к БД.
            $db = Db::getConnection();

            if($login)
            {
                //name sname ava login

                $resultMess = $db->prepare('SELECT u.id_user FROM users_info AS ui INNER JOIN users u ON u.id_user = ui.id_user WHERE u.login=? LIMIT 1');
                $resultMess->bindParam(1, $login);
                $resultMess->execute();


                // Запрос к БД.
                $resultMessUs = $db->prepare('SELECT sender, id FROM user_messages a WHERE a.reciver = ? GROUP BY a.sender ORDER BY sender');
                $resultMessUs->bindParam(1, $id);
                $resultMessUs->execute();

                if ($resultMess->rowCount() <= 0) {
                    $userItem[0]['err'] = "Такого пользователя не существует!";
                    $userList = getUserInfo($resultMessUs);

                    return array($userItem,$userList);
                }
                else
                {
                    $userMess = $resultMess->fetch();

                    $resultSend = $db->prepare('SELECT u.id_user, ui.name, ui.sname, ui.ava FROM users_info AS ui INNER JOIN users u ON u.id_user = ui.id_user WHERE u.id_user=? LIMIT 1');
                    $resultSend->bindParam(1, $id);
                    $resultSend->execute();

                    if($resultSend->rowCount() > 0) {
                        while ($row = $resultSend->fetch(PDO::FETCH_ASSOC)) {
                            $userSender[0]['name'] = $row['name'];
                            $userSender[0]['sname'] = $row['sname'];
                            $userSender[0]['ava'] = $row['ava'];
                            $userSender[0]['id'] = $userMess['id_user'];
                        }
                    }

                    $to = $userMess['id_user'];
                }

                // Запрос к БД.
                $result = $db->prepare('SELECT sender, id, reciver, sended FROM user_messages a WHERE (a.sender = ? AND a.reciver = ?) OR (a.sender = ? AND a.reciver = ?) ORDER BY sended');
                $result->bindParam(1, $id);
                $result->bindParam(2, $to);
                $result->bindParam(3, $to);
                $result->bindParam(4, $id);
                $result->execute();


                if ($resultMessUs->rowCount() > 0) {
                    $userItem = getUserInfo($result);
                    $userList = getUserInfo($resultMessUs,"list");

                    return array($userItem,$userList,$userSender);
                }
                else
                {
                    $userItem[0]['err'] = "Вы никому не писали!";
                    $userList[0]['err'] = "Вы никому не писали!";

                    return array($userItem,$userList,$userSender);
                }
            }
            else
            {
                $userItem[0]['err'] = "Выберите собеседника!";

                // Запрос к БД.
                $resultMessUs = $db->prepare('SELECT sender, id FROM user_messages a WHERE (a.sender = ? OR a.reciver = ?) GROUP BY a.sender ORDER BY sender');
                $resultMessUs->bindParam(1, $id);
                $resultMessUs->bindParam(2, $id);
                $resultMessUs->execute();

                if ($resultMessUs->rowCount() <= 0) {
                    $userList[0]['err'] = "Вы никому не писали!";
                }
                else
                {
                    $userList = getUserInfo($resultMessUs,"list");
                }

                return array($userItem,$userList,$userSender);

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