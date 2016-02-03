jQuery(function($){
    Dropzone.autoDiscover = false;
    Dropzone.options.filedrop = {

    };
    try {
        var myDropzone = new Dropzone('#dropzone', {
            url: 'upload.php',
            init: function () {
                this.on('addedfile', function(file) { fileupload_flag = 1; });
                this.on('complete', function(file) { fileupload_flag = 0; });
                this.on('complete', function (file) {
                    //console.log(file);
                    /*
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        $.ajax({
                            type: 'GET',
                            url: 'paket.php',

                            success: function(msg){
                                $('#myModal').modal('show')
                            },
                        });
                    }
                    */
                });
            },

            paramName: 'file', // The name that will be used to transfer the file
            maxFilesize: 20, // MB
            acceptedFiles: 'image/jpeg,image/png',

            addRemoveLinks : false,
            dictDefaultMessage : '',
            dictResponseError: 'Dosya 20mb boyutundan büyük.',

            //change the previewTemplate to use Bootstrap progress bars
            previewTemplate: '<div class="hidden"></div>',
            success: function(file, response){
                console.log(response);
                var obj = JSON.parse(response);
                addImage(obj, function () {
                    revive();
                });
            }
        });
    } catch(e) {
        alert('Dropzone.js does not support older browsers!');
    }

    $('body').on('click','#download',function(){
        setTimeout(function(){ window.location='index.php'; }, 1000);
    });

    function addImage(image, callback) {
        var html = '<li class="image" data-src="' + image.name + '">';
        html += '<img src="' + image.path + image.name + '">';
        html += '<span class="delete">x</span>';
        html += '<div class="options">';
        html += '<input name="name" placeholder="Name" />';
        html += '</div>';
        html += '</li>';
        $('#image_list').append(html);
        callback();
    }

    function revive() {
        $('#image_list')
            .sortable({
                placeholder: "image-highlight"
            })
            .disableSelection();

        $('#image_list .image').hover(function () {
            var src = $('img', this).attr('src');
            $('#preview').html('<img src="' + src + '" />');
            $('#preview img').fadeIn('fast');
        }, function () {
            $('#preview').html('');
        });

        $('#image_list .image .delete').click(function () {
            var image_node = $(this).parent('.image');
            imageDelete(image_node, function() {
                image_node.remove();
            });
        });
    }

    function imageDelete(image_node, callback) {
        $.ajax({
            url: 'delete.php',
            type: 'post',
            data: {name: image_node.attr('data-src')},
            success: function(data) {

            },
            error:  function() {
                mesajGoster('Hata oluştu!');
            },
            complete:  function() {
                if (typeof callback != typeof undefined) {
                    callback()
                }
            }
        });
    }

    function mesajGoster(mesaj) {
        alert(mesaj);
    }

    $('#indir').click(function () {
        if ($('#image_list .image').length > 0) {
            var setting_div = $('#setting');
            var button = $(this);
            button.attr('disabled', 'disabled');
            var form_data = {
                title: $('input[name="title"]', setting_div).val(),
                menu_position: {
                    type: $('input[name="menu_position_type"]:checked', setting_div).val(),
                    x: $('input[name="menu_position_x"]:checked', setting_div).val(),
                    y: $('input[name="menu_position_y"]:checked', setting_div).val()
                },
                images: []
            };
            $('#image_list .image').each(function(i, ui) {
                form_data.images.push({
                    name: $('input[name="name"]', this).val(),
                    src: 'img/' + $(this).attr('data-src')
                });
            });

            $.ajax({
                url: 'prepare.php',
                type: 'post',
                dataType: 'json',
                data: {setting: JSON.stringify(form_data)},
                success: function(data) {
                    window.location.href = 'download.php';
                },
                error:  function() {
                    mesajGoster('Hata oluştu!');
                },
                complete:  function() {
                    button.removeAttr('disabled');
                }
            });
        } else {
            mesajGoster('Önce resim ekleyin.');
        }
    });

    $('#upload .dz-clickable .caption').click(function () {
        $('#upload .dz-clickable').trigger('click');
    });
});