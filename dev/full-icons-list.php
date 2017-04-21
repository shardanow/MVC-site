<html>
<head>
    <link rel="stylesheet" href="/font-awesome-4.6.3/css/font-awesome.min.css">
</head>
<body>

<?php

function connect()
{
    $paramsPath = '../config/db_params.php';
    $params = include($paramsPath);
    $opt = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
    $db = new PDO($dsn, $params['user'], $params['password'],$opt);

    return $db;
}

$db = connect();

$result = $db->prepare('SELECT icon,name,color FROM user_type ORDER BY color');
$result->bindParam(1, $login);
$result->execute();

if($result->rowCount() > 0)
{
    while($row=$result->fetch(PDO::FETCH_OBJ)) {
        echo '<p style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif;cursor:default;"><i class="fa fa-'.$row->icon.'" style="color: '.$row->color.'"></i> '.$row->name.'</p>';
    }
}

echo "<br><p style='font-family: Helvetica Neue,Helvetica,Arial,sans-serif;cursor:default;'>Total: ".$result->rowCount()." шт.</p><br>"

?>

</body>
</html>