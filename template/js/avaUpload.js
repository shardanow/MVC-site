/**
 * Created by Denis Shardanov on 21.07.2016.
 */

function progressHandlingFunction(e)
{
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
}

function uploadAva()
{
    var formData = new FormData($('#userAvaForm')[0]);

    $.ajax({
        url: '/functions/login.php',  //Server script to process data
        type: 'POST',
        dataType: "html", //Type of recived Data
        xhr: function() {  // Custom XMLHttpRequest
            $('.avaProgress').show();
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        success: function(data) {
            $('#avaModal').modal('hide');
            $('.usrImg').attr("src",$(data).html());
        },
        // Form data
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    });
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var img = document.createElement("img");

        reader.onload = function() {
            img.src = reader.result;
            img.id = "cropbox";
            $(".imageContainterAva").html(img);

            h=$('#cropbox').height()/2;
            w=h;

            x = $('#cropbox').width()/2 - w/2;
            y = $('#cropbox').height()/2 - h/2;
            x1 = x + w;
            y1 = y + h;

            $('#cropbox').Jcrop({
                aspectRatio: 1,
                onSelect: updateCoords,
                minSize: [ 100,100],
                setSelect:   [ x, y, x1, y1 ],
                addClass: 'jcrop-dark'
            });
        };

        reader.readAsDataURL(input.files[0]);

    }
}

$('input[type="file"]').change(function(e){
    var fileName = e.target.files[0].name;
    $('#filename').val(fileName);
});

function updateCoords(c)
{
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
    $('#h_src').val($('#cropbox').height());
    $('#w_src').val($('#cropbox').width());
}

function checkCoords()
{
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
}
