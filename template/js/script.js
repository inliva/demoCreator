jQuery(function ($) {
    "use strict";

    var $body = $('body');
    var $image = $('#image');
    var $menu = null;
    var $window_width = $(window).width();
    var $window_height = $(window).height();
    var $previewXOffset = 10;
    var $previewYOffset = 30;
    var $setting = {};

    // Control default setting parameters
    function controlSetting(callback) {
        if (typeof $setting.menu_position == typeof undefined) {
            $setting.menu_position = {
                x: 'left',
                y: 'top',
                type: 'vertical'
            }
        }
        if (typeof $setting.title == typeof undefined || $setting.title == '') {
            $setting.menu_position = 'Grafik Demo';
        }
        callback();
    }

    $.ajax({
        url: 'setting.json',
        type: 'get',
        dataType: 'json',
        success: function (json_data) {
            $setting = json_data;

            if ($setting.images.length < 1) {
                settingErrorMessage();
            } else {
                controlSetting(function () {
                    render();
                })
            }
        },
        error: function (data) {
            settingErrorMessage();
        }
    });

    $(window).resize(function () {
        $window_width = $(window).width();
        $window_height = $(window).height();
    });

    // Start Render Page
    function render() {
        document.title = $setting.title;

        buildMenu(function (menu) {
            $body.append(menu);
            $menu = $('#menu');
            resizePositionMenu();
            registerMenuEvents(function () {
                if ($('.button', $menu).length > 1) {
                    readHash();
                } else {
                    $('.button:eq(0)', $menu).trigger('click');
                    $menu.css('display', 'none');
                }
            });
        });
    }

    // Build Menu
    function buildMenu(callback) {
        var list = '<ul id="menu" class="' + $setting.menu_position.type + '">';
        $.each($setting.images, function (i, item) {
            var no = parseInt(i) + parseInt(1);
            var src = typeof item.thumb_src == typeof undefined ? item.src : item.thumb_src;
            list += '<li><span class="button" data-id="' + i + '" data-src="' + src + '" data-name="' + item.name + '">' + no + '</span></li>';
        });
        list += '</ul>';

        callback(list);
    }

    function resizePositionMenu() {
        var cssArgs = {};
        //cssArgs['height'] = $window_height;
        cssArgs[$setting.menu_position.x] = 20;
        cssArgs[$setting.menu_position.y] = 20;
        $menu.css(cssArgs);
    }

    function registerMenuEvents(callback) {
        $('.button', $menu)
        // Hover
            .hover(function (e) {
                var $button = $(this);
                var name = $button.attr('data-name');
                var src = $button.attr('data-src');
                var c = (name != '') ? '<span>' + name + '</span>' : '';
                $body.append('<div id="preview"><img src="' + src + '" alt="Preview" />' + c + '</div>');

                var page_y = e.pageY;
                if ($setting.menu_position.y == 'bottom') {
                    page_y = parseFloat($window_height) - parseFloat(page_y);
                }

                var page_x = e.pageX;
                if ($setting.menu_position.x == 'right') {
                    page_x = parseFloat($window_width) - parseFloat(page_x);
                }

                $('#preview')
                    .css($setting.menu_position.y, (page_y - $previewXOffset) + 'px')
                    .css($setting.menu_position.x, (page_x + $previewYOffset) + 'px')
                    .fadeIn('fast');
            }, function(){
                $('#preview').remove();
            })
            // Mousemove
            .mousemove(function (e) {
                var page_y = e.pageY;
                if ($setting.menu_position.y == 'bottom') {
                    page_y = parseFloat($window_height) - parseFloat(page_y);
                }

                var page_x = e.pageX;
                if ($setting.menu_position.x == 'right') {
                    page_x = parseFloat($window_width) - parseFloat(page_x);
                }

                $('#preview')
                    .css($setting.menu_position.y, (page_y - $previewXOffset) + 'px')
                    .css($setting.menu_position.x, (page_x + $previewYOffset) + 'px');
            })
            // Click
            .click(function () {
                var $button = $(this);

                if (!$button.hasClass('active')) {
                    $('.button', $menu).removeClass('active');
                    var id = $button.attr('data-id');
                    var name = $button.attr('data-name');
                    var src = $button.attr('data-src');
                    getImageSize(src, function (image_width, image_height) {
                        var height = parseInt(image_height) / (parseInt(image_width) / parseInt(1920));
                        changeImage(id, src, height);
                    });
                    $button.addClass('active');
                    window.location.hash = id;
                }
            });

        callback();
    }

    // Set body for selected image
    function changeImage(id, image_src, height) {
        if ($image.css('background-image') == 'none') {
            $image
                .css({
                    height: height,
                    backgroundImage: 'url(' + image_src + ')'
                })
                .addClass('animated in')
        } else {
            $image
                .stop(true, true)
                .removeClass('animated in')
                .addClass('animated out');

            setTimeout(function () {
                $image
                    .stop(true, true)
                    .css({
                        height: height,
                        backgroundImage: 'url(' + image_src + ')'
                    })
                    .removeClass('animated out')
                    .addClass('animated in');
            }, 250);
        }
    }

    // Get image real sizes
    function getImageSize(src, callback) {
        $('<img/>')
            .attr('src', src)
            .load( function() {
                callback(this.width, this.height);
            });
    }

    // Read Hash and select image
    function readHash() {
        var id = 0;

        if (window.location.hash) {
            id = window.location.hash.substring(1);
        }

        if ($('.button:eq(' + id + ')').length < 1) {
            id = 0;
        }

        $('.button:eq(' + id + ')', $menu).trigger('click');
    }

    // Error message
    function settingErrorMessage() {
        alert('Demo yüklenirken hata oluştu. Lütfen bizimle iletişime geçin..');
    }

});