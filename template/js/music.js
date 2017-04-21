/**
 * Created by Denis on 17.12.2015.
 */
jQuery(document).ready(function ($) {
    popular();

    search();
});

function search()
{
    $('#searchquery').keypress(function(e) {
        if(e.which == 13) {
            NProgress.start();

            // container to display search results
            var $results = $('#results');
            var $artist_info = $('#artist_info');

            time_update_interval = 0,
                curr='', prev='',
                song_name='', artist='',
                loop= 0;
            $artist_info.html('');
            $song_info.html('');

            // the search term
            var q = $('#searchquery').val().trim();


            // YouTube Data API base URL (JSON response)
            //https://www.googleapis.com/youtube/v3/search?part=string&order=date&q=test&type=video&videoDefinition=high&key=AIzaSyBQrj_YXyymGM27nELWkLcJfDxpwgiU1lI
            var url = "https://www.googleapis.com/youtube/v3/search?key=AIzaSyDCxria6I4PDc_wd6SdL3OplAzY_h0eScM&part=snippet&type=video&videoType=any&maxResults=50&videoCategoryId=10";


            $.ajax({
                url: 'https://ws.audioscrobbler.com/2.0/?method=artist.getinfo&autocorrect=1&api_key=a5bf72a6a02b02bad82eedf2a7044086&format=json&artist='+q,
                success: function(data) {

                    if(data.artist && data.artist.bio.summary.length>70+(data.artist.name.length))
                    {
                        var html = '<p id="artist_name" class="name">'+data.artist.name+'</p>';
                        html +='<img src="'+data.artist.image[2]['#text']+'"/>';
                        html +='<p class="about">'+data.artist.bio.summary+'</p>';
                    }
                    else
                    {

                    }

                    if(data.artist && data.artist.name.length>0)
                    {
                        $artist_info.html(html);
                        $results.show();
                    }
                    else
                    {
                        $artist_info.html("<p>No artist info</p>");
                        $results.show();
                    }
                }
            });


            $.getJSON(url + "&q=" + q, function (data) {

                var count = 0;

                if (data) {

                    var items = data.items;
                    var html = "";
                    var sem = "'";

                    items.forEach(function (item) {


                        html += '<div class="song_list_elem" id="song_list_elem' + item.id.videoId + '" data-id="' + item.id.videoId + '">';
                        // Include the YouTube Watch URL youtu.be

                        // Add the default video thumbnail (default quality)
                        html += '<img src="https://i.ytimg.com/vi/' + item.id.videoId + '/default.jpg">' +
                        '<div id="equalizer'+item.id.videoId+'" class="equalizer"></div>';

                        // Add the video title and the duration
                        html += '<p id="song_name'+item.id.videoId+'" class="song_name">' + item.snippet.title + '</p>';
                        html +='<div class="player_elements">' +
                        '<i id="play'+item.id.videoId+'" onclick="to_player('+sem+item.id.videoId+sem+');play();get_song_info()" class="fa fa-play play"></i>' +
                        '<i id="pause'+item.id.videoId+'" onclick="pause()" class="fa fa-pause pause"></i>' +
                        '<i id="loop'+item.id.videoId+'" onclick="loop_track()" class="fa fa-repeat loop"></i>'+
                        '<i id="add_s'+item.id.videoId+'" onclick="add_track()" class="fa fa-plus-square yt"></i>'+
                        '<i id="load'+item.id.videoId+'" class="fa fa-refresh fa-spin load"></i>'+
                        '<i id="done'+item.id.videoId+'" class="fa fa-check-square done"></i>'+
                        '<i id="show_yt_player'+item.id.videoId+'" onclick="show_v_player()" class="fa fa-youtube-play yt"></i>'+
                        '<i id="mute'+item.id.videoId+'" onclick="mute_player()" class="fa fa-volume-up mute"></i>'+
                        '<i id="unmute'+item.id.videoId+'" onclick="mute_player()" class="fa fa-volume-off unmute"></i>'+
                        '<input class="volume" oninput="change_volume()" onchange="change_volume()"  type="range" id="volume'+item.id.videoId+'" value="100" max="100">' +
                        '<p id="time'+item.id.videoId+'"class="time"><span id="current-time'+item.id.videoId+'">0:00</span> / <span id="duration'+item.id.videoId+'">0:00</span></p>' +
                        '<input onclick="change_time('+sem+item.id.videoId+sem+')"  type="range" id="progress-bar'+item.id.videoId+'" value="0" max="100">' +
                        '</div></div>';
                        count++;

                    });
                }

                // Did YouTube return any search results?
                if (count === 0) {
                    $results.html("No videos found");
                    NProgress.done();
                } else {
                    // Display the YouTube search results
                    $results.html(html);
                    NProgress.done();
                }
            });
        }});
}

