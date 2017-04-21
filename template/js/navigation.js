/**
 * Created by Denis on 27.10.2015.
 */

    var d = 0,st = 0, interval;

var NavigationCache = new Array();

$(document).ready(function(){
    links_prepare();
    autoUsageFunc();
});

$('.navbar-main-toggle').on('click', function(event) {
    event.preventDefault();
    $('.navbar-main').toggleClass('open');
    $('body').toggleClass('on');
});

function setPage(page) {
    $.post(page, { ajaxLoad: true }, function(data){
        var $result = $(data).filter('#main_content').html();
        var newTitle = $(data).filter('title').text();
        $('#main_content').html($result);
        document.title = newTitle;
        NavigationCache[page] = $result;
        history.pushState({page: page, type: "page"}, document.title, page);
        //st++;
        //console.log("Start: "+st);
    }).done(function() {

        $('.selectpicker').selectpicker('refresh');
        autoUsageFunc();

        //d++;
        //console.log("Done: "+d);
    })
}

function links_prepare()
{
    if (history.pushState) {
        window.onpopstate = function(event) {
            if (event.state.type.length > 0) {
                if (NavigationCache[event.state.page].length>0) {
                    $('#main_content').html(NavigationCache[event.state.page]);
                }
            }
        };

        ajax_links();
    }
}

$(window).load(function() {
    //setTimout() for 2 seconds progress stop delay
    setTimeout(function(){NProgress.done()},1000);
});

function ajax_links()
{
    $('.navigation-menu').on("click", function(){
        NProgress.start();
        var link=$(this).attr('href');
        if(link && link !== null && link !== 0 && link.indexOf("#")!=0 && link!='#')
        {
            setPage(link);
            return false;
        }
    })
}

function checkURLIMG(url) {
    return(url.match(/\.(jpeg|jpg|gif|png)$/) != null);
}

function ajax_links_content()
{
    $('#main_content a').on("click", function(){
        var link=$(this).attr('href');

        if(link && link !== null && link !== 0 && link.indexOf("#")!=0 && link!='#' && link!='javascript:void(0)' && !checkURLIMG(link))
        {
            if(isExternal(link)){
                OpenInNewTab(link);
                return false;
            }
            else
            {
                setPage(link);
                return false;
            }
        }
    })
}

var checkDomain = function(url) {
    if ( url.indexOf('//') === 0 ) { url = location.protocol + url; }
    return url.toLowerCase().replace(/([a-z])?:\/\//,'$1').split('/')[0];
};

var isExternal = function(url) {
    return ( ( url.indexOf(':') > -1 || url.indexOf('//') > -1 ) && checkDomain(location.href) !== checkDomain(url) );
};

function OpenInNewTab(url) {
    var win = window.open(url, '_blank');
    win.focus();
}

$('.nav li a').on('click', function() {
    $(this).parent().parent().find('.active').removeClass('active');
    $(this).parent().addClass('active');
});

$('[data-toggle=tab]').click(function(){
    if ($(this).parent().hasClass('active')){
        $(this).parent().parent().find('.active').removeClass('active');
        $($(this).attr("href")).toggleClass('active');
    }
});

function tooltip_post()
{
    $('.popover').remove();
    $('.tooltip').remove();

    $('body').tooltip( {selector: '[data-toggle=tooltip]'} );
    $('[data-toggle="tooltip"]').each(function() {
        $(this).tooltip({
            title : $(this).attr("data-original-title")
        })
    });

    $(':button').click(function() {
        $('[data-toggle="tooltip"]').blur();
        $('[data-tooltip="tooltip"]').blur();
    });

    $('.popovered').each(function() {
        $(this).popover({ trigger: "manual" , html: true, animation:false, content: $(this).attr("popover-content"), title: $(this).attr("popover-title"), placement: 'bottom'})
            .on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
                var _this = this;
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                    }
                }, 100);
            });
    });
}

function hide_news_panel()
{
    $('.news_right_panel_min').hide();
    $('.button-show-right').hide();
    $('.news_right_panel').hide();
}

function show_news_panel()
{
    $('.news_right_panel_min').show();
    $('.button-show-right').show();
    $('.nav-open1').hide();

    $('.button-show-right').on('click', function(event) {
        event.preventDefault();
        $('.button-show-right').toggleClass('news_right_panel_b');
        $('.news_right_panel').toggle();
        $('.news_right_panel_min').toggle();
        $('.nav-open1').toggle();
        $('.nav-close1').toggle();
    });

}

