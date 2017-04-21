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

    <title>Сообщения</title>

    <?php include $_SERVER['DOCUMENT_ROOT']."/views/top.html";?>

  </head>

  <body>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/menu.php";?>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";

  ?>



  <div id="main_content" class="container-fluid">

          <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

          <div class="container-fluid messages-container">
              <div class="row">
                  <div class="col-lg-3">
                      <div class="btn-panel btn-panel-conversation">
                          <a href="javascript:void(0)" class="btn  col-lg-6 send-message-btn " role="button"><i class="fa fa-search"></i> Поиск</a>
                          <a href="javascript:void(0)" class="btn  col-lg-6  send-message-btn pull-right" role="button"><i class="fa fa-plus"></i> Сообщение</a>
                      </div>
                  </div>

                  <div class="col-lg-offset-1 col-lg-8">
                      <div class="btn-panel btn-panel-msg">

                          <a href="javascript:void(0)" class="btn  col-lg-3  send-message-btn pull-right" role="button"><i class="fa fa-gears"></i> Настройки</a>
                      </div>
                  </div>
              </div>
              <div class="row">

                  <div class="conversation-wrap col-lg-3">
                      <?php foreach ($userItem[1] as $userInfo): if(!isset($userInfo['err'])){ ?>

                      <div class="media conversation" data-id="<?php echo $userInfo['id'];?>">
                          <a class="pull-left" href="/user/<?php echo $userInfo['id'];?>">
                              <img class="media-object" data-src="<?php echo $userInfo['ava'];?>" alt="<?php echo $userInfo['u_name'].' '.$userInfo['u_sname'];?>" style="width: 50px; height: 50px;" src="<?php echo $userInfo['ava'];?>">
                          </a>
                          <div class="media-body" data-id="<?php echo $userInfo['u_name'].' '.$userInfo['u_sname'];?>">
                              <h5 class="media-heading"><?php echo $userInfo['u_name'].' '.$userInfo['u_sname'];?></h5>
                              <?php if($userInfo['sender']==1){?><small>Ваш личный архив.<br></small><?php }?>
                              <?php if($userInfo['sender']!=1&&$userInfo['flag']==0){?><small class="haveNewMess">Есть новые сообщения!</small><?php }?>
                          </div>
                      </div>
                      <?php } else {?> <h4 class="not-exist"><i class="fa fa-user-times" aria-hidden="true"></i> <?php echo $userInfo['err'];}?></h4> <?php endforeach;?>
                  </div>



                  <div class="message-wrap col-lg-9">
                      <div class="msg-wrap">

                          <div class="alert alert-info msg-date">
                              <strong>Today</strong>
                          </div>

                          <?php foreach ($userItem[0] as $userInfo): if(!isset($userInfo['err'])){?>
                              <div class="media msg" data-id="<?php echo $userInfo['messId'];?>">
                                  <a class="pull-<?php if($userInfo['sender']==1){?>left<?php } else {?>right<?php }?>" href="/user/<?php echo $userInfo['id'];?>" target="_blank">
                                      <img class="media-object" alt="<?php echo $userInfo['u_name'].' '.$userInfo['u_sname'];?>" src="<?php echo $userInfo['ava'];?>">
                                  </a>
                                  <div class="media-body">
                                      <small class="pull-<?php if($userInfo['sender']==1){?>right<?php } else {?>left<?php }?> time"><i class="fa fa-clock-o"></i> <?php echo $userInfo['sended'];?></small>

                                      <h5 class="media-heading <?php if($userInfo['sender']==0){?>pull-right user-to<?php }?>"><?php echo $userInfo['u_name'].' '.$userInfo['u_sname'];?></h5>
                                      <small class="col-lg-12" style="<?php if($userInfo['sender']==0){?>text-align: right;<?php }?>"><?php echo $userInfo['text'];?></small>
                                  </div>
                              </div>
                          <?php } else {?> <h4 class="not-exist"><i class="fa fa-user-times" aria-hidden="true"></i> <?php echo $userInfo['err'];}?></h4> <?php endforeach;?>


                      </div>

                      <div class="send-wrap">
                          <div class="chatMessHolder" id="textarea" contenteditable="true" placeholder="Текст сообщения..." data-id=""></div>
                          <input id="sender" name="sender" type="hidden" value="<?php echo $userItem[2][0]['name'].' '.$userItem[2][0]['sname'];?>"/>
                          <input id="ava" name="ava" type="hidden" value="<?php echo $userItem[2][0]['ava'];?>"/>
                          <input id="from" name="from" type="hidden" value="<?php echo $_SESSION['uid'];?>"/>
                          <input id="to" name="to" type="hidden" value="<?php echo $userItem[2][0]['id'];?>"/>
                      </div>

                      <div class="btn-panel">
                          <a href="javascript:void(0)" class="col-lg-3 btn send-message-btn" role="button"><i class="fa fa-plus"></i> Прикрепить</a>
                          <a href="javascript:void(0)" id="sendMess" class="col-lg-4 text-right btn send-message-btn pull-right" role="button"><i class="fa fa-paper-plane"></i> Отправить</a>
                      </div>
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