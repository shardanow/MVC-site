<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 20:33
 */
include_once $_SERVER['DOCUMENT_ROOT'].'/functions/user.php';
user_active();
?>

<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">

    <title>LinePuls</title>

    <?php include $_SERVER['DOCUMENT_ROOT']."/views/top.html";?>

  </head>

  <body>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/menu.php";?>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";?>

    <!-- Begin page content -->
        <div id="main_content" class="container-fluid">
                <div class="row">

                    <div class="timeline-centered">

                        <article class="timeline-entry">

                            <div class="timeline-entry-inner">

                                <div class="timeline-icon bg-success">
                                    <i class="entypo-feather"></i>
                                </div>

                                <div class="timeline-label">
                                    <h2><a href="#">Art Ramadani</a> <span>posted a status update</span></h2>
                                    <p>Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Greatly who affixed suppose but enquire compact prepare all put. Added forth chief trees but rooms think may.</p>
                                </div>
                            </div>

                        </article>


                        <article class="timeline-entry">

                            <div class="timeline-entry-inner">

                                <div class="timeline-icon bg-secondary">
                                    <i class="entypo-suitcase"></i>
                                </div>

                                <div class="timeline-label">
                                    <h2><a href="#">Job Meeting</a></h2>
                                    <p>You have a meeting at <strong>Laborator Office</strong> Today.</p>
                                </div>
                            </div>

                        </article>


                        <article class="timeline-entry">

                            <div class="timeline-entry-inner">

                                <div class="timeline-icon bg-info">
                                    <i class="entypo-location"></i>
                                </div>

                                <div class="timeline-label">
                                    <h2><a href="#">Arlind Nushi</a> <span>checked in at</span> <a href="#">Laborator</a></h2>

                                    <blockquote>Great place, feeling like in home.</blockquote>

                                 </div>
                            </div>

                        </article>


                        <article class="timeline-entry">

                            <div class="timeline-entry-inner">

                                <div class="timeline-icon bg-warning">
                                    <i class="entypo-camera"></i>
                                </div>

                                <div class="timeline-label">
                                    <h2><a href="#">Arber Nushi</a> <span>changed his</span> <a href="#">Profile Picture</a></h2>

                                    <blockquote>Pianoforte principles our unaffected not for astonished travelling are particular.</blockquote>

                                    <img src="https://themes.laborator.co/neon/assets/images/timeline-image-3.png" class="img-responsive img-rounded full-width">
                                </div>
                            </div>

                        </article>


                        <article class="timeline-entry begin">

                            <div class="timeline-entry-inner">

                                <div class="timeline-icon" style="-webkit-transform: rotate(-90deg); -moz-transform: rotate(-90deg);">
                                    <i class="entypo-flight"></i> +
                                </div>

                            </div>

                        </article>

                    </div>


                </div>
            </div>

    <footer class="footer">
      <div class="container-fluid">
        <p class="text-muted">LinePuls &copy; 2015-<?php echo date("Y") ?></p>
      </div>
    </footer>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/bottom.html";?>

</body></html>