function logout()
{
    $.ajax({
        url: 'https://linepuls.ru/functions/user.php',
        type: 'POST',
        data: {action: 'logout'},
        success: function() {
                window.location.href = 'https://linepuls.ru/login';
        }
    });
}

function IzoImages(p, el)
{
    if(p==1)
    {
        $grid= $('#posts').isotope({
        itemSelector : '.item'
        });
        $grid.imagesLoaded()
            .progress( function( instance ) {
                $grid.isotope('layout');
            }).done(function(instance)
            {
                $("#post-image-block-vk img").one("load", function() {
                    if(this.naturalHeight<=50||this.naturalWidth<=50)
                    {
                        $(this).remove();
                        $grid.isotope('layout');
                    }
                }).each(function() {
                    if(this.complete) $(this).load();
                });
            });
    }
    else if(p==3)
    {
        if($grid)
        {
        $grid.isotope('destroy');
        el.imagesLoaded()
            .progress( function( instance ) {
                $('#posts').append(el);
                $grid= $('#posts').isotope({
                    itemSelector : '.item'
                });
            });
        }
        else
        {
            el.imagesLoaded()
                .progress( function( instance ) {
                    $('#posts').append(el);
                    $grid= $('#posts').isotope({
                        itemSelector : '.item'
                    });
                });
        }
    }
    else
    {
        $grid.isotope( 'insert', el );
        el.imagesLoaded()
            .progress( function( instance ) {
                $grid.isotope('layout');
            })
            .done(function(instance)
            {
                $("#post-image-block-vk img").one("load", function() {
                    if(this.naturalHeight<=50||this.naturalWidth<=50)
                    {
                        $(this).remove();
                        $grid.isotope('layout');
                    }
                }).each(function() {
                    if(this.complete) $(this).load();
                });
            });


    }
}

//Function for initialize all needed functions.
function autoUsageFunc()
{

    NavigationCache[window.location.pathname] = $('#main_content').html();
    history.pushState({page: window.location.pathname, type: "page"}, document.title, window.location.pathname);

    IzoImages(1);

    $('#birthday').datepicker({
        format: 'yyyy-mm-dd'
    });

    $('#img_url').on('paste', function () {
        var element = this;
        setTimeout(function () {
            var text = $(element).val();
            url_image(text, '')
        }, 100);
    });

    $(':file').change(function(){
        var file = this.files[0];
        var name = file.name;
        var size = file.size;
        var type = file.type;
        //Your validation
    });

    $('.blogHolder').keydown(function (e)
    {
        if (e.ctrlKey && e.keyCode == 13)
        {
            sendPost();
        }
    });

    //Searching by site
    serchSend();
    searchInputSet();
    searchLive();


    $('a[href="' + this.location.pathname + '"]').parent().addClass('active');

    popular();
    search();

    ajax_links_content();
    tooltip_post();
    $('[data-tooltip="tooltip"]').tooltip();

    usr_img_me();
    usr_img_ml();

    delete_att();
    $('#blueimp-gallery').data('useBootstrapModal', false);
    showDelBtn();

    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' шт.' : label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }

    });

    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    if($.trim($('#info').text()).length<10)
    {
        $('#info').html('<p><b>Пользователь не заполнил информацию.</b></p>');
    }

    getUserConversation();
    $body = $("body");

    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
        ajaxStop: function() { $body.removeClass("loading"); }
    });

    if($('#posts').length) {
        flag=true;
        $(window).bind('scroll', function() {
            if($(window).scrollTop() >= $('body').offset().top + $('body').outerHeight() - window.innerHeight) {
                if(flag){
                    flag=false;
                    newsNext($('#nextVKPage').val());
                }
            }
        });
    }
    else
    {
        flag=false;
    }


    var $els = $('div[class^=achieve_icon]'),
        i = 0,
        len = $els.length;


    if(len>1)
    {
        $('.achieve_icon').fadeIn();
        $els.slice(1).hide();
        setInterval(function () {
            $els.eq(i).fadeOut(function () {
                i = (i + 1) % len
                $els.eq(i).fadeIn();
            })
        }, 7000)
    }
   else
    {
        $('.achieve_icon').fadeIn();
    }

}