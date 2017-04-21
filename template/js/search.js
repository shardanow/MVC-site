/**
 * Created by Denis Shardanov on 30.05.2016.
 */
function searchUser()
{
    var loaderHtml='<div class="loader"><div class="ball"></div><div class="ball"></div><div class="ball"></div><div class="ball"></div><div class="ball"></div></div>';

    $('.user-search-main').after(loaderHtml);
    $('.loader').fadeIn( "slow" );

    var form = $('#searchForm').serialize();
    var searchW=$('#searchfield').val();

    if (!searchW.replace(/\s/g, '').length || !searchW.replace(/%/g, '').length) {
        searchW="%25";
    }

    if (!searchW) {
        searchW="%25";
    }

    $.ajax({
        url: '/search/'+searchW,  //Server script to process data
        type: 'POST', //Data send type
        data: (form), // serializes the form's elements.
        dataType: "html", //Type of recived Data
        success: function(data)
        {
            history.pushState("", document.title, searchW);
            var source = $(data);

            $('.loader').fadeOut( "slow" ).remove();

            $('#user-search').html(source.find('#user-search').html());
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        },
        cache: false
    });
}

function serchSend()
{
    $('#searchfield').keydown(function (e)
    {
        if (e.keyCode == 13)
        {
            searchUser();
            $('.liveSearchBlock').fadeOut("normal");
            $('#searchfield').blur();
        }
    });
}

function searchInputSet()
{
    var href = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);
    href = decodeURIComponent(href);


    if(href!="%25" && href!="%")
    {
        $('#searchfield').val(href);
    }
}

function searchLive() {
    //setup before functions
    var typingTimer;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 5 second for example
    var $input = $('#searchfield');

//on keyup, start the countdown
    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

//on keydown, clear the countdown
    $input.on('keydown', function () {
        clearTimeout(typingTimer);
    });

//user is "finished typing," do something
    function doneTyping() {
        $('.liveSearchBlock').remove();
        var liveHtml = '<div class="liveSearchBlock"></div>';

        $('.user-search-main').after(liveHtml);
        $('.liveSearchBlock').fadeIn("slow");

        var loaderHtml = '<div class="loader"><div class="ball"></div><div class="ball"></div><div class="ball"></div><div class="ball"></div><div class="ball"></div></div>';

        $('.liveSearchBlock').html(loaderHtml);
        $('.loader').fadeIn("slow");

        var form = $('#searchForm').serialize();
        var searchW = $('#searchfield').val();

        if (!searchW.replace(/\s/g, '').length || !searchW.replace(/%/g, '').length) {
            searchW = "%25";
        }

        if (!searchW) {
            searchW = "%25";
        }

        $.ajax({
            url: '/search/' + searchW,  //Server script to process data
            type: 'POST', //Data send type
            data: (form), // serializes the form's elements.
            dataType: "html", //Type of recived Data
            success: function (data) {
                var source = $(data);

                $('.loader').fadeOut("slow").remove();

                    $('.liveSearchBlock').html(source.find('#user-search .user-search-block-main-info').get());
            },
            error: function (xhr, str) {
                alert('Возникла ошибка: ' + xhr.responseCode);
            },
            cache: false
        });
    }

    $('#searchfield').blur(function () {
        $('.liveSearchBlock').fadeOut("normal");
    }).focus(function () {
        $('.liveSearchBlock').fadeIn("normal");
    });
}
