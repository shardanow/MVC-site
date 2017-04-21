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
                    <input type="text" placeholder="Имя" class="center-block reg_input" name="reg_fullname" required maxlength="50">
                    <input type="text" placeholder="Фамилия" class="center-block reg_input" name="reg_surname" required maxlength="50">
                    <input type="text" placeholder="Логин" class="center-block reg_input" name="reg_username" required maxlength="50">
                    <input type="text" placeholder="Пароль" class="center-block reg_input" name="reg_password" required maxlength="50">
                    <input type="text" placeholder="Повторите пароль" class="center-block reg_input" name="reg_password_confirm" required maxlength="50">
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

                    <input type="hidden" name="act" value="reg">
                </div>
            </div>
            <button type="submit" class="r_button center-block">Вперед!</button>
            <div class="back_button" id="registerBack">Вернуться назад</div>
        </div>
    </form>

    <!-- LOGIN FORM -->
    <form id="login-form">
        <div class="reg_form" id="log">
            <div class="row">
                <div class="col-lg-8 reg_content center-block log_fix">
                    <b class="logoTextS reg_form_name center-block">Вход</b>
                    <div class="login-form-main-message"></div>
                    <input type="text" placeholder="Логин" class="center-block reg_input" name="lg_username" required maxlength="50">
                    <input type="text" placeholder="Пароль" class="center-block reg_input" name="lg_password" required maxlength="50">

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
            <p>Ваша новостная лента из VK, Twitter, Instagram всегда доступна для вас прямо у нас.</p>
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
        <p class="text-muted">LinePuls © 2016</p>
</footer>

</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <script src="/template/js/main_login.js"></script>
    <script src="/template/js/login.js"></script>
</html>