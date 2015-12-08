<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Demo Tasarım Oluşturucu</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.css">
    <!-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css"> -->
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php require_once('cleaner.php'); ?>
<div class="container">
    <a href="https://github.com/inliva/demoCreator">
        <img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/52760788cde945287fbb584134c4cbc2bc36f904/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f77686974655f6666666666662e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png">
    </a>
    <div class="left">
        <div id="upload">
            <form action="javascript:void(0);" class="" id="dropzone">
                <span class="caption">Move files or click!</span>
            </form>
        </div>
        <div id="setting">
            <div class="form-control">
                <input type="text" name="title" placeholder="Demo Title">
            </div>
            <div class="form-control with-bg">
                <label for="">Menu Type</label>
                <span>
                    <span>Vertical</span>
                    <input type="radio" name="menu_position_type" value="vertical" checked />
                </span>
                <span>
                    <span>Horizontal</span>
                    <input type="radio" name="menu_position_type" value="horizontal" />
                </span>
            </div>
            <div class="form-control with-bg">
                <label for="">Menu Position X</label>
                <span>
                    <span>Left</span>
                    <input type="radio" name="menu_position_x" value="left" checked />
                </span>
                <span>
                    <span>Right</span>
                    <input type="radio" name="menu_position_x" value="right" />
                </span>
            </div>
            <div class="form-control with-bg">
                <label for="">Menu Position Y</label>
                <span>
                    <span>Top</span>
                    <input type="radio" name="menu_position_y" value="top" checked />
                </span>
                <span>
                    <span>Bottom</span>
                    <input type="radio" name="menu_position_y" value="bottom" />
                </span>
            </div>
            <div class="form-control">
                <button id="indir" class="button">Download</button>
            </div>
        </div>
        <div class="clear"></div>
        <div id="edit">
            <ul id="image_list"></ul>
        </div>
    </div>
    <div class="right">
        <div id="preview"></div>
    </div>
    <div class="clear"></div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>