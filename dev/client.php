<?php
session_start();
$login=$_SESSION['login'];
$id=$_SESSION['uid'];
$to = 4;

function connect_to()
{
    $paramsPath = $_SERVER['DOCUMENT_ROOT'].'/config/db_params.php';
    $params = include($paramsPath);
    $opt = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    );
    $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
    $db = new PDO($dsn, $params['user'], $params['password'],$opt);

    return $db;
}

$db = connect_to();

//Get user messages
$result = $db->prepare('SELECT * FROM user_messages WHERE sender = ? AND reciver = ?');
$result->bindParam(1, $id);
$result->bindParam(2, $to);
$result->execute();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8' />
    <style type="text/css">
        <!--
        .chat_wrapper {
            width: 500px;
            margin-right: auto;
            margin-left: auto;
            background: #CCCCCC;
            border: 1px solid #999999;
            padding: 10px;
            font: 12px 'lucida grande',tahoma,verdana,arial,sans-serif;
        }
        .chat_wrapper .message_box {
            background: #FFFFFF;
            height: 150px;
            overflow: auto;
            padding: 10px;
            border: 1px solid #999999;
        }
        .chat_wrapper .panel input{
            padding: 2px 2px 2px 5px;
        }
        .system_msg{color: #BDBDBD;font-style: italic;}
        .user_name{font-weight:bold;}
        .user_message{color: #88B6E0;}
        -->
    </style>
</head>
<body>
<?php
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours);
?>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<script language="javascript" type="text/javascript">
    function callSocket()
    {
        //create a new WebSocket object.
        var wsUri = "ws://212.224.118.198:9000/dev/sockettest.php";
        websocket = new WebSocket(wsUri);

        websocket.onopen = function(ev) { // connection is open
            console.log('Connection successfully opened!');

            //$('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
        };

        $('#send-btn').click(function(){ //use clicks message send button
            var mymessage = $('#message').val(); //get message text
            var myname = $('#name').val(); //get user name
            var myid = $('#id').val(); //get user id

            if(myname == ""){ //empty name?
                alert("Enter your Name please!");
                return;
            }
            if(mymessage == ""){ //emtpy message?
                alert("Enter Some message Please!");
                return;
            }

            //prepare json data

            var msg = {
                message: mymessage,
                to: 'zackushka',
                from: 'denissined'
            };
            //convert and send data to server
            websocket.send(JSON.stringify(msg));
        });

        //#### Message received from server?
        websocket.onmessage = function(ev) {
            var msg = JSON.parse(ev.data); //PHP sends Json data
            var type = msg.type; //message type
            var umsg = msg.message; //message text
            var uname = msg.name; //user name
            var uid = msg.id; //user name
            var ucolor = msg.color; //color

            if(type == 'usermsg')
            {
                $('#message_box').append("<div><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");

            }
            if(type == 'system')
            {
                $('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
            }

            $('#message').val(''); //reset text
        };

       // websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");};
       // websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed "+ev.data+"</div>");};


        websocket.onerror =function() {
            console.log("Can't connect!");

            $.ajax({
                url: "sockettest.php",
                context: document.body
            });

            location.reload();

        };

        websocket.onclose =function() {
            console.log("Connection closed!");
        };
    }

    $(document).ready(function(){
        callSocket();
    });

</script>
<div class="chat_wrapper">
    <div class="message_box" id="message_box">
        <?php
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                echo '<div><span class="user_name" style="color:red;">'.$row->sender.'</span> : <span class="user_message">'.$row->text.' '.$row->sended.'</span></div>';
            }
        }
        $db=null;
        ?>
    </div>

    <div class="panel">
        <input type="text" name="name" id="name" placeholder="Your Name" maxlength="10" style="width:20%" value="<?php echo $login;?>"  />
        <input id="id" name="id" type="hidden" value="<?php echo $id;?>"/>
        <input type="text" name="message" id="message" placeholder="Message" maxlength="80" style="width:60%" />
        <button id="send-btn">Send</button>
    </div>
</div>

</body>
</html>