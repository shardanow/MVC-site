<?php
session_start();
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

    <title>LinePuls</title>

    <!-- All the files that are required -->
    <!-- Bootstrap core CSS -->
    <link href="/template/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/template/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="/Jcrop/css/jquery.Jcrop.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0-alpha/css/bootstrap-datepicker.standalone.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 02.07.2016
 * Time: 16:10
 */

?>
<img class="center-block logo" src="/template/img/logo.png" alt=""/>
<div class="top">
    <div class="main_top">
        <p class="logoTextM">Соберем все актуальное, популярное в одном месте.<br>Сделаем доступным, простым, и приятным для пользования.<br>Мы - будущее, мы - LinePuls.<br><b class="logoTextS">Присоединяйся!</b></p>
        <div class="r_button" id="registerBegin">Регистрация</div>
        <div class="l_button" id="loginBegin">Войти</div>
    </div>

    <!-- REGISTRATION FORM -->
    <form id="register-form">
        <div class="reg_form" id="reg">
            <div class="row">
                <div class="col-lg-8 reg_content center-block">
                    <b class="logoTextS reg_form_name center-block">Регистрация</b>
                    <div class="login-form-main-message"></div>

                    <?php if( $_SESSION["step"]==0 || $_SESSION["step"]==1){?>
                    <div id="firstStep">
                        <input type="text" placeholder="Имя" class="center-block reg_input" name="reg_fullname" required maxlength="50">
                        <input type="text" placeholder="Фамилия" class="center-block reg_input" name="reg_surname" required maxlength="50">
                        <input type="text" placeholder="Логин" class="center-block reg_input" name="reg_username" required maxlength="50">
                        <input type="password" placeholder="Пароль" class="center-block reg_input" name="reg_password" required maxlength="50">
                        <input type="password" placeholder="Повторите пароль" class="center-block reg_input" name="reg_password_confirm" required maxlength="50">
                        <input type="text" placeholder="Email" class="center-block reg_input" name="reg_email" required maxlength="50">

                        <div class="col-lg-12 reg_gender_input">
                            <input id="man" type="radio" name="reg_gender" value="1" required>
                            <label for="man"><span><span></span></span>Мужчина</label>
                            <input id="woman" type="radio" name="reg_gender" value="2" required>
                            <label for="woman"><span><span></span></span>Женщина</label>
                        </div>

                        <div class="col-lg-12 reg_gender_input">
                            <input id="accept" type="checkbox" name="reg_agree" value="1" required>
                            <label for="accept" class="accept"><span><span></span></span>Я соглашаюсь с политикой сайта</label>
                        </div>

                        <p class="currentStep"><b>1</b> 2 3</p>
                    </div>
                    <input type="hidden" name="act" value="reg">
                    <?php }?>

                    <div id="secondStep">
                        <div class="user_image">
                            <img class="profile-top-rounded center-block usrImg" src="<?php if(isset($_SESSION['avaLink']) && !empty($_SESSION['avaLink'])) {echo $_SESSION['avaLink'];}else{?>/img/choosePhoto.png<?php }?>" />
                                <div class="image-upload">
                                    <label data-toggle="modal" data-target="#avaModal">
                                        <i class="fa fa-cloud-upload"></i>
                                    </label>
                                </div>
                        </div>
                        <p class="currentStep"><u>1</u> <b>2</b> 3</p>
                    </div>

                        <div id="thirdStep">
                            <div class="input-group">
                                <span class="input-group-addon row_editable">Дата рождения:</span>
                                <input type="text" id="birthday" class="form-control" value="<?php echo date("Y").'-'.date("m").'-'.date("d");?>" name="bdate" required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon row_editable">В жизни я:</span>
                                <select id="who" class="selectpicker" data-live-search="true" name="type" data-size="10">
                                    <option value="0">Не выбрано</option>
                                    <?php foreach ($uList[0] as $userType):?>
                                        <option value="<?php echo $userType['id'];?>"><?php echo $userType['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon row_editable">Моя страна:</span>
                                <select id="country" class="selectpicker" data-live-search="true" name="country" data-size="10">
                                    <option value="0">Не выбрано</option>
                                    <?php foreach ($uList[1] as $userCountry):?>
                                        <option value="<?php echo $userCountry['c_id'];?>"><?php echo $userCountry['c_name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon row_editable">Моя ориентация:</span>
                                <select id="orientation" class="selectpicker" data-live-search="true" name="orientation" data-size="10">
                                    <option value="0">Не выбрано</option>
                                    <?php foreach ($uList[2] as $userOrient):?>
                                        <option value="<?php echo $userOrient['or_id'];?>"><?php echo $userOrient['or_name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon row_editable">О себе:</span>
                                <textarea id="aboutUser" rows="10" cols="45" name="about" placeholder="Расскажите немного о себе."></textarea>
                            </div>

                            <p class="currentStep"><u>1</u> <u>2</u> <b>3</b></p>
                        </div>

                </div>
            </div>
            <button id="<?php echo$_SESSION["step"];?>" type="submit" class="r_button center-block nextStep">Вперед!</button>
            </form>
            <?php if( $_SESSION["step"]==0 || $_SESSION["step"]==1){?>
            <div class="back_button" id="registerBack">Вернуться назад</div>
            <?php }?>
        </div>


    <!-- LOGIN FORM -->
    <form id="login-form">
        <div class="reg_form" id="log">
            <div class="row">
                <div class="col-lg-8 reg_content center-block log_fix">
                    <b class="logoTextS reg_form_name center-block">Вход</b>
                    <div class="login-form-main-message"></div>
                    <input type="text" placeholder="Логин" class="center-block reg_input" name="lg_username" required maxlength="50">
                    <input type="password" placeholder="Пароль" class="center-block reg_input" name="lg_password" required maxlength="50">

                    <input type="hidden" name="act" value="login">
                </div>
            </div>
            <button type="submit" class="r_button center-block">Вперед!</button>
            <div class="back_button" id="loginBack">Вернуться назад</div>
        </div>
    </form>
</div>


<!-- MAIN PAGE INFO -->
<div class="headBack"></div>
<div class="container-fluid">
    <div class="row">
        <div id='1' class='item col-md-3 col-lg-3 col-sm-6 col-xs-12'><img class="center-block" src="/template/img/i1.png" alt=""/>
            <h4>Все под рукой</h4>
            <p>Ваша новостная лента из VK, OK, Twitter всегда доступна для вас прямо у нас.</p>
        </div>
        <div id='2' class='item col-md-3 col-lg-3 col-sm-6 col-xs-12'><img class="center-block" src="/template/img/i2.png" alt=""/>
            <h4>Понятнее некуда</h4>
            <p>Приятный на вид, актуальный и простой дизайн, специально созданный для любого пользователя.</p>
        </div>
        <div id='3' class='item col-md-3 col-lg-3 col-sm-6 col-xs-12'><img class="center-block" src="/template/img/i3.png" alt=""/>
            <h4>Интересы учтены</h4>
            <p>Наша сеть подбирает интересную Вам информацию по специальному алгоритму способному учиться вашим предпочтениям.</p>
        </div>
        <div id='4' class='item col-md-3 col-lg-3 col-sm-6 col-xs-12'><img class="center-block" src="/template/img/i4.png" alt=""/>
            <h4>Ваш стиль</h4>
            <p>Теперь Вы сами в праве выбирать как будет выглядеть ваша страница. Вы можете управлять блоками на своей личной странице.</p>
        </div>
    </div>
</div>
<footer class="footer">
    <p class="text-muted">LinePuls © 2015-<?php echo date("Y") ?></p>
</footer>

<!-- Modal -->
<div class="modal fade" id="avaModal" role="dialog" tabindex='-1' data-backdrop="static">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
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
                                                Выбрать изображение <input type="file" name="fileAva" required="" onchange="readURL(this)">
                                            </span>
                                        </span>
                        <input type="text" class="form-control" readonly="" id="filename">
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
                    <input type="hidden" value="saveAva" name="act">
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
        </div>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0-alpha/js/bootstrap-datepicker.min.js"></script>
<script src="/template/js/bootstrap.min.js"></script>
<script src="/Jcrop/js/jquery.Jcrop.min.js"></script>
<script src="/template/js/main_login.js"></script>
<script src="/template/js/login.js"></script>
<script src="/template/js/avaUpload.js"></script>
<link rel="stylesheet" href="/font-awesome-4.6.3/css/font-awesome.min.css">
<?php if(!isset($_SESSION['step']) && empty($_SESSION['step']))
{
    $_SESSION["step"]=0;
}
else
{
    echo '<script>nextStep('.$_SESSION["step"].')</script>';
};?>
</html>