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
	
	$.ajax({
		url: 'setting.json',
		type: 'get',
		dataType: 'json',
		success: function (json_data) {
			$setting = json_data;

			if ($setting.images.length < 1) {
				$settingErrorMessage();
			} else {
				render();
			}
		},
		error: function (data) {
			settingErrorMessage();
		}
	});
/*
	$(window).resize(function () {
		$window_width = $(window).width();
		$window_height = $(window).height();
	});
*/
	// Start Render Page
	function render() {
		buildMenu(function (menu) {
			$body.append(menu);
			$menu = $('#menu');
			resizeMenu();
			registerMenuEvents(function () {
				readHash();
			});
		});
	}

	// Build Menu
	function buildMenu(callback) {
		var list = '<ul id="menu">';
		$.each($setting.images, function (i, item) {
			var no = parseInt(i) + parseInt(1);
			var src = typeof item.thumb_src == typeof undefined ? item.src : item.thumb_src;
			list += '<li><span class="button" data-id="' + i + '" data-src="' + src + '" data-name="' + item.name + '">' + no + '</span></li>';
		});
		list += '</ul>';

		callback(list);
	}

	function resizeMenu() {
		$menu.css({
			'height': $window_height
		});
	}

	function registerMenuEvents(callback) {
		$('.button', $menu)
			// Hover
			.hover(function (e) {
				var $button = $(this);
				var name = $button.attr('data-name');
				var src = $button.attr('data-src');
				var c = (name != '') ? '<span>' + name + '</span>' : null;
				$body.append('<div id="preview"><img src="' + src + '" alt="Preview" />' + c + '</div>');								 
				$('#preview')
					.css('top', (e.pageY - $previewXOffset) + 'px')
					.css('left', (e.pageX + $previewYOffset) + 'px')
					.fadeIn('fast');						
		    }, function(){	
				$('#preview').remove();
		    })
		    // Mousemove
			.mousemove(function (e) {
				$('#preview')
					.css('top', (e.pageY - $previewXOffset) + 'px')
					.css('left', (e.pageX + $previewYOffset) + 'px');
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
				.addClass('animated pulse')
		} else {
			$image
				.stop(true, true)
				.removeClass('animated pulse')
				.addClass('animated bounceOut');

			setTimeout(function () {
				$image
					.stop(true, true)
					.css({
						height: height,
						backgroundImage: 'url(' + image_src + ')'
					})
					.removeClass('animated bounceOut')
					.addClass('animated pulse');
			}, 700);
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
		if(window.location.hash) {
			var id = window.location.hash.substring(1);
		} else {
			var id = 0;
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