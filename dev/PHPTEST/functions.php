<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 25.02.2016
 * Time: 22:28
 */

//Function for get ip Client
function ip_client()
{
    //Test if it is a shared client
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
//Is it a proxy address
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
//The value of $ip at this point would look something like: "192.0.34.166"
    $ip = ip2long($ip);
//The $ip would now look something like: 1073732954

    return $ip;
}


//Function for check len of string
function check_exist($string, $minlen, $maxlen)
{
    $strname="Название";

            if (strlen($string)<$minlen)
            {
                echo $strname." не должно быть короче ".$minlen." символов.";
                exit;
            }
            elseif(strlen($string)>$maxlen)
            {
                echo $strname." не должно быть длинее ".$maxlen." символов.";
                exit;
            }
}


//Function for get and show category list from DB
function list_categories()
{
    include "bd.php";

    $stmt = $pdo->prepare('SELECT id,name FROM categories');
    $stmt->execute();
    foreach ($stmt as $row)
    {
        echo <<< EOT
     <option value="$row[id]">$row[name]</option>
EOT;
    }

    $pdo=null;
}


//Function for get list of fields from DB and returnt it in visual block to the page
function list_fields()
{
    include "bd.php";

    $stmt = $pdo->prepare('SELECT id,cat,name FROM fields');
    $stmt->execute();
    foreach ($stmt as $row)
    {
        $stmt1 = $pdo->prepare('SELECT name FROM categories WHERE id=? LIMIT 1');
        $stmt1->execute(array($row['cat']));
        $data1 = $stmt1->fetchAll();
        $category = $data1[0]['name'];
        $val_text = htmlspecialchars($row['name'],ENT_QUOTES);

        echo <<< EOT
<div id="field_$row[id]">
            <div class="btn-func btn-func-del" onclick="delete_field('$row[id]')"><i class="fa fa-minus"></i></div>
            <div class="btn-func btn-func-edit" onclick="edit_field('$row[id]')"><i class="fa fa-pencil"></i></div>
            <div class="btn-func btn-func-apply edit_$row[id]" onclick="apply_field('$row[id]')"><i class="fa fa-check"></i></div>

            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1" data-container="body" data-toggle="tooltip" data-placement="bottom" title="$category">$category</span>
                <input id="$row[id]" onkeypress="return runScript(event,'$row[id]')" type="text" class="form-control" placeholder="Enter country name" aria-describedby="basic-addon1" value="$val_text" disabled>
            </div>
        </div>
EOT;
    }

    $pdo=null;
}

//Function for delete field from DB
function delete_field($id)
{
    $id=(int)$id;
    include "bd.php";

    $stmt = $pdo->prepare("DELETE FROM fields WHERE id =  :ID");
    $stmt->bindParam(':ID', $id);
    $stmt->execute();

    $pdo=null;

    echo "Done for ".$id."!";
}

//Function for edit field in DB
function edit_field($id,$descr,$user_ip)
{
    check_exist($descr, 5, 80);
    $id=(int)$id;
    include "bd.php";

    $stmt = $pdo->prepare("UPDATE fields SET user=:name, name=:descr WHERE id=:ID");
    $stmt->bindParam(':name', $user_ip);
    $stmt->bindParam(':descr', $descr);
    $stmt->bindParam(':ID', $id);
    $stmt->execute();

    $pdo=null;

    echo "Done for ".$id."!";
}

//Function for insertion
function insert_field($descr,$user_ip,$type)
{
    check_exist($descr, 5, 50);
    $type=(int)$type;
    include "bd.php";

    $stmt = $pdo->prepare("INSERT INTO fields (user, name, cat) VALUES (:name,:descr,:type)");
    $stmt->bindParam(':name', $user_ip);
    $stmt->bindParam(':descr', $descr);
    $stmt->bindParam(':type', $type);
    $stmt->execute();

    $pdo=null;

    echo "Done!";
}

//Matches for POST and call need functions
if(isset($_POST['add_field'])&&$_POST['add_field']==1) //New field
{
    insert_field($_POST['field_name'],ip_client(),$_POST['field_type']);
}
elseif(isset($_POST['edit_field'])&&$_POST['edit_field']==1) //Edit field
{
    edit_field($_POST['id'],$_POST['field_name'],ip_client());
}
elseif(isset($_POST['remove_field'])&&$_POST['remove_field']==1) //Remove field
{
    delete_field($_POST['id']);
}