/**
 * Created by Шардановы on 08.06.2016.
 */
function getUserConversation()
{
    var href = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
    href = decodeURIComponent(href);

    if(window.location.href.indexOf("messages") > -1) {
        if (href.length > 1) {
            $('#textarea').data('id', href).attr('data-id', href);

            scrollChat(100);
            initChatSendOnKeyDown();
        }
    }

        callSocket();



    if($('.not-exist').html()) {
        $('.send-wrap').hide();
        $('.btn-panel').hide();
    }

    $(".conversation").click(function(event) {
        $('.haveNewMess',this).remove();
        $('#newMessHave').remove();
        $('.send-wrap').show();
        $('.btn-panel').show();
        // this.append wouldn't work
        var user = $(this).data("id");

        $.ajax({
            url: './'+user,  //Server script to process data
            type: 'POST', //Data send type
            dataType: "html", //Type of recived Data
            success: function(data) {
                history.pushState("", document.title, user);

                var source = $(data);
                $('.message-wrap').html(source.find('.message-wrap').html());

                $('#textarea').data('id', user).attr('data-id', user);

                callSocket();

                timeShow();
                scrollChat(100);
                initChatSendOnKeyDown();

                var actionText = 'readMess';
                var idTo = $('#to').val(); //get user name

                $.ajax({
                    url: '/functions/messages.php',  //Server script to process data
                    type: 'POST',
                    //Ajax events
                    //beforeSend: beforeSendHandler,
                    //error: errorHandler,
                    // Form data
                    data: ({action: actionText, to: idTo}),
                    dataType: "html",
                    success: function (data) {
                    },
                    //Options to tell jQuery not to process data or worry about content-type.
                    cache: false
                });
            },
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false
        });
    });
    timeShow();
}

function hasWhiteSpace(s)
{
    reWhiteSpace = new RegExp(/^\s+$/);

    // Check for white space
    if (reWhiteSpace.test(s)) {
        return false;
    }
    return true;
}

function isEmpty( el ){
    return !$.trim(el.html())
}

function getDateTime() {
    var now     = new Date();
    var year    = now.getFullYear();
    var month   = now.getMonth()+1;
    var day     = now.getDate();
    var hour    = now.getHours();
    var minute  = now.getMinutes();
    var second  = now.getSeconds();
    if(month.toString().length == 1) {
        var month = '0'+month;
    }
    if(day.toString().length == 1) {
        var day = '0'+day;
    }
    if(hour.toString().length == 1) {
        var hour = '0'+hour;
    }
    if(minute.toString().length == 1) {
        var minute = '0'+minute;
    }
    if(second.toString().length == 1) {
        var second = '0'+second;
    }
    var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;
    return dateTime;
}

function sendMess()
{
    var textText = $('#textarea').html();
    var myName = $('#sender').val(); //get user name
    var ava = $('#ava').val(); //get user name
    var idFrom = $('#from').val(); //get user name
    var idTo = $('#to').val(); //get user name

    // alert (textText+' '+toUser+' '+myName);

    textText = textText.replace(/<div><br><\/div>/g, '');
    textText = textText.replace(/<div>/g, '&#13;&#10;');
    textText = textText.replace(/<\/div>/g, '');
    textText = textText.replace(/&nbsp;/g, ' ');

    if(!hasWhiteSpace(textText)||textText.length<1)
    {
        $('#textarea').css({"background-color":"#FFBDBD"}, 1000);
        setTimeout(function(){
            $('#textarea').css({"background-color":"#F0F0F0"}, 1000);
        }, 300);
    }
    else {
        //  alert (textText+' '+toUser+' '+myName);
        //prepare json data
        var msg = {
            message: textText,
            ava: ava,
            name: myName,
            from: idFrom,
            to: idTo
        };
        //convert and send data to server
        websocket.send(JSON.stringify(msg));
    }
    $('#textarea').html(''); //reset text
}


function initChatSendOnKeyDown()
{
    $('.chatMessHolder').keydown(function (e)
    {
        if (e.ctrlKey && e.keyCode == 13)
        {
            sendMess();
        }
    });
}

function scrollChat(speed)
{
    $(".msg-wrap").animate({scrollTop:$(".msg-wrap")[0].scrollHeight}, speed)
}

function timeShow()
{
    $(".msg").hover(function(){
        $(".time", this).show();
    },function(){
        $(".time", this).hide();
    });
}

function callSocket()
{
    var audio = new Audio('https://linepuls.ru/sounds/alert_2.mp3');

    //create a new WebSocket object.
    var wsUri = "wss://linepuls.ru:443/wss/dev/socketMess.php";

    if(typeof websocket == "undefined")
    {
        websocket = new WebSocket(wsUri);

    }

    websocket.onopen = function(ev) { // connection is open
        console.log('Connection successfully opened!');
        setInterval(function() {
            var msg = {
                message: 'ping'
            };
            //convert and send data to server
            websocket.send(JSON.stringify(msg));
        }, 50 * 1000);
        //$('#message_box').append("<div class=\"system_msg\">Connected!</div>"); //notify user
    };

    $('#sendMess').click(function(){ //use clicks message send button
        sendMess();
    });

    //#### Message received from server?
    websocket.onmessage = function(ev) {
        var msg = JSON.parse(ev.data); //PHP sends Json data
        var type = msg.type; //message type
        var umsg = msg.message; //message text
        var uname = msg.name; //user name
        var ava = msg.ava; //user ava
        var nick = msg.nick;
        var to = msg.to;
        var from = msg.from;
        var fromVal = $('#from').val(); //get user
        var toVal = $('#to').val(); //get user
        var timeStamp = getDateTime();
        var myAcc = $('.user_page').data('id');

        var myName = $('#sender').val(); //get user name

        var uType; var uTypePos; var pull='pull-'; var timePos;

        if(type == 'usermsg' && umsg!=null && to==myAcc) {
            $('.messages_page').append('<p id="newMessHave"></p>');
            $('.haveNewMess').remove();
            $('[data-id="'+uname+'"]').append('<small class="haveNewMess">Есть новые сообщения!</small>');
            playSound(audio);
        }
        else
        {
            console.log(umsg);
        }

        if(myName==uname)
        {
            uType='';
            uTypePos='left';
            timePos='right';
        }
        else
        {
            uType='user-to';
            uTypePos='right';
            timePos='left';
        }

        var lastPost = $('.msg-wrap').children().last().data('id');

        if(lastPost)
        {
            lastPost =  $('.msg-wrap').children().last().data('id');
        }
        else
        {
            lastPost = 1;
        }

        if(type == 'usermsg')
        {
                if(uname!=null)
                {
                    if(myName!=uname && fromVal == to)
                    {
                        playSound(audio);
                    }

                    if((fromVal == from && toVal == to) || (fromVal == to && toVal == from))
                    {
                        $('.msg-wrap').append('<div class="media msg"><a class="pull-' + uTypePos + '" href="' + nick + '" target="_blank"><img class="media-object" alt="' + uname + '" src="' + ava + '"></a><div class="media-body"><small class="pull-' + timePos + ' time" style="display: none;"><i class="fa fa-clock-o"></i> ' + timeStamp + '</small> <h5 class="media-heading ' + uType + ' ' + pull + uTypePos + '">' + uname + '</h5><small class="col-lg-12" style="text-align: ' + uTypePos + '">' + umsg + '</small></div></div>');
                    }

                }

            timeShow();
        }
        if(type == 'system')
        {
            if (uname != null) {
                $('.msg-wrap').append('<div class="media msg"><a class="pull-left" href="' + nick + '" target="_blank"><img class="media-object" alt="' + uname + '" src="' + ava + '"></a><div class="media-body"><small class="pull-right time" style="display: none;"><i class="fa fa-clock-o"></i> 2016-06-07 17:51:33</small> <h5 class="media-heading ">' + uname + '</h5><small class="col-lg-12" style="">' + umsg + '</small></div></div>');

            }
        }
        if(window.location.href.indexOf("messages") > -1) {
            scrollChat(1000);
        }
    };

    // websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Error Occurred - "+ev.data+"</div>");};
    // websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Connection Closed "+ev.data+"</div>");};


    websocket.onerror =function() {
        console.log("Can't connect!");

       // $.ajax({
       //     url: "/dev/socketMess.php",
       //     context: document.body
       // });

        //location.reload();

    };

    websocket.onclose 	= function(ev) {
        console.log("Connection closed! "+ev.data);
    };

}

function playSound(audio){
    if (document.hidden) {
        audio.play();
    }
}

function sendMessToUser()
{
    var textText = $('.messHolder').html();
    var actionText = 'newMessage';
    var reciverID = $('.messHolder').data('id');
    var myAcc = $('.blogHolder').data('id');

    // alert (textText+' '+toUser+' '+myName);

    textText = textText.replace(/<div><br><\/div>/g, '');
    textText = textText.replace(/<div>/g, '&#13;&#10;');
    textText = textText.replace(/<\/div>/g, '');
    textText = textText.replace(/&nbsp;/g, ' ');

    if(!hasWhiteSpace(textText)||textText.length<1)
    {
        $('.messHolder').css({"background-color":"#FFBDBD"}, 1000);
        setTimeout(function(){
            $('.messHolder').css({"background-color":"#F0F0F0"}, 1000);
        }, 300);
    }
    else {

        var msg = {
            message: textText,
            to: myAcc
        };
        //convert and send data to server
        websocket.send(JSON.stringify(msg));

        $.ajax({
            url: './functions/user.php',  //Server script to process data
            type: 'POST',
            //Ajax events
            //beforeSend: beforeSendHandler,
            //error: errorHandler,
            // Form data
            data: ({action: actionText, text: textText, to: reciverID}),
            dataType: "html",
            success: function () {
                $('#messModal').modal('hide');
            },
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false
        });
    }
    $('.messHolder').html(''); //reset text
}

