/**
 * Created by Denis on 25.02.2016.
 */

var pause=0;

//Make row editable and pause upd content when user press edit btn
function edit_field($name)
{
    pause=1;
    $("#"+$name).prop('disabled', false);
    $(".edit_"+$name).show();
}

//Delete field when user press delete btn from DB
function delete_field($name)
{
    $("#field_"+$name).remove();

    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: {
            'id': $name,
            'remove_field': '1'
        },
        success: function(data) {
            $('#info_message').show();
            $('#info_message').html(data);
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}

//Send edition field when user press apply btn to DB and resume updating
function apply_field($name)
{
    $("#"+$name).prop('disabled', true);
    $(".edit_"+$name).hide();
    var value = $("#"+$name).val();

    $.ajax({
        type: 'POST',
        url: 'functions.php',
        data: {
            'id': $name,
            'field_name': value,
            'edit_field': '1'
        },
        success: function(data) {
            $('#info_message').show();
            $('#info_message').html(data);
            pause=0;
        },
        error:  function(xhr, str){
            alert('Возникла ошибка: ' + xhr.responseCode);
        }
    });
}

//Send edition field when user press enter to DB and resume updating
function runScript(e, $name) {
    if (e.keyCode == 13) {
        $("#"+$name).prop('disabled', true);
        $(".edit_"+$name).hide();
        var value = $("#"+$name).val();

        $.ajax({
            type: 'POST',
            url: 'functions.php',
            data: {
                'id': $name,
                'field_name': value,
                'edit_field': '1'
            },
            success: function(data) {
                $('#info_message').show();
                $('#info_message').html(data);
                pause=0;
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });

        return false;
    }
}

//Call modal window with rows for new field and pause updating
function new_field()
{
    $("#myModal").modal('show');
    pause=1;
}

//Close modal winow and resume updating
function cacel_new_field()
{
    $("#myModal").modal('hide');
    pause=0;
}

//Send new field when user press Add btn to DB and resume updating
function new_field_send()
{
        var msg   = $('#form_field').serialize();
        $.ajax({
            type: 'POST',
            url: 'functions.php',
            data: msg,
            success: function(data) {
                $('#myModal').modal('hide');
                $('#info_message').show();
                $('#info_message').html(data);
                pause=0;
            },
            error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
}


$(function () {
    $('[data-toggle="tooltip"]').tooltip(); //generate tooltips
    do_update(); //Call start update func
});


//Updating content block function
function update()
{
    if(pause==0)
    {
        $.ajax({
            url:'index.php',
            type:'POST',
            success: function(data){
                var content = $(data).filter('#content_container').html();
                $('#content_container').html(content);
            }
        });
    }
}

var $switcher = 1;


//Interval updating content func
function do_update()
{
    if ($switcher!=0)
    {
        // Start the timer for updating
        $switcher = 0;
        $switcher = setInterval("update()", 2000);
    }
    else
    {
        $switcher = 1;
        clearInterval($switcher);
    }
}