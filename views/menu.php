<?php include_once $_SERVER['DOCUMENT_ROOT'].'/functions/menu.php';?>

<div class="navbar navbar-inverse navbar-main" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="javascript:void(0)">
                <span class="small-nav"><span class="logo">L<b>P</b></span></span>
                <span class="full-nav"><p class="logo_full">Line<b>Puls</b></p></span>
            </a>
        </div>
        <div class="">
            <ul class="nav navbar-nav navigation-menu">
                <li class="main_page">
                    <a href="/line/" class="main_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Линия">
							<span class="fa fa-globe"></span>
						</span>
                        <span class="full-nav"> Линия </span>
                    </a>
                </li>
                <li>
                    <a href="/user/<?php echo  $_SESSION['login'];?>/" class="user_page navigation-menu" data-id="<?php echo  $_SESSION['uid'];?>">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Профиль">
							<span class="fa fa-child"></span>
						</span>
                        <span class="full-nav"> Профиль </span>
                    </a>
                </li>
                <li>
                    <a href="/messages/" class="messages_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Сообщения">
							<span class="fa fa-envelope-o">
                                <?php $countM=counter('user_messages'); if($countM){?><p id="newMessHave"></p><?php }?>
                            </span>
						</span>
                        <span class="full-nav"> Сообщения </span>
                    </a>
                </li>
                <li>
                    <a href="/news/" class="news_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Новости">
							<span class="fa fa-bullhorn"></span>
						</span>
                        <span class="full-nav"> Новости </span>
                    </a>
                </li>
                <li>
                    <a href="/music/" class="music_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Музыка">
							<span class="fa fa-music"></span>
						</span>
                        <span class="full-nav"> Музыка </span>
                    </a>
                </li>
                <li>
                    <a href="/search/" class="search_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Поиск">
							<span class="fa fa-search"></span>
						</span>
                        <span class="full-nav"> Поиск </span>
                    </a>
                </li>
                <li>
                    <a href="/settings/" class="settings_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Настройки">
							<span class="fa fa-cog"></span>
						</span>
                        <span class="full-nav"> Настройки </span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="logout()" class="exit_page navigation-menu">
						<span class="small-nav" data-toggle="tooltip" data-placement="right" title=""
                              data-original-title="Выход">
							<span class="fa fa-power-off"></span>
						</span>
                        <span class="full-nav"> Выход </span>
                    </a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>

<button type="button" class="btn btn-default btn-xs navbar-main-toggle">
    <span class="glyphicon glyphicon-chevron-right nav-open"></span>
    <span class="glyphicon glyphicon-chevron-left nav-close"></span>
</button>