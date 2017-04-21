<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 20:33
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>Музыка</title>

    <?php include $_SERVER['DOCUMENT_ROOT']."/views/top.html";?>

</head>

<body>


<?php include $_SERVER['DOCUMENT_ROOT']."/views/menu.php";?>

<div id="news_right_panel_full">
<div class="news_right_panel_min"><i class="fa fa-search"></i></div>
<div class="news_right_panel">
    <h5 class="news_right_panel_type">Сообщества</h5>

    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" data-src="holder.js/64x64" alt="64x64"
                     src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNGZhMzY5MzVhZiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE0ZmEzNjkzNWFmIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                     data-holder-rendered="true" style="width: 64px; height: 64px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">Название</h4>
            Сообщение из ленты (статус паблика).
        </div>
    </div>
    <h5 class="news_right_panel_type">Люди</h5>

    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" data-src="holder.js/64x64" alt="64x64"
                     src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNGZhMzY5MzVhZiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE0ZmEzNjkzNWFmIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNC41IiB5PSIzNi41Ij42NHg2NDwvdGV4dD48L2c+PC9nPjwvc3ZnPg=="
                     data-holder-rendered="true" style="width: 64px; height: 64px;">
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">Имя Фамилия</h4>
            Статус.
        </div>
    </div>
</div>
<button type="button" class="btn btn-default btn-xs  button-show-right">
    <span class="glyphicon glyphicon-chevron-right nav-open1"></span>
    <span class="glyphicon glyphicon-chevron-left nav-close1"></span>
</button>
</div>

<?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";?>

<!-- Begin page content -->
<div id="main_content" class="container-fluid">

    <a href="/music/<?php echo $_SESSION['uid']; ?>/" class="btn btn-link btn-xs navigation-menu my-music-button"><span class="glyphicon glyphicon-music"></span> Моя музыка</a>
    <a href="/music/" class="btn btn-link btn-xs navigation-menu hot-music-button"><span class="glyphicon glyphicon-fire"></span> Популярное</a>

    <div class="row">
        <input id="searchquery" placeholder="Исполнитель или название трека..."/>
        <div>
            <div id="artist_info"></div>
                <div class="col-lg-7 col-md-8 col-sm-11 col-xs-12">
                    <div id="results"></div>
                </div>
            <div class="col-lg-5 col-md-4 col-sm-11 col-xs-12">
                <div id="song_info"></div>
                <div id="act_info"></div>
            </div>
        </div>


    </div>

</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="text-muted">LinePuls &copy; 2015-<?php echo date("Y") ?></p>
    </div>
</footer>

<?php include $_SERVER['DOCUMENT_ROOT']."/views/bottom.html";?>

</body>
</html>