function popular_YT_music(url)
{
    NProgress.start();
    var $results = $('#results');


    $.getJSON(url, function (data) {

        //alert("okay");

        var count = 0;

        if (data) {

            var items = data.items;
            var html = "";
            var sem = "'";

            items.forEach(function (item) {


                html += '<div class="song_list_elem" id="song_list_elem' + item.snippet.resourceId.videoId + '" data-id="' + item.snippet.resourceId.videoId + '">';
                // Include the YouTube Watch URL youtu.be

                // Add the default video thumbnail (default quality)
                html += '<img src="https://i.ytimg.com/vi/' + item.snippet.resourceId.videoId + '/default.jpg">' +
                '<div id="equalizer'+item.snippet.resourceId.videoId+'" class="equalizer"></div>';

                // Add the video title and the duration
                html += '<p id="song_name'+item.snippet.resourceId.videoId+'" class="song_name">' + item.snippet.title + '</p>';
                html +='<div class="player_elements">' +
                '<i id="play'+item.snippet.resourceId.videoId+'" onclick="to_player('+sem+item.snippet.resourceId.videoId+sem+');play();get_song_info()" class="fa fa-play play"></i>' +
                '<i id="pause'+item.snippet.resourceId.videoId+'" onclick="pause()" class="fa fa-pause pause"></i>' +
                '<i id="loop'+item.snippet.resourceId.videoId+'" onclick="loop_track()" class="fa fa-repeat loop"></i>'+
                '<i id="add_s'+item.snippet.resourceId.videoId+'" onclick="add_track()" class="fa fa-plus-square yt"></i>'+
                '<i id="load'+item.snippet.resourceId.videoId+'" class="fa fa-refresh fa-spin load" aria-hidden="true"></i>'+
                '<i id="done'+item.snippet.resourceId.videoId+'" class="fa fa-check-square done" aria-hidden="true"></i>'+
                '<i id="show_yt_player'+item.snippet.resourceId.videoId+'" onclick="show_v_player()" class="fa fa-youtube-play yt"></i>'+
                '<i id="mute'+item.snippet.resourceId.videoId+'" onclick="mute_player()" class="fa fa-volume-up mute"></i>'+
                '<i id="unmute'+item.snippet.resourceId.videoId+'" onclick="mute_player()" class="fa fa-volume-off unmute"></i>'+
                '<input class="volume" oninput="change_volume()" onchange="change_volume()"  type="range" id="volume'+item.snippet.resourceId.videoId+'" value="100" max="100">' +
                '<p id="time'+item.snippet.resourceId.videoId+'"class="time"><span id="current-time'+item.snippet.resourceId.videoId+'">0:00</span> / <span id="duration'+item.snippet.resourceId.videoId+'">0:00</span></p>' +
                '<input onclick="change_time('+sem+item.snippet.resourceId.videoId+sem+')"  type="range" id="progress-bar'+item.snippet.resourceId.videoId+'" value="0" max="100">' +
                '</div></div>';
                count++;

            });
            $results.show();
        }

        // Did YouTube return any search results?
        if (count === 0) {
            $results.html("No videos found");
            NProgress.done();
        } else {
            // Display the YouTube search results
            $results.html(html);
            NProgress.done();
        }
    });
}

function popular()
{
/*  PlaylistID to change category of top music. It's from playlist on YT music.*/

    var col=25;
    var playlistID="PLFgquLnL59alCl_2TQvOiD5Vgm1hCaGSI";
    var url="https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults="+col+"&key=AIzaSyDCxria6I4PDc_wd6SdL3OplAzY_h0eScM&playlistId=";

    popular_YT_music(url+playlistID);
}