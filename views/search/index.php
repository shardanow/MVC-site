<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 04.09.2015
 * Time: 20:33
 */

?>

<html lang="ru"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
              <div class="col-md-12 user-search-main">
                  <div class="input-group" id="adv-search">
                      <input id="searchfield" type="text" class="form-control" placeholder="Кого или что будем искать?" name="what" />
                      <div class="input-group-btn">
                          <div class="btn-group" role="group">
                              <div class="dropdown dropdown-lg">
                                  <form id="searchForm" class="form-horizontal" role="form">
                                  <button type="button" class="btn btn-default dropdown-toggle searchB" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                                          <div class="form-group">
                                              <label for="filter">Фильтр</label>
                                              <select class="form-control" name="where">
                                                  <option value="0" selected>По всему сайту</option>
                                                  <option value="1">Люди</option>
                                                  <option value="2">Музыка</option>
                                              </select>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                              <button type="button" class="btn btn-primary" onclick="searchUser()"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                          </div>
                      </div>
                  </div>
              </div>

      <div id="user-search">
          <?php foreach ($userItem as $userInfo): if(!isset($userInfo['err'])){?>
          <div class="col-md-6 col-lg-6 col-xl-6 col-sm-12 col-xs-12 user-search-block">
                <div class="user-search-block-main-info">
                    <a href="/user/<?php echo $userInfo['id'];?>"><img class="profile-top-rounded user-search-img" src="<?php echo $userInfo['ava'];?>"></a>
                    <a class="user-search-name-link" href="/user/<?php echo $userInfo['id'];?>"><h4 class="user-search-name"><?php echo $userInfo['u_name'];?> <?php echo $userInfo['u_sname'];?></h4></a>
                    <h6 class="user-search-info"><?php echo $userInfo['country'];?> <b> · <i class="fa fa-<?php echo $userInfo['genderIcon'];?> <?php echo $userInfo['genderColor'];?>"></i></b> <?php if(!empty($userInfo['zodiacName'])){echo '<b> ·</b>'.$userInfo['bdate'];?> <?php echo '('.$userInfo['zodiacName'].' '.$userInfo['zodiacIcon'].')';}?></h6>
                </div>
              <h6 class="user-search-info"><i class="fa fa-<?php echo $userInfo['u_typeIcon'];?>" style="color: <?php echo $userInfo['u_typeColor'];?>"></i> <?php echo $userInfo['u_type'];?></h6>
              <div class="btn-group user-search-buttons" role="group" aria-label="...">
                  <button data-container="body" type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="tooltip1" data-toggle="tooltip" data-placement="bottom" data-original-title="Респект"><i class="fa fa-hand-peace-o"></i></button>
                  <button data-container="body" type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="tooltip2" data-toggle="tooltip" data-placement="bottom" data-original-title="В избранное" aria-describedby="tooltip258788"><i class="fa fa-star-o"></i></button>
                  <button data-container="body" type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="tooltip3" data-toggle="tooltip" data-placement="bottom" data-original-title="Добавить в друзья"><i class="fa fa-user-plus"></i></button>
              </div>
              <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description user-search-button-b" id="tooltip4" data-toggle="tooltip" data-placement="bottom" data-original-title="Пожаловаться"><i class="fa fa-eye-slash"></i></button>
          </div>
          <?php } else {?> <h4 class="not-exist"><i class="fa fa-user-times" aria-hidden="true"></i> <?php echo $userInfo['err'];}?></h4> <?php endforeach;?>
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