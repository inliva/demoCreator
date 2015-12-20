jQuery(function ($) {
    "use strict";

    var $body = $('body');
    var $image = $('#image');
    var $menu = null;
    var $window_width = $(window).width();
    var $window_height = $(window).height();
    var $previewXOffset = 10;
    var $previewYOffset = 30;
    var $active_image_id = 0;
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

    function preloadImages(images_list, callback){
        var new_images_list = [];
        for (var i=0; i<images_list.length; i++){
            new_images_list[i] = new Image();
            new_images_list[i].src=images_list[i];
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
                    var images_list = [];
                    $.each($setting.images, function (i) {
                        images_list.push($setting.images[i].src);
                    });
                    preloadImages($setting.images, function () {
                        render();
                    });
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
                    hideMenu();
                }
                detectBrowser();
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
                var id = $button.attr('data-id');

                if (!$button.hasClass('active')) {
                    activateImageById(id);
                }
            });

        callback();
    }

    // Set body for selected image
    function activateImageById(id) {
        var image_src = $setting.images[id].src;

        getImageSize(image_src, function (image_width, image_height) {
            var height = parseInt(image_height) / (parseInt(image_width) / parseInt(1920));

            if ($image.css('background-image') == 'none') {
                $image
                    .css({
                        height: height,
                        backgroundImage: 'url(' + image_src + ')'
                    })
                    .addClass('animated in');
                propagation(id);
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
                    propagation(id);
                }, 250);
            }
        });
    }

    function propagation(id) {
        $('.button', $menu).removeClass('active');
        $('.button[data-id="' + id + '"]', $menu).addClass('active');
        $active_image_id = id;
        window.location.hash = id;
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

    $("#image").swipe( {
        swipeStatus:function(event, phase, direction, distance)
        {
            if (phase=="end") {
                if (direction == 'right') {
                    changeImageByCount(1);
                } else {
                    changeImageByCount(-1);
                }
            }
        },
        triggerOnTouchEnd: false,
        threshold: 300,
        fingers: 1
    });

    function changeImageByCount(value) {
        var min = 0;
        var max = parseInt($setting.images.length) - parseInt(1);
        var id = parseInt($active_image_id) + parseInt(value);

        if (id > max) {
            id = min;
        } else if (id < min) {
            id = max;
        }

        activateImageById(id);
    }

    // Detect Mobile
    function detectBrowser() {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            hideMenu();
        }
    }

    function hideMenu() {
        $menu.addClass('hidden');
    }

});