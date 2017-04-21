<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 20:33
 */

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

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";

  ?>


  <div id="main_content" class="container-fluid">
      <div class="row">
          <h4 class="not-exist"><i class="fa fa-low-vision" aria-hidden="true"></i> Ошибка, проверьте URL! <br><img src="../img/missedURL.jpg"></h4>
          </div>
      </div>


    <footer class="footer">
      <div class="container-fluid">
        <p class="text-muted">Place sticky footer content here.</p>
      </div>
    </footer>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/bottom.html";?>

</body>
</html>