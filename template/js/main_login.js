/**
 * Created by Denis Shardanov on 05.07.2016.
 */

var curStep=0;

$('#registerBegin').click(function(){
    $("#secondStep").hide();
    $("#thirdStep").hide();
    $("#firstStep").fadeIn('slow');
    $('.container-fluid').fadeOut('slow');
    $('.main_top').fadeOut('slow', function() {
    $("#reg").fadeIn('slow');
    $("body").addClass("body_fix");
    $(".headBack").addClass("headBack_fix");
    $(".text-muted").addClass("footer-text_fix");
    $(".footer").addClass("footer_fix");
});
});

$('.nextStep').click(function(event){
    curStep=parseInt(event.target.id);

    if(curStep==2)
    {
        curStep=curStep+1;
    }
    else if(curStep==3)
    {
        curStep=3;
        lastStep();
    }

    nextStep(curStep);
    $('.nextStep').attr("id",curStep);
});

function nextStep(step)
{
    if(step == 1)
    {
        $('.container-fluid').fadeOut('slow');
        $('.main_top').fadeOut('slow', function() {
            $("#firstStep").fadeIn('slow');
            $("#reg").fadeIn('slow');
            $("body").addClass("body_fix");
            $(".headBack").addClass("headBack_fix");
            $(".text-muted").addClass("footer-text_fix");
            $(".footer").addClass("footer_fix");
        });
    }
    else if(step == 2)
    {
        $(".r_button").prop("type", "button");
        $('.container-fluid').fadeOut('slow');
        $('.main_top').fadeOut('slow', function() {
            $("#firstStep").fadeOut('fast');
            $("#secondStep").fadeIn('slow');
            $("#reg").fadeIn('slow');
            $("body").addClass("body_fix");
            $(".headBack").addClass("headBack_fix");
            $(".text-muted").addClass("footer-text_fix");
            $(".footer").addClass("footer_fix");
        });

        usr_img_me();usr_img_ml();
    }
    else if(step == 3)
    {
        $(".r_button").prop("type", "button");
        $('.container-fluid').fadeOut('slow');
        $('.main_top').fadeOut('slow', function() {
            $("#secondStep").fadeOut('fast');
            $("#reg").fadeIn('slow');
            $("body").addClass("body_fix");
            $(".headBack").addClass("headBack_fix");
            $(".text-muted").addClass("footer-text_fix");
            $(".footer").addClass("footer_fix");
        });
        setTimeout(function() {
        $("#thirdStep").fadeIn('slow');
        },212);
    }
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


$('#registerBack').click(function(){

    $("#reg").fadeOut('slow', function() {
        $('.main_top').fadeIn('slow');
        $("body").removeClass("body_fix");
        $(".headBack").removeClass("headBack_fix");
        $('.container-fluid').fadeIn('slow');
        $(".text-muted").removeClass("footer-text_fix");
        $(".footer").removeClass("footer_fix");
    });
});



$('#loginBegin').click(function(){
    $('.container-fluid').fadeOut('slow');
    $('.main_top').fadeOut('slow', function() {
        $("#log").fadeIn('slow');
        $("body").addClass("body_fix");
        $(".headBack").addClass("headBack_fix");
        $(".text-muted").addClass("footer-text_fix");
        $(".footer").addClass("footer_fix");
    });
});

$('#loginBack').click(function(){

    $("#log").fadeOut('slow', function() {
        $('.main_top').fadeIn('slow');
        $("body").removeClass("body_fix");
        $(".headBack").removeClass("headBack_fix");
        $('.container-fluid').fadeIn('slow');
        $(".text-muted").removeClass("footer-text_fix");
        $(".footer").removeClass("footer_fix");
    });
});

function lastStep()
{
    var url = "https://linepuls.ru/functions/login.php"; // the script where you handle the form input.
    var bdate=$( "#birthday" ).val();
    var about=$( "#aboutUser" ).val();
    var who=$( "#who" ).val();
    var country=$( "#country" ).val();
    var orientation=$( "#orientation" ).val();


        $.ajax({
            type: "POST",
            url: url,
            data: 'birthday=' + bdate+'&about=' +about+ '&who='+who + '&orientation='+orientation+'&country='+country+'&act=lastStep',
            success: function (data) {
                $('.nextStep').hide();
                if (data == 'Ура! Теперь вы часть нас! Спасибо!') {
                    $('#register-form').find('.login-form-main-message').addClass('show success').html(data);

                    setTimeout(function () {
                        window.location.href = 'https://linepuls.ru/';
                    }, 2000);
                }
            }

        });

}
