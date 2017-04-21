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

    <title><?php echo $userItem[0]['name'].' '.$userItem[0]['sname'].' '.$userItem[0]['thname']; ?></title>

    <?php include $_SERVER['DOCUMENT_ROOT']."/views/top.html";?>

  </head>

  <body>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/menu.php";?>

  <?php include $_SERVER['DOCUMENT_ROOT']."/views/playerYT.html";

  ?>



    <!-- Begin page content -->
        <div id="main_content" class="container-fluid">
        <div class="profile-top-name"><h3><?php echo $userItem[0]['name'].' '.$userItem[0]['sname'].' '.$userItem[0]['thname']; ?></h3></div>
                <div class="row">
                    <div class="profile-top" id="bg">
                            <div class="user_image center-block">
                                <?php foreach ($userItem[8] as $userAchieve): ?>
                                <div class="achieve_icon" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $userAchieve['name']?>">
                                    <svg id="achievement" height="60" width="60"
                                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" >
                                        <image x="0" y="0" height="60" width="60"  xlink:href="https://linepuls.ru/template/achievements/<?php echo $userAchieve['icon']?>.svg" />
                                    </svg>
                                </div>
                                <?php  endforeach; ?>
                                <img class="profile-top-rounded center-block" src="<?php echo $userItem[0]['ava'];?>"/>
                                <?php if($userItem[0]['id_user']==$_SESSION['uid']){?>
                                <div class="image-upload">
                                    <label data-toggle="modal" data-target="#avaModal">
                                        <i class="fa fa-cloud-upload"></i>
                                    </label>
                                </div>
                                <?php }?>
                            </div>

                            <div class="profile-top-description">
                                <h5><?php echo $userItem[0]['bdate'];?><b> &middot; <i class="fa fa-<?php echo $userItem[0]['icon'];?> <?php echo $userItem[0]['gender_type'];?>"></i> &middot;</b> <?php echo $userItem[0]['country_name'];?></h5>
                                <p><i class="fa fa-<?php echo $userItem[0]['typeIcon'];?>" style="color: <?php echo $userItem[0]['typeColor'];?>"></i> <?php echo $userItem[0]['typeName'];?></p>
                            </div>
                            <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description center-block" id="tooltip5" data-toggle="modal" data-target="#messModal" ><i class="fa fa-envelope-o"></i></button>


                        <div class="profile-top-right">
                            <div class="profile-top-rate"><h2><i class="fa fa-star-o"></i> <?php echo $userItem[0]['userPPoints'];?></h2><p>ПОПУЛЯРНОСТЬ</p></div>

                            <?php if($userItem[0]['id_user']!=$_SESSION['uid']){?>
                            <div class="btn-group" role="group" aria-label="...">
                                <button data-container="body" type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description <?php if($userItem[0]['respectUserStatus']==1){echo 'active';}?>" id="rateUser" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php if($userItem[0]['respectUserStatus']==1){echo 'Убрать респект';}else{echo 'Респект';}?>" onclick="<?php if($userItem[0]['respectUserStatus']==1){echo 'delRespect';}else{echo 'addRespect';};?>(<?php echo $userItem[0]['id_user'];?>)"><i class="fa fa-hand-peace-o"></i></button>
                                <button data-container="body" type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description <?php if($userItem[0]['favUserStatus']==1){echo 'active';}?>" id="favUser" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php if($userItem[0]['favUserStatus']==1){echo 'Убрать из избранного';}else{echo 'В избранное';}?>" onclick="<?php if($userItem[0]['favUserStatus']==1){echo 'delFavU';}else{echo 'addFavU';};?>(<?php echo $userItem[0]['id_user'];?>)"><i class="fa fa-star-o"></i></button>
                                <button data-container="body" type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description <?php if($userItem[0]['friendStatus']==1 || $userItem[0]['friendStatus']==2){echo 'active';}?>" id="addFriend" data-toggle="tooltip" data-placement="bottom" <?php if($userItem[0]['friendStatus']==0){echo "data-original-title='Предложить дружбу' onclick='sendFriendReq(".$userItem[0]['id_user'].")'><i class='fa fa-user-plus'></i>";} else if($userItem[0]['friendStatus']==1){echo "data-original-title='Отозвать заявку' onclick='delFriendReq(".$userItem[0]['id_user'].")'><i class='fa fa-user-times'></i>";}else if($userItem[0]['friendStatus']==2){echo "data-original-title='Удалить из друзей' onclick='delFriend(".$userItem[0]['id_user'].")'><i class='fa fa-user-times'></i>";}else if($userItem[0]['friendStatus']==3){echo "data-original-title='Добавить в друзья' onclick='addFriend(".$userItem[0]['id_user'].")'><i style='color: #6d929b;'class='fa fa-user-plus'></i>";} ?></button>
                            </div>
                            <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="warn" data-original-title="Пожаловаться" data-toggle="modal" data-target="#badContentModal"><i class="fa fa-eye-slash"></i></button>
                            <?php }?>
                        </div>
                    </div>

                </div>

        <div class="second-profile-part">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs " id="mytab">
                        <li class="active">
                            <a href="#info" data-toggle="tab">
                                Информация </a>
                        </li>
                        <?php if(trim($userItem[0]['about']) || trim($userItem[0]['music'])|| trim($userItem[0]['fav_comp'])|| trim($userItem[0]['film'])|| trim($userItem[0]['fav_act'])|| trim($userItem[0]['game'])|| trim($userItem[0]['fav_game'])|| trim($userItem[0]['interests'])){?>
                        <li>
                            <a href="#other" data-toggle="tab">
                                О себе </a>
                        </li>
                        <?php }?>
                        <?php if(trim($userItem[0]['vk_link']) != '' || trim($userItem[0]['tw_link']) != '' || trim($userItem[0]['inst_link']) != ''||trim($userItem[0]['email_cont']) != '' || trim($userItem[0]['mobile_cont']) != ''||trim($userItem[0]['country_name']) != '' || trim($userItem[0]['live_adr']) != '' || trim($userItem[0]['fb_link']) != ''){?>
                        <li>
                            <a href="#contacts" data-toggle="tab">
                                Контакты </a>
                        </li>
                        <?php }?>
                        <?php if(count($userItem[6])>0){?>
                        <li>
                            <a href="#friends" data-toggle="tab">
                                Друзья </a>
                        </li>
                        <?php }?>
                    </ul>
                    <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12 user_info">
                    <div class="tab-content" id="tabs">
                        <div class="tab-pane active" id="info">
                            <?php if(trim($userItem[0]['workName']) != '' || trim($userItem[0]['studName']) != '' ||  trim($userItem[0]['religion']) != ''){?>
                            <div class="col-md-6">
                                <?php if(trim($userItem[0]['workName']) != ''){?>
                                <p>
                                    <b>Карьера:</b>
                                    <br>
                                    <b>·</b> <b class="user_info_line">Место работы:</b> <?php echo $userItem[0]['workName'];?>
                                </p>
                                <?}?>
                                <?php if(trim($userItem[0]['studName']) != ''){?>
                                <p>
                                    <b>Образование:</b>
                                    <br>
                                    <b>·</b> <b class="user_info_line">Место учебы:</b> <?php echo $userItem[0]['studName'];?>
                                </p>
                                <?}?>
                                <?php if(trim($userItem[0]['religion']) != ''){?>
                                <p>
                                    <b>Вероисповедание:</b>
                                    <br>
                                    <?php echo $userItem[0]['religion'];?>
                                </p>
                                <?}?>
                            </div>
                            <?}?>
                            <?php if(trim($userItem[0]['search']) != '' || trim($userItem[0]['social']) != ''){?>
                            <div class="col-md-6">
                                <?php if(trim($userItem[0]['search']) != ''){?>
                                <p>
                                    <b>Ищу:</b>
                                    <br>
                                    <?php echo $userItem[0]['search'];?>
                                </p>
                                <?}?>
                                <?php if(trim($userItem[0]['social']) != ''){?>
                                <p>
                                    <b>Соционический тип:</b>
                                    <br>
                                    <?php echo $userItem[0]['social'];?>
                                </p>
                                <?}?>
                            </div>
                            <?}?>
                        </div>
                        <div class="tab-pane" id="other">
                            <?php if(trim($userItem[0]['music']) != '' || trim($userItem[0]['fav_comp']) != '' ||  trim($userItem[0]['film']) != '' || trim($userItem[0]['fav_act']) != '' || trim($userItem[0]['game']) != '' || trim($userItem[0]['fav_game']) != ''){?>
                            <div class="col-md-6">
                                <?php if(trim($userItem[0]['music']) != '' || trim($userItem[0]['fav_comp']) != ''){?>
                                <p>
                                    <b>Музыка:</b>
                                    <br>
                                    <?php if(trim($userItem[0]['music']) != ''){?>
                                        <b>·</b> <b class="user_info_line">Любимый жанр:</b> <?php echo $userItem[0]['music'];}?>
                                    <?php if(trim($userItem[0]['fav_comp']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line">Любимый исполнитель:</b> <?php echo $userItem[0]['fav_comp'];}?>
                                </p>
                                <?php }?>
                                <?php if(trim($userItem[0]['film']) != '' || trim($userItem[0]['fav_act']) != ''){?>
                                <p>
                                    <b>Кино:</b>
                                    <br>
                                    <?php if(trim($userItem[0]['film']) != ''){?>
                                        <b>·</b> <b class="user_info_line">Любимый жанр:</b> <?php echo $userItem[0]['film'];}?>
                                    <?php if(trim($userItem[0]['fav_act']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line">Любимый актер:</b> <?php echo $userItem[0]['fav_act'];}?>
                                </p>
                                <?php }?>
                                <?php if(trim($userItem[0]['game']) != '' || trim($userItem[0]['fav_game']) != ''){?>
                                <p>
                                    <b>Игры:</b>
                                    <br>
                                    <?php if(trim($userItem[0]['game']) != ''){?>
                                        <b>·</b> <b class="user_info_line">Любимый жанр:</b> <?php echo $userItem[0]['game'];}?>
                                    <?php if(trim($userItem[0]['fav_game']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line">Любимая игра:</b> <?php echo $userItem[0]['fav_game'];}?>
                                </p>
                                <?php }?>
                            </div>
                            <?php }?>
                            <?php if(trim($userItem[0]['interests']) != '' || trim($userItem[0]['about']) != ''){?>
                            <div class="col-md-6">
                                <?php if(trim($userItem[0]['interests']) != ''){?>
                                <p>
                                    <b>Интересы:</b>
                                    <br>
                                    <?php echo $userItem[0]['interests'];?>
                                </p>
                                <?}?>
                                <?php if(trim($userItem[0]['about']) != ''){?>
                                <p>
                                        <b>О себе:</b>
                                        <br>
                                        <?php echo $userItem[0]['about'];?>
                                </p>
                                <?}?>
                            </div>
                            <?}?>
                        </div>
                        <div class="tab-pane" id="contacts">
                            <?php if(trim($userItem[0]['vk_link']) != '' || trim($userItem[0]['tw_link']) != '' || trim($userItem[0]['inst_link']) != ''|| trim($userItem[0]['fb_link']) != ''){?>
                            <div class="col-md-6">
                                <p>
                                    <b>Социальные сети:</b>
                                    <?php if(trim($userItem[0]['vk_link']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-vk" aria-hidden="true"></i> VK:</b> <a target="_blank" href="<?php echo $userItem[0]['vk_link'];?>"></b><?php echo $userItem[0]['vk_link']; }?></a>
                                    <?php if(trim($userItem[0]['tw_link']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-twitter" aria-hidden="true"></i> Twitter:</b> <a target="_blank" href="<?php echo $userItem[0]['tw_link'];?>"><?php echo $userItem[0]['tw_link']; }?></a>
                                    <?php if(trim($userItem[0]['inst_link']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-instagram user_con_inst_fix" aria-hidden="true"></i> Instagram:</b> <a target="_blank" href="<?php echo $userItem[0]['inst_link'];?>"><?php echo $userItem[0]['inst_link']; }?></a>
                                    <?php if(trim($userItem[0]['fb_link']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-facebook-official user_con_inst_fix" aria-hidden="true"></i> Facebook:</b> <a target="_blank" href="<?php echo $userItem[0]['fb_link'];?>"><?php echo $userItem[0]['fb_link']; }?></a>
                                </p>
                            </div>
                            <?php }?>
                            <?php if(trim($userItem[0]['email_cont']) != '' || trim($userItem[0]['mobile_cont']) != ''|| trim($userItem[0]['country_name']) != '' || trim($userItem[0]['live_adr']) != ''){?>
                            <div class="col-md-6">
                                <?php if(trim($userItem[0]['email_cont']) != '' || trim($userItem[0]['mobile_cont']) != ''){?>
                                <p>
                                    <b>Связь:</b>
                                    <?php if(trim($userItem[0]['email_cont']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-envelope" aria-hidden="true"></i> Email:</b> <?php echo $userItem[0]['email_cont'];}?>
                                    <?php if(trim($userItem[0]['mobile_cont']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-mobile user_con_m_fix" aria-hidden="true"></i> Mobile:</b> <?php echo $userItem[0]['mobile_cont'];}?>
                                </p>
                                <?php }?>
                                <?php if(trim($userItem[0]['country_name']) != '' || trim($userItem[0]['live_adr']) != ''){?>
                                <p>
                                    <b>Место проживания:</b>
                                    <?php if(trim($userItem[0]['country_name']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-globe" aria-hidden="true"></i> Страна:</b> <?php echo $userItem[0]['country_name'];}?>
                                    <?php if(trim($userItem[0]['live_adr']) != ''){?>
                                    <br><b>·</b> <b class="user_info_line"><i class="fa fa-map-marker user_con_mark_fix" aria-hidden="true"></i> Адрес:</b> <?php echo $userItem[0]['live_adr'];}?>
                                </p>
                                <?php }?>
                            </div>
                            <?php }?>
                        </div>
                        <div class="tab-pane" id="friends">
                            <div class="col-md-12">
                                <?php foreach ($userItem[6] as $userFriends):{?>
                                    <a target="_blank" href="/user/<?php echo $userFriends['login'];?>" style="margin: 0 10px 0 0;"><img class="profile-top-rounded" src="<?php echo $userFriends['ava'];?>" style="margin: 0 0 10px 0; height: 70px;" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo $userFriends['name'].' '.$userFriends['sname'];?>"></a>
                                <?php } endforeach; ?>
                            </div>
                        </div>
                    </div>
                        </div>
                </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>Онлайн</td>
                    <td class="text-left"><?php echo $userItem[0]['last_login'];?></td>
                </tr>
                <tr>
                    <td>Семейное положение</td>
                    <td class="text-left"><?php echo $userItem[0]['rel_name'];?></td>
                </tr>
                <tr>
                    <td>Знак зодиака</td>
                    <td class="text-left"><?php echo $userItem[0]['zodiacName'].' '.$userItem[0]['zodiacIcon'];?></td>
                </tr>
                <tr>
                    <td>Дата рождения</td>
                    <td class="text-left"><?php echo $userItem[0]['birthday'];?></td>
                </tr>
                <tr>
                    <td>Ориентация</td>
                    <td class="text-left"><?php echo $userItem[0]['or_name'];?></td>
                </tr>
                <tr>
                    <td>Вредные привычки</td>
                    <td class="text-left"><?php echo $userItem[0]['hab_name'];?></td>
                </tr>
                <tr>
                    <td>Предпочтения</td>
                    <td class="text-left"><?php echo $userItem[0]['pre_name'];?></td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="user_blog_new">

                <div class="blogHolder" id="textarea" contenteditable="true" placeholder="Текст записи..." data-id="<?php echo $userItem[0]['id_user'];?>"></div>
                <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description btn-profile-blog-send" data-toggle="tooltip" data-placement="bottom" data-original-title="Отправить" onclick="sendPost()"><i class="fa fa-paper-plane"></i></button>
                <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description btn-profile-blog-send-attach btn-img-fix" data-toggle="modal" data-target="#pictureModal" data-tooltip="tooltip" data-placement="bottom" data-original-title="Изображение"><i class="fa fa-picture-o"></i></button>
                <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description btn-profile-blog-send-attach" data-toggle="modal" data-target="#songModal" data-tooltip="tooltip" data-placement="bottom" data-original-title="Аудио"><i class="fa fa-music"></i></button>


                <div id="imageContainterPost">
                    <?php foreach ($userItem[3] as $userBlogDraftImg): if(isset($userBlogDraftImg['id_user_draft'])&&$userItem[0]['id_user']==$userBlogDraftImg['id_user_draft']){?>
                    <div class='imageContainerAttachment' data-id="<?php echo $userBlogDraftImg['draft_id'];?>"><img src="<?php echo $userBlogDraftImg['draft_link'];?>"/><i class='fa fa-minus-circle delete'></i></div> <?php } endforeach; ?>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="pictureModal" role="dialog" tabindex='-1'>
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Прикрепить изображение</h4>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <input id="img_url" type="text" class="form-control" placeholder="Вставь URL изображения" required="true">
                                  <span class="input-group-btn">
                                    <button class="btn btn-secondary btn-info" type="button" onclick="url_image_add()">Прикрепить</button>
                                  </span>
                                </div>
                                    <br>
                                <form enctype="multipart/form-data">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                Добавить изображения <input type="file"  name="file[]" multiple>
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                         <span class="input-group-btn">
                                             <button class="btn btn-secondary btn-info" type="button" onclick="sendImgPost()">Прикрепить</button>
                                         </span>
                                    </div>
                                </form>
                                <progress id="imgDraftUpl"></progress>
                                <div id="imageContainter" class="img-responsive"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="songModal" role="dialog" tabindex='-1'>
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Прикрепить песню</h4>
                            </div>
                            <div class="modal-body">
                                <p>In progress....</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="avaModal" role="dialog" tabindex='-1' data-backdrop="static">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Загрузить аватар</h4>
                            </div>
                            <div class="modal-body">
                                <form enctype="multipart/form-data" id="userAvaForm" method="post">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                Выбрать изображение <input type="file" name="fileAva" required onchange="readURL(this)">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly id="filename">
                                         <span class="input-group-btn">
                                             <button class="btn btn-secondary btn-info" type="button" onclick="uploadAva()">Отправить</button>
                                         </span>
                                    </div>
                                    <input type="hidden" id="x" name="x">
                                    <input type="hidden" id="y" name="y">
                                    <input type="hidden" id="w" name="w">
                                    <input type="hidden" id="h" name="h">
                                    <input type="hidden" id="h_src" name="h_src">
                                    <input type="hidden" id="w_src" name="w_src">
                                    <input type="hidden" value="saveAva" name="action">
                                </form>
                                <p class="helper">Выберите изображение, после чего выделите часть которая будет установлена на ваш аватар и нажмите на кнопку "Отправить".</p>
                                <progress id="imgDraftUpl" class="avaProgress"></progress>
                                <div id="imageContainter" class="img-responsive imageContainterAva"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="messModal" role="dialog" tabindex='-1'>
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Новое сообщение</h4>
                            </div>
                            <div class="modal-body">
                                <div class="send-wrap ">
                                    <div class="messHolder" id="textarea" contenteditable="true" placeholder="Текст сообщения..." data-id="<?php echo $userItem[0]['id_user'];?>" style="height: 200px;"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-profile-blog-send" style="float: left;color: white;" onclick="sendMessToUser()"><i class="fa fa-paper-plane"></i> Отправить</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="badContentModal" role="dialog" tabindex='-1'>
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Жалоба</h4>
                            </div>
                            <div class="modal-body">
                                <div class="send-wrap ">
                                    <div class="messHolder" id="textarea" contenteditable="true" placeholder="Текст жалобы..." data-id="<?php echo $userItem[0]['id_user'];?>" style="height: 200px;"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-profile-blog-send" style="float: left;color: white;" onclick="sendBadPost()"><i class="fa fa-paper-plane"></i> Отправить</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="user_blog" id="user_blog">

                <?php foreach ($userItem[1] as $userBlogPost):?>
                    <div class="col-lg-12 col-md-12 col-xs-12 post_blog_text" id="post-<?php echo $userBlogPost['id_post'];?>">
                        <a href="/user/<?php echo  $userBlogPost['login'];?>/"><img class="post_blog_u_img" src="<?php echo $userBlogPost['ava'];?>" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php echo $userBlogPost['u_name'].' '.$userBlogPost['u_sname'];?>"></a>
                        <?php if($userBlogPost['login']==$_SESSION['login'] || $userItem[0]['login']==$_SESSION['login']){?>
                        <button type="button" data-container="body" class="btn btn-default btn-u btn-profile-top btn-profile-top-description del_btn" id="g_post" data-toggle="tooltip" data-placement="bottom" data-original-title="Удалить" onclick="deletePost('<?php echo $userBlogPost['id_post'];?>')"><i class="fa fa-trash-o"></i></i></button>
                        <?php }?><p><?php echo $userBlogPost['full_content'];?></p>
                    <?php foreach ($userItem[2] as $userBlogPostImg): if($userBlogPost['id_post']==$userBlogPostImg['id_post']){?>
                        <a href="<?php echo $userBlogPostImg['link'];?>" data-gallery><img class="img-responsive" src="<?php echo $userBlogPostImg['link'];?>"></a>
                        <?php } endforeach; ?>
                        <div class="post_blog_bottom">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" data-container="body" id="g_post-<?php echo $userBlogPost['id_post'];?>" class="btn btn-default btn-u btn-profile-top btn-profile-top-description pop <?php if($userBlogPost['col_like']>0){?>popovered<?php foreach ($userItem[4] as $userBlogLikeCurr): if($userBlogLikeCurr['post']==$userBlogPost['id_post']&&$userBlogLikeCurr['login']==$_SESSION['login']){echo ' active';} endforeach;?>" data-original-title="Годным считают - <?php echo $userBlogPost['col_like'];?> чел." popover-content="<?php foreach ($userItem[4] as $userBlogLike): if($userBlogLike['post']==$userBlogPost['id_post']){?><a href='/user/<?php echo  $userBlogLike['login'];?>/'><img src='<?php echo $userBlogLike['ava'];?>' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php echo $userBlogLike['name'].' '.$userBlogLike['sname'];?>'></a><?php } endforeach;?>" <?php } else{echo '" data-toggle="tooltip" data-placement="bottom" data-original-title="Годно"';}?> onclick="likePost('<?php echo $userBlogPost['id_post'];?>')"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
                                <button type="button" data-container="body" class="btn btn-default btn-u btn-profile-top btn-profile-top-description pop <?php if($userBlogPost['col_dislike']>0){?>popovered<?php foreach ($userItem[7] as $userBlogDisLikeCurr): if($userBlogDisLikeCurr['post']==$userBlogPost['id_post']&&$userBlogDisLikeCurr['login']==$_SESSION['login']){echo ' active';} endforeach;?>" id="b_post-<?php echo $userBlogPost['id_post'];?>" data-original-title="Трешем считают - <?php echo $userBlogPost['col_dislike'];?> чел." popover-content="<?php foreach ($userItem[7] as $userBlogDisLike): if($userBlogDisLike['post']==$userBlogPost['id_post']){?><a href='/user/<?php echo  $userBlogDisLike['login'];?>/'><img src='<?php echo $userBlogDisLike['ava'];?>' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php echo $userBlogDisLike['name'].' '.$userBlogDisLike['sname'];?>'></a><?php } endforeach;?>" <?php } else{echo '" data-toggle="tooltip" data-placement="bottom" data-original-title="Треш"';}?> onclick="dislikePost('<?php echo $userBlogPost['id_post'];?>')"><i class="fa fa-thumbs-o-down" aria-hidden="true"></i></button>
                                <button type="button" data-container="body" id="fav-<?php echo $userBlogPost['id_post'];?>" class="btn btn-default btn-u btn-profile-top btn-profile-top-description pop <?php if($userBlogPost['col_fav']>0){?>popovered<?php foreach ($userItem[5] as $userBlogFavCurr): if($userBlogFavCurr['post']==$userBlogPost['id_post']&&$userBlogFavCurr['login']==$_SESSION['login']){echo ' active';} endforeach;?>" data-original-title="В избранном у - <?php echo $userBlogPost['col_fav'];?> чел." popover-content="<?php foreach ($userItem[5] as $userBlogFav): if($userBlogFav['post']==$userBlogPost['id_post']){?><a href='/user/<?php echo  $userBlogFav['login'];?>/'><img src='<?php echo $userBlogFav['ava'];?>' data-toggle='tooltip' data-placement='bottom' data-original-title='<?php echo $userBlogFav['name'].' '.$userBlogFav['sname'];?>'></a><?php } endforeach;?>" <?php } else{echo '" data-toggle="tooltip" data-placement="bottom" data-original-title="Избранное"';}?> onclick="favPost('<?php echo $userBlogPost['id_post'];?>')"><i class="fa fa-star-o"></i></button>
                                <button type="button" data-container="body" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="reply" data-toggle="tooltip" data-placement="bottom" data-original-title="Репост"><i class="fa fa-reply"></i></button>
                            </div>
                            <button type="button" class="btn btn-default btn-u btn-profile-top btn-profile-top-description" id="bad_content"  data-toggle="modal" data-target="#badContentModal"  data-tooltip="tooltip" data-placement="bottom" data-original-title="Пожаловаться"><i class="fa fa-eye-slash"></i></button>
                        <p><?php echo $userBlogPost['date'];?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

                <!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                    <!-- The container for the modal slides -->
                    <div class="slides"></div>
                    <!-- Controls for the borderless lightbox -->
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                    <!-- The modal dialog, which will be used to wrap the lightbox content -->
                    <div class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"></h4>
                                </div>
                                <div class="modal-body next"></div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left prev">
                                        <i class="glyphicon glyphicon-chevron-left"></i>
                                        Previous
                                    </button>
                                    <button type="button" class="btn btn-primary next">
                                        Next
                                        <i class="glyphicon glyphicon-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
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