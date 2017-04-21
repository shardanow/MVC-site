/**
 * Created by Denis Shardanov on 22.03.2016.
 */

function addFriend($id)
{
    toID = $id;
    actionText = 'newFriendAdd';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#addFriend").addClass("active");
            $("#addFriend").html('<i class="fa fa-user-times" aria-hidden="true"></i>');
            $("#addFriend").attr('data-original-title', 'Удалить из друзей');
            $("#addFriend").attr("onclick","delFriend("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function sendFriendReq($id)
{
    toID = $id;
    actionText = 'newFriendReq';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#addFriend").addClass("active");
            $("#addFriend").html('<i class="fa fa-user-times" aria-hidden="true"></i>');
            $("#addFriend").attr('data-original-title', 'Отозвать заявку');
            $("#addFriend").attr("onclick","delFriendReq("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function delFriendReq($id)
{
    toID = $id;
    actionText = 'newFriendDelReq';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#addFriend").removeClass("active");
            $("#addFriend").html('<i class="fa fa-user-plus" aria-hidden="true"></i>');
            $("#addFriend").attr('data-original-title', 'Отправить заявку');
            $("#addFriend").attr("onclick","sendFriendReq("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function delFriend($id)
{
    toID = $id;
    actionText = 'newFriendDel';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#addFriend").removeClass("active");
            $("#addFriend").html('<i class="fa fa-user-plus" aria-hidden="true"></i>');
            $("#addFriend").attr('data-original-title', 'Отправить заявку');
            $("#addFriend").attr("onclick","sendFriendReq("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function addRespect($id)
{
    toID = $id;
    actionText = 'addRespect';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#rateUser").addClass("active");
            $("#rateUser").attr('data-original-title', 'Убрать респект');
            $("#rateUser").attr("onclick","delRespect("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function delRespect($id)
{
    toID = $id;
    actionText = 'delRespect';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#rateUser").removeClass("active");
            $("#rateUser").attr('data-original-title', 'Респект');
            $("#rateUser").attr("onclick","addRespect("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function addFavU($id)
{
    toID = $id;
    actionText = 'addFavoriteUser';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#favUser").addClass("active");
            $("#favUser").attr('data-original-title', 'Убрать из избранного');
            $("#favUser").attr("onclick","delFavU("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function delFavU($id)
{
    toID = $id;
    actionText = 'delFavoriteUser';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, idto: toID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#favUser").removeClass("active");
            $("#favUser").attr('data-original-title', 'В избранное');
            $("#favUser").attr("onclick","addFavU("+$id+")");
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function usr_img_me()
{
    $('.user_image').mouseenter(function() {
        $(this).children('.image-upload').stop();
        $(this).children('.image-upload').fadeOut(0);
        $(this).children('.image-upload').fadeIn();
    });
}

function usr_img_ml()
{
    $('.user_image').mouseleave(function() {
        $(this).children('.image-upload').stop();
        $(this).children('.image-upload').fadeIn(0);
        $(this).children('.image-upload').fadeOut();
    });
}

function showDelBtn()
{
    $('.post_blog_text').mouseenter(function() {
        $(this).children('.del_btn').show();
    });

    $('.post_blog_text').mouseleave(function() {
        $(this).children('.del_btn').hide();
    });
}

function url_image(url, t)
{
        if(t=='')
        {
            $('#imageContainter').html('');

            var i = new Image();
            i.onload = function()
            {
                $(i).appendTo($('#imageContainter')).fadeIn();
            };

            i.onerror = function()
            {
                $('#imageContainter').html("Ссылка не рабочая...");
            };

            i.src = url; // существующее изображение
        }
        else
        {
            return url;
        }
}

function url_image_add()
{
    actionText = 'newUrlImg';
    link = $('#imageContainter img').attr('src');
    blogID = $('#textarea').data('id');

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST',
        //Ajax events
        //beforeSend: beforeSendHandler,
        //error: errorHandler,
        // Form data
        data: ({action: actionText, urlImg: link, idto: blogID}),
        dataType: "html",
        success: function (data) {
            $('#pictureModal').modal('hide');
            var source = $(data);
            $('#imageContainterPost').html(source.find('#imageContainterPost').html());
            delete_att();
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function delete_att()
{
    $('.delete').click(function(){
        draftID = $(this).parent().data('id');
        actionText = 'deleteDraftItem';

        $.ajax({
            url: './functions/user.php',  //Server script to process data
            type: 'POST', //Data send type
            data: ({action: actionText, draft: draftID}), //Data variables
            dataType: "html", //Type of recived Data
            success: function(data) {
                $.ajax({
                    url: $(location).attr('href')+'/',  //Server script to process data
                    dataType: "html", //Type of recived Data
                    success: function(data)
                    {
                        var source = $(data);
                        $('#imageContainterPost').html(source.find('#imageContainterPost').html());
                        delete_att();
                    },
                    error:  function(xhr, str){
                        alert('Возникла ошибка: ' + xhr.responseCode);
                    },
                    cache: false
                });
            },
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false
        });
        return false;
    });
}


function sendImgPost()
{
    blogID = $('#textarea').data('id');
    var formData = new FormData($('form')[0]);
    formData.append("action", "uplImgPost");
    formData.append("idto", blogID);

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            $('#imgDraftUpl').show();
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        success: function(data) {
            $.ajax({
                url: $(location).attr('href')+'/',  //Server script to process data
                dataType: "html", //Type of recived Data
                success: function(data)
                {

                    $('#pictureModal').modal('hide');
                    var source = $(data);
                    $('#imageContainterPost').html(source.find('#imageContainterPost').html());
                    delete_att();
                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                },
                cache: false
            });
        },
        // Form data
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function progressHandlingFunction(e)
{
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
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

function sendPost()
{
    var textText = $('#textarea').html();
    titleText = '';
    actionText = 'newBlogPost';
    blogID = $('#textarea').data('id');
    lastPost = $('#user_blog').children().first().attr('id');
    if(lastPost)
    {
        lastPost =  $('#user_blog').children().first().attr('id').replace(/[^0-9]/g, '');
    }
    else
    {
        lastPost = 1;
    }

    textText = textText.replace(/<div><br><\/div>/g, '');
    textText = textText.replace(/<div>/g, '&#13;&#10;');
    textText = textText.replace(/<\/div>/g, '');
    textText = textText.replace(/&nbsp;/g, ' ');

    if (isEmpty($('#imageContainterPost')))
    {
        if(!hasWhiteSpace(textText)||textText.length<1)
        {
                $('#textarea').css({"background-color":"#FFBDBD"}, 1000);
            setTimeout(function(){
                $('#textarea').css({"background-color":"#F0F0F0"}, 1000);
            }, 300);
        }
        else {
            $.ajax({
                url: './functions/user.php',  //Server script to process data
                type: 'POST',
                //Ajax events
                //beforeSend: beforeSendHandler,
                //error: errorHandler,
                // Form data
                data: ({action: actionText, title: titleText, text: textText, blog: blogID}),
                dataType: "html",
                success: function (data) {
                    $.ajax({
                        url: $(location).attr('href')+'/',  //Server script to process data
                        dataType: "html", //Type of recived Data
                        success: function(data)
                        {
                            var source = $(data);
                            $('#user_blog').html(source.find('#user_blog').html());
                            $('div').filter(function() {
                                return parseInt( this.id.replace('post-',''), 10) > lastPost;
                            }).fadeOut(300).fadeIn(300);

                            delete_att();
                            showDelBtn();
                            tooltip_post();
                            $('#textarea').html('');
                            $('#imageContainterPost').html('');
                        },
                        error:  function(xhr, str){
                            alert('Возникла ошибка: ' + xhr.responseCode);
                        },
                        cache: false
                    });
                },
                //Options to tell jQuery not to process data or worry about content-type.
                cache: false
            });
        }
    }
    else
    {
        $.ajax({
            url: './functions/user.php',  //Server script to process data
            type: 'POST',
            //Ajax events
            //beforeSend: beforeSendHandler,
            //error: errorHandler,
            // Form data
            data: ({action: actionText, title: titleText, text: textText, blog: blogID}),
            dataType: "html",
            success: function (data) {
                $.ajax({
                    url: $(location).attr('href')+'/',  //Server script to process data
                    dataType: "html", //Type of recived Data
                    success: function(data)
                    {
                        var source = $(data);
                        $('#user_blog').html(source.find('#user_blog').html());
                        $('div').filter(function() {
                            return parseInt( this.id.replace('post-',''), 10) > lastPost;
                        }).fadeOut(300).fadeIn(300);

                        delete_att();
                        showDelBtn();
                        tooltip_post();
                        $('#textarea').html('');
                        $('#imageContainterPost').html('');
                    },
                    error:  function(xhr, str){
                        alert('Возникла ошибка: ' + xhr.responseCode);
                    },
                    cache: false
                });
            },
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false
        });
    }
}

function deletePost($id)
{
    blogID = $('#textarea').data('id');
    postID = $id;
    actionText = 'deleteBlogPost';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, post: postID, blog: blogID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $("#post-"+$id).fadeOut(500, function(){ $(this).remove();});
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function likePost($id)
{
    typeID = '1';
    postID = $id;
    actionText = 'UserLike';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, element: postID, type: typeID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            var sourceResp = $(data);
            $.ajax({
                url: $(location).attr('href')+'/',  //Server script to process data
                dataType: "html", //Type of recived Data
                success: function(data)
                {
                    var source = $(data);
                    if(sourceResp.filter('#response_mess').text()=='set')
                    {
                        $("#g_post-"+$id).addClass("active");
                        //alert(source.find("#g_post-"+$id).parent().html());
                        $("#user_blog").find("#g_post-"+$id).parent().html(source.find("#g_post-"+$id).parent().html());
                        tooltip_post();
                    }
                    else if(sourceResp.filter('#response_mess').text()=='unset')
                    {
                        $("#g_post-"+$id).removeClass("active");
                        $("#user_blog").find("#g_post-"+$id).parent().html(source.find("#g_post-"+$id).parent().html());
                        tooltip_post();
                    }
                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                },
                cache: false
            });
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function dislikePost($id)
{
    typeID = '1';
    postID = $id;
    actionText = 'UserDisLike';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, element: postID, type: typeID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            var sourceResp = $(data);
            $.ajax({
                url: $(location).attr('href')+'/',  //Server script to process data
                dataType: "html", //Type of recived Data
                success: function(data)
                {
                    var source = $(data);
                    if(sourceResp.filter('#response_mess').text()=='set')
                    {
                        $("#g_post-"+$id).addClass("active");
                        //alert(source.find("#g_post-"+$id).parent().html());
                        $("#user_blog").find("#g_post-"+$id).parent().html(source.find("#g_post-"+$id).parent().html());
                        tooltip_post();
                    }
                    else if(sourceResp.filter('#response_mess').text()=='unset')
                    {
                        $("#g_post-"+$id).removeClass("active");
                        $("#user_blog").find("#g_post-"+$id).parent().html(source.find("#g_post-"+$id).parent().html());
                        tooltip_post();
                    }
                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                },
                cache: false
            });
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function favPost($id)
{
    typeID = '1';
    postID = $id;
    actionText = 'UserFav';

    $.ajax({
        url: './functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, element: postID, type: typeID}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            var sourceResp = $(data);
            $.ajax({
                url: $(location).attr('href')+'/',  //Server script to process data
                dataType: "html", //Type of recived Data
                success: function(data)
                {
                    var source = $(data);
                    if(sourceResp.filter('#response_mess').text()=='set')
                    {
                        $("#g_post-"+$id).addClass("active");
                        //alert(source.find("#g_post-"+$id).parent().html());
                        $("#user_blog").find("#g_post-"+$id).parent().html(source.find("#g_post-"+$id).parent().html());
                        tooltip_post();
                    }
                    else if(sourceResp.filter('#response_mess').text()=='unset')
                    {
                        $("#g_post-"+$id).removeClass("active");
                        $("#user_blog").find("#g_post-"+$id).parent().html(source.find("#g_post-"+$id).parent().html());
                        tooltip_post();
                    }
                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                },
                cache: false
            });
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}



function vkAuth($token)
{
    Token = $token;
    actionText = 'vkAuth';

    $.ajax({
        url: './functions/login.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, token: Token}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $('.profile-top-description').next('p').remove();
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function twAuth($token,$tokenSecret)
{
    actionText = 'twAuth';

    $.ajax({
        url: './functions/login.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, token: $token, token_secret: $tokenSecret}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            $('.profile-top-description').next('p').remove();
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function logOutSocial($social)
{
    actionText = 'socLogOut';
    socialName = $social;
    //alert($social);

    $.ajax({
        url: '/functions/user.php',  //Server script to process data
        type: 'POST', //Data send type
        data: ({action: actionText, socialName: socialName}), //Data variables
        dataType: "html", //Type of recived Data
        success: function(data) {
            location.reload();
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}


var flag = true;




function newsNext($step)
{
    //alert($step);
    Step = $step;
    actionText = 'newsNext';

    $.ajax({
        url: '/news/'+Step,  //Server script to process data
        type: 'POST', //Data send type
        dataType: "html", //Type of recived Data
        success: function(data) {

            console.log("CurrentPage: ",$('#nextVKPage').val());
            var source = $(data);
            $('#nextVKPage').val(source.find('#nextVKPage').val());
            var $item=source.find('#posts').children('.item');

            IzoImages(2, $item);
            flag=true;
            console.log("LoadedPage: ",source.find('#nextVKPage').val());
        },
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false
    });
}

function updSettings()
{
    var form = $('#userSettingForm').serialize();

    $.ajax({
        url: '/functions/user_edit.php',  //Server script to process data
        type: 'POST', //Data send type
        data: (form), // serializes the form's elements.
        dataType: "html", //Type of recived Data
        success: function(data)
        {
            $.ajax({
                url: '/settings/',  //Server script to process data
                dataType: "html", //Type of recived Data
                success: function(data)
                {
                    var source = $(data);
                    $('.top_settings').html(source.find('.top_settings').html());
                    usr_img_me();
                    usr_img_ml();
                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                },
                cache: false
            });
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        },
        cache: false
    });
}



function uploadAva()
{
    var formData = new FormData($('#userAvaForm')[0]);

    $.ajax({
        url: '/functions/user_edit.php',  //Server script to process data
        type: 'POST',
        dataType: "html", //Type of recived Data
        xhr: function() {  // Custom XMLHttpRequest
            $('.avaProgress').show();
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        success: function(data) {
            $.ajax({
                url: window.location.href,  //Server script to process data
                dataType: "html", //Type of recived Data
                success: function(data)
                {
                    $('#avaModal').modal('hide');
                    var source = $(data);
                    $('.user_image').html(source.find('.user_image').html());
                },
                error:  function(xhr, str){
                    alert('Возникла ошибка: ' + xhr.responseCode);
                },
                cache: false
            });
            //var source = $($.parseHTML(data));
            //alert (source.find('#imageContainterPost').html());
            //$('.user_image').html(source.find('.user_image').html());
        },
        // Form data
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

var jcrop_api;
var img, input_var,orig;



function readURL(input,reinit,img_w,img_h) {

    var width,height;

    input_var = input;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        img = document.createElement("img");

        reader.onload = function () {
            img.src = reader.result;
            img.id = "cropbox";
            $(".imageContainterAva").html(img);

            if (reinit = true && img_w > 0 && img_h > 0) {
                img.setAttribute('width', img_w);
                img.setAttribute('height', img_h);
            }
            else {
                orig = $('#cropbox');
            }

            img.addEventListener('load', function () {

                h = $('#cropbox').height() / 2;
                w = h;
                if(window.innerWidth < 500)
                {
                        height = img.height/2;
                        width = img.width/2;
                        img.setAttribute('width', width);
                        img.setAttribute('height', height);
                }

                x = $('#cropbox').width() / 2 - w / 2;
                y = $('#cropbox').height() / 2 - h / 2;
                x1 = x + w;
                y1 = y + h;


                $('#cropbox').Jcrop({
                    aspectRatio: 1,
                    onSelect: updateCoords,
                    minSize: [100, 100],
                    setSelect: [x, y, x1, y1],
                    addClass: 'jcrop-dark',
                    allowSelect: false,
                    onRelease: releaseCheck
                }, function () {
                    // Store the API in the jcrop_api variable
                    jcrop_api = this;
                });
                // alert('Img size: '+$('#cropbox').width() + ' × ' + $('#cropbox').height()+'\nCoord x y: '+x+' x '+y+'\nCoord x1 y1: '+x1+' x '+y1+'\nSelected area size: '+h+' x '+w );
            });

        };

        reader.readAsDataURL(input.files[0]);

    }

    function releaseCheck() {
        this.setOptions({setSelect: [0, 0, 100, 100]});
    };


}

function device_resizer(img_w_scale,img_h_scale)
{
    if(typeof(orig) !== "undefined" && orig !== null) {
        var w = orig.width / img_w_scale, h = orig.height / img_h_scale;

        $('#cropbox').remove();
        readURL(input_var, true, w, h);
    }
}

var href = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
href = decodeURIComponent(href);


window.onresize = function() {
    if(window.location.href.indexOf("user") > -1) {
        if (window.innerWidth < 400) {
            device_resizer(3, 3)
        }
        else if (window.innerWidth < 500) {
            device_resizer(2, 2)
        }
        else if (window.innerWidth < 800) {
            device_resizer(1.2, 1.2)
        }
        else if (window.innerWidth > 800) {
            device_resizer(1, 1)
        }
    }

};

function updateCoords(c)
{
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
    $('#h_src').val($('#cropbox').height());
    $('#w_src').val($('#cropbox').width());
}

function checkCoords()
{
                if (parseInt($('#w').val())) return true;
                alert('Please select a crop region then press submit.');
                return false;
}

function feedPostCounter($value,$action)
{
    if($action=='plus'&&$value>=4&&$value!=10)
    {
        $value = parseInt($value,10)+1;
        $('.top-news-filter-button-counter').text($value);
        feedSetter('setVKPostCount',$value);
        $('.plus-post-button').attr("onclick","feedPostCounter('"+($value)+"', 'plus')");
        $('.minus-post-button').attr("onclick","feedPostCounter('"+($value)+"', 'minus')");
    }
    else if($action=='minus'&&$value>4&&$value<=10)
    {
        $value = parseInt($value,10)-1;
        $('.top-news-filter-button-counter').text($value);
        feedSetter('setVKPostCount',$value);
        $('.plus-post-button').attr("onclick","feedPostCounter('"+($value)+"', 'plus')");
        $('.minus-post-button').attr("onclick","feedPostCounter('"+($value)+"', 'minus')");
    }


}

function feedSetter($func,$value,$filter)
{
    if($filter=='tw' || $filter=='vk' || $filter=='fb')
    {
        $('#posts').html('');
        $.ajax({
            url: '/functions/newsfeed.php',  //Server script to process data
            type: 'POST', //Data send type
            data: ({action: $func, value: $value, social: $filter}), //Data variables
            dataType: "html", //Type of recived Data
            success: function(data) {
                $.ajax({
                    url: '/news/',  //Server script to process data
                    type: 'POST', //Data send type
                    dataType: "html", //Type of recived Data
                    success: function(data) {

                        console.log("CurrentPage: ",$('#nextVKPage').val());
                        var source = $(data);
                        $('#nextVKPage').val(source.find('#nextVKPage').val());
                        var $item=source.find('#posts');

                        IzoImages(3, $item);
                        flag=true;
                        console.log("LoadedPage: ",source.find('#nextVKPage').val());

                        if($value=='0')
                        {
                            if($filter=='vk')
                            {
                                $(".social-button-vk").attr("onclick","feedSetter('setSocialFilter','1','vk')");
                                $(".social-button-vk").removeClass("top-news-filter-button-act");
                                $(".social-button-i-vk").removeClass("top-news-filter-button-i-act");
                            }
                            else if($filter=='tw')
                            {
                                $(".social-button-tw").attr("onclick","feedSetter('setSocialFilter','1','tw')");
                                $(".social-button-tw").removeClass("top-news-filter-button-act");
                                $(".social-button-i-tw").removeClass("top-news-filter-button-i-act");
                            }
                            else if($filter=='fb')
                            {
                                $(".social-button-fb").attr("onclick","feedSetter('setSocialFilter','1','fb')");
                                $(".social-button-fb").removeClass("top-news-filter-button-act");
                                $(".social-button-i-fb").removeClass("top-news-filter-button-i-act");
                            }
                        }
                        else if($value=='1')
                        {
                            if($filter=='vk')
                            {
                                $(".social-button-vk").attr("onclick","feedSetter('setSocialFilter','0','vk')");
                                $(".social-button-vk").addClass("top-news-filter-button-act");
                                $(".social-button-vk").find("i").addClass("top-news-filter-button-i-act");
                            }

                            else  if($filter=='tw')
                            {
                                $(".social-button-tw").attr("onclick","feedSetter('setSocialFilter','0','tw')");
                                $(".social-button-tw").addClass("top-news-filter-button-act");
                                $(".social-button-tw").find("i").addClass("top-news-filter-button-i-act");
                            }
                            if($filter=='fb')
                            {
                                $(".social-button-fb").attr("onclick","feedSetter('setSocialFilter','0','fb')");
                                $(".social-button-fb").addClass("top-news-filter-button-act");
                                $(".social-button-fb").find("i").addClass("top-news-filter-button-i-act");
                            }
                        }
                    },
                    //Options to tell jQuery not to process data or worry about content-type.
                    cache: false
                });

                console.log(data);
            },
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false
        });
    }
    else
    {
        $('#posts').html('');
        $.ajax({
            url: '/functions/newsfeed.php',  //Server script to process data
            type: 'POST', //Data send type
            data: ({action: $func, value: $value}), //Data variables
            dataType: "html", //Type of recived Data
            success: function(data) {
                $.ajax({
                    url: '/news/',  //Server script to process data
                    type: 'POST', //Data send type
                    dataType: "html", //Type of recived Data
                    success: function(data) {

                        console.log("CurrentPage: ",$('#nextVKPage').val());
                        var source = $(data);
                        $('#nextVKPage').val(source.find('#nextVKPage').val());
                        var $item=source.find('#posts');

                        IzoImages(3, $item);
                        flag=true;
                        console.log("LoadedPage: ",source.find('#nextVKPage').val());
                    },
                    //Options to tell jQuery not to process data or worry about content-type.
                    cache: false
                });

                console.log(data);
            },
            //Options to tell jQuery not to process data or worry about content-type.
            cache: false
        });
    }
}

$(".grid-button-w").on("click", function(e) {  // See here, i have our selector set to "li", so this jQuery object will grab all li tags on the page
    $(".grid-button-w").removeClass("top-news-filter-button-act");
    $(".grid-button-i-w").removeClass("top-news-filter-button-i-act");
    $(this).addClass("top-news-filter-button-act");
    $(this).find("i").addClass("top-news-filter-button-i-act");
});

$(".resolution-vk-button").on("click", function(e) {  // See here, i have our selector set to "li", so this jQuery object will grab all li tags on the page
    $(".resolution-vk-button").removeClass("top-news-filter-button-act");
    $(".resolution-vk-i-button").removeClass("top-news-filter-button-i-act");
    $(".resolution-vk-button").removeClass("top-news-filter-button-act-first-ungroup");
    $(this).addClass("top-news-filter-button-act");
    $(this).find("i").addClass("top-news-filter-button-i-act");
});



$(".top-news-hide-button").click(function () {

    // Set the effect type
    var effect = 'slide';

    // Set the options for the effect type chosen
    var options = { direction: 'left' };

    // Set the duration (default: 400 milliseconds)
    var duration = 500;

    $('#top-news-line').toggle(effect, options, duration);
});