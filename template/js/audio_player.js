var player,
    time_update_interval = 0,
    curr='', prev='',
    song_name='', artist='',
    loop= 0;

var $song_info = $('#song_info');



        function onYouTubeIframeAPIReady() {
            yt_song_player();
        }


// YT player parameters

function yt_song_player()
{
    player = new YT.Player('player', {
        width: 200,
        height: 100,
        videoId: 'cmSbXsFE3l8',
        playerVars: {
            color: 'white'
        },
        events: {
            onReady: initialize,
            onStateChange:
                function(e){
                    if(loop==1)
                    {
                        if (e.data === YT.PlayerState.ENDED)
                        {
                            player.playVideo();
                        }
                    }
                    else
                    {
                        if (e.data === YT.PlayerState.ENDED)
                        {
                            play_next();
                        }
                    }
                }
        }
    });
}

function play_next()
{
    var next=$('#song_list_elem'+curr).next().data("id");
    //alert(next);
    to_player(next);
    play();
    get_song_info();
}

function play_prev()
{
    var next=$('#song_list_elem'+curr).prev().data("id");
    //alert(next);
    to_player(next);
    play();
    get_song_info();
}

function initialize(){


    // Update the controls on load
    updateTimerDisplay();
    updateProgressBar();

    // Clear any old interval.
    clearInterval(time_update_interval);

    // Start interval to update elapsed time display and
    // the elapsed part of the progress bar every second.
    time_update_interval = setInterval(function () {
        updateTimerDisplay();
        updateProgressBar();
    }, 1000);


    $('#volume'+curr).val(Math.round(player.getVolume()));

}


// This function is called by initialize()
function updateTimerDisplay(){
    // Update current time text display.
    $('#current-time'+curr).text(formatTime( player.getCurrentTime() ));
    $('#duration'+curr).text(formatTime( player.getDuration() ));
}


// This function is called by initialize()
function updateProgressBar(){
    // Update the value of our progress bar accordingly.
    if(player.getCurrentTime()>0)
    {
        $('#progress-bar'+curr).val((player.getCurrentTime() / player.getDuration()) * 100);
    }
}


// Progress bar

function change_time(e)
{
    var newTime = player.getDuration() * ($('#progress-bar'+e).val() / 100);

    // Skip video to new time.
    player.seekTo(newTime);
}


// Loop func

function loop_track()
{
    var loop_b = $('#loop'+curr);

    if(loop_b.hasClass("pressed"))
    {
        loop_b.removeClass('pressed');
        loop=0;
    }
    else
    {
        loop_b.addClass('pressed');
        loop=1;
    }
}

function loop_m_track()
{
    var loop_b = $('.player_block_rp');

    if(loop_b.hasClass("pressed"))
    {
        loop_b.removeClass('pressed');
        loop=0;
    }
    else
    {
        loop_b.addClass('pressed');
        loop=1;
    }
}


function clone()
{
    var clone = $('#results').html();
    $('.playlist_m').html(clone);
}

// Playback

function play()
{
    clone();
    // Google Music Equalizer animation
    var pathname = window.location.pathname;
    if(pathname.indexOf('music') > -1) {
        (function () {
            var animation = document.querySelector('.equalizer');

            function onAnimation(evt) {
                evt.stopPropagation();
            }

            animation.addEventListener('webkitAnimationStart', onAnimation, false);
            animation.addEventListener('webkitAnimationIteration', onAnimation, false);
            animation.addEventListener('animationStart', onAnimation, false);
            animation.addEventListener('animationIteration', onAnimation, false);
        }());
    }

    player.playVideo();
    $('#play'+curr).toggle();
    $('#pause'+curr).toggle();
    $('#time'+curr).show();
    $('#progress-bar'+curr).show();
    $('#equalizer'+curr).show();
    song_name = $('#song_name'+curr).html();
    artist = $('#artist_name').html();
    $('#song_info').show();
    if($('#unmute'+curr).is(':visible'))
    {
    }
    else
    {
        $('#mute'+curr).show();
    }
    $('#show_yt_player'+curr).show();
    $('#loop'+curr).show();
    $('#volume'+curr).show();
    $('#add_s'+curr).show();

    $('.player_block_b').show();
    $('.player_block_ps').show();
    $('.player_block_pl').hide();
    $('.player_block_nx').show();
    $('.player_block_pr').show();
    $('.player_block_rp').show();
    $('.player_block_von').show();
}

function pause()
{
    player.pauseVideo();
    $('#play'+curr).toggle();
    $('#pause'+curr).toggle();
    $('#equalizer'+curr).toggle();
    $('.player_block_ps').hide();
    $('.player_block_pl').show();
}


// Sound volume

function mute_player()
{
    var b_unmuted = $('#unmute'+curr);
    var b_muted = $('#mute'+curr);

    if(player.isMuted()){
        player.unMute();
        b_muted.toggle();
        b_unmuted.toggle();
        b_unmuted.removeClass('pressed');
    }
    else{
        player.mute();
        b_muted.toggle();
        b_unmuted.toggle();
        b_unmuted.addClass('pressed');
    }
}

function mute_m_player()
{
    var b_unmuted = $('.player_block_von');
    var b_muted = $('.player_block_voff');

    if(player.isMuted()){
        player.unMute();
        b_muted.toggle();
        b_unmuted.toggle();
        b_unmuted.removeClass('pressed');
    }
    else{
        player.mute();
        b_muted.toggle();
        b_unmuted.toggle();
        b_unmuted.addClass('pressed');
    }
}

function change_volume()
{
    player.setVolume($('#volume'+curr).val());
}


// Other options

$('#speed').on('change', function () {
    player.setPlaybackRate($(this).val());
});

$('#quality').on('change', function () {
    player.setPlaybackQuality($(this).val());
});


// Playlist

$('#next').on('click', function () {
    player.nextVideo()
});

$('#prev').on('click', function () {
    player.previousVideo()
});


// Load video

function to_player(url)
{
if(curr!=url)
    {
        clear_all();
        player.cueVideoById(url);
        curr=url;
        prev=curr;
    }
}

function clear_all()
{
    $('#current-time'+prev).text(formatTime( 0 ));
    $('#progress-bar'+prev).val(0);
    $('#time'+prev).hide();
    $('#play'+prev).show();
    $('#pause'+prev).hide();
    $('#progress-bar'+prev).hide();
    $('#equalizer'+curr).hide();
    $('#song_info').hide();
    $('#unmute'+prev).hide();
    $('#mute'+prev).hide();
    $('#show_yt_player'+prev).hide();
    $('#loop'+prev).hide();
    $('#volume'+prev).hide();
    $('#add_s'+prev).hide();
}

/*// Video player options
if (window.innerWidth <= 401) {
    $(window).resize(function () {
        show_v_player();
    });
}*/


function show_v_player() {
    var player_YT = $('#player_block'),
    YT_b = $('#show_yt_player'+curr);

    if (window.innerWidth <= 401) {
        player_YT.removeClass('active_show');

        if(player_YT.hasClass( "active_show_sm" ))
        {
            player_YT.removeClass('active_show_sm');
            YT_b.removeClass('pressed');
        }
        else
        {
            player_YT.addClass('active_show_sm');
            YT_b.addClass('pressed');
        }
    }
    else
    {
        player_YT.removeClass('active_show_sm');

        if(player_YT.hasClass( "active_show" ))
        {
            player_YT.removeClass('active_show');
            YT_b.removeClass('pressed');
        }
        else
        {
            player_YT.addClass('active_show');
            YT_b.addClass('pressed');
        }
    }
}

// Helper Functions

function formatTime(time){
    time = Math.round(time);

    var minutes = Math.floor(time / 60),
        seconds = time - minutes * 60;

    seconds = seconds < 10 ? '0' + seconds : seconds;

    return minutes + ":" + seconds;
}


$('pre code').each(function(i, block) {
    hljs.highlightBlock(block);
});

// Song information from last fm

function get_song_info() {

    // If finded artist on last fm
    if (artist) {

        song_name = song_name.replace(artist, '');
        song_name = song_name.replace('-', '');
        song_name = song_name.split('(')[0];
        song_name = song_name.split('[')[0];
        song_name = song_name.trim();
        artist = artist.trim();
        //alert(artist+song_name);

        var url_lfm_song = "https://ws.audioscrobbler.com/2.0/?method=track.getInfo&api_key=a5bf72a6a02b02bad82eedf2a7044086&autocorrect=1&format=json&track=" + song_name + "&artist=" + artist;

        $.ajax({
            url: url_lfm_song,
            success: function (data) {

                var html;
                var other_info;
                var err = data.error;

                if (!err) {
                    html = '<p class="name">' + data.track.name + '</p>';
                    other_info = data.track.wiki;
                }
                else {
                    html = '<p class="name">' + artist + " " + song_name + '</p>';
                    html += '<p class="story">No info about this track for now... (>.< )</p>';
                }


                if (!err && other_info) {
                    html += '<p class="date">' + data.track.wiki.published + '</p>' +
                    '<p class="story">' + data.track.wiki.summary + '</p>';
                }

                if (!err) {
                    $song_info.html(html);
                }
                else {
                    var string = '<p class="name">' + artist + " " + song_name + '</p> <p class="story">No track info</p>';
                    $song_info.html(string);
                }
            }

        });
    }
    else
    {
        $('#song_info').hide();
    }
}




function add_track()
{
    var track_url='https://linepuls.ru/functions/music.php?url='+curr+'&img=https://i.ytimg.com/vi/'+curr+'/default.jpg&name='+song_name+'&act=add_track';

    $('#load'+curr).show();
    $('#add_s'+curr).hide();

    $.ajax({
        url: track_url,
        success: function (data) {
            var err='<b>'+data+'</b>';

            $('#load'+curr).hide();
            $('#done'+curr).show();

            $("#song_name"+curr).append(err);

            $("#song_name"+curr+' b').fadeOut(2000, function(){ $(this).remove();});
        }

    });
}

function rem_track()
{
    var track_url='https://linepuls.ru/functions/music.php?url='+curr+'&img=https://i.ytimg.com/vi/'+curr+'/default.jpg&name='+song_name+'&act=rem_track';

    $('#load'+curr).show();
    $('#add_s'+curr).hide();

    $.ajax({
        url: track_url,
        success: function (data) {
            var err='<b>'+data+'</b>';
            var pr = curr;

            $("#song_name"+curr).append(err);
            $("#song_name"+curr+' b').fadeOut(2000, function(){play_next();$(this).remove();$("#song_list_elem"+pr).remove();});
        }

    });
}