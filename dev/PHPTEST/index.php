<?php
/**
 * Created by PhpStorm.
 * User: Denis
 * Date: 24.02.2016
 * Time: 13:01
 */
 require_once "./functions.php";
    ?>

<!DOCTYPE html>

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Cart, Editable cart">
    <meta name="author" content="D.S.">

    <title>Test Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/custom.css" rel="stylesheet">
</head>

<body>

<div class="blog-masthead">
    <div class="container-fluid">
        <nav class="nav blog-nav">
            <a class="nav-link active" href="#">Home</a>
            <a class="nav-link" href="#">Other</a>
        </nav>
    </div>
</div>

<div class="blog-header">
    <div class="container-fluid">
        <p class="lead blog-description">An example cart.</p>
    </div>
</div>

<div class="btn-func-left-panel"><div class="btn-func-new btn-func-add" onclick="new_field()"><i class="fa fa-plus"></i></div></div>

<div id="content_container">
<form method="POST" id="form_field" action="javascript:void(null);">
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">New field</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-5">
                        <select class="form-control" id="type" name="field_type">
                            <?php list_categories();?>
                        </select>
                    </div>
                    <div class="col-lg-7">
                        <input type="text" class="form-control" id="name" placeholder="Enter description name" name="field_name"/>
                        <input type="hidden" name="add_field" value="1"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cacel_new_field()">Close</button>
                    <button type="button" class="btn btn-primary" onclick="new_field_send()">Add</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="container-fluid">

    <div class="row">

        <div class="col-sm-8 blog-main">
            <?php list_fields();?>
        </div><!-- /.main -->

        <div id="info_message" class="col-sm-4 blog-main info_message">
            message
        </div>
    </div><!-- /.row -->

</div><!-- /.container -->
</div>
<footer class="blog-footer">
    <p>Built for example <a href="#">User editable cart</a> by <a href="#">D.S.</a>.</p>
    <p>
        <a href="#">Back to top</a>
    </p>
</footer>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<link href='https://fonts.googleapis.com/css?family=Open+Sans&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"><\/script>')</script>
<script src="./js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="./js/ie10-view.js"></script>
<script src="./js/controls.js"></script>

</body></html>