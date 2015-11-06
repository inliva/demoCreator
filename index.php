<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>Demo Tasarım Oluşturucu</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
</head>
<body>
<?php require_once('sil.php'); ?>
<div class="bdr_upload">
    <h1 class="text-danger center">Demo Oluşturucu</h1>
    <form action="upload.php" id="dropzone" class="dropzone">
        <div class="dz-default dz-message"><span>Dosyaları Sürükleyip Bırakın yada Tıklayın</span></div>

    </form>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Demo Oluşturma</h4>
            </div>
            <div class="modal-body">
                <p>Dosyalarınız .zip haline cevrilmiştir. Butona tıklayıp indirin.</p>
            </div>
            <div class="modal-footer">
                <a href="/index.php" class="btn btn-default">Vazgeç</a>
                <a href="/bitti.php" class="btn btn-success" id="download" target="_blank">Dosyaları İndir</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="footer">
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/dropzone.js"></script>
    <script src="assets/js/demo.js"></script>
</div>
</body>
</html>
