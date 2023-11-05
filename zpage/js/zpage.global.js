///==============================================
// jQuery.noConflict();
// var $ = jQuery.noConflict();
(function ($, window) {


//============================================== 全局变量

//////// z \\\\\\\\ opera fix 这行是 Opera 的补丁, 少了它 Opera 是直接用跳的而且画面闪烁 by willin
zdo_jQbody = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

//////// z \\\\\\\\ get theme url
// function zfunc_themeurl(){
// 	var i=0,got=-1,url,len=document.getElementsByTagName('link').length;
// 	while(i<=len && got==-1){
// 		url=document.getElementsByTagName('link')[i].href;
// 		got=url.indexOf('/style.css');
// 		i++;
// 	}
// 	url=url.split('/style.css');
// 	return url[0];
// };
//// 改用 wp 提供的接口(在 functions.php): ajax_url.theme_url


//////// z \\\\\\\\ 判断是否移动设备
zdo_isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i) ? true : false;
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i) ? true : false;
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i) ? true : false;
	},
	any: function() {
		return (zdo_isMobile.Android() || zdo_isMobile.BlackBerry() || zdo_isMobile.iOS() || zdo_isMobile.Windows());
	}
};


//============================================== js/jq函数

//////// z \\\\\\\\ text-shadow, border-radius
/*
var css_string;

css_string = '#search,#search input#s,#search input#gs,#search input#searchsubmit,.entry p.read-more a,.entry a.more-link,#sidebar .zadsbtn a{-webkit-border-radius:6px;-moz-border-radius:6px;}';
css_string += '#naviTWO ul li.naviTWO_h,#naviTWO ul li.naviTWO_h a{-webkit-border-radius:32px;-moz-border-radius:32px;}';
css_string += '.ztheme{-webkit-border-radius:3px;-moz-border-radius:3px;}';
css_string += '.page-numbers,.tag_cloud a{-moz-border-radius:24px;-webkit-border-radius:24px;}';
css_string += '.tag_num{-moz-border-radius:0 24px 24px 0;-webkit-border-radius:0 24px 24px 0;}';
css_string += '#free,.zthemes_t span{-moz-border-radius:0 0 36px 0;-webkit-border-radius:0 0 36px 0;-moz-box-shadow:0 1px 3px #333;-webkit-box-shadow:0 1px 3px #333;}';
css_string += '#sale{-moz-border-radius:36px 0 0 0;-webkit-border-radius:36px 0 0 0;-moz-box-shadow:0 1px 3px #333;-webkit-box-shadow:0 1px 3px #333;}';
css_string += '#sidebar .zadsbtn a{-moz-box-shadow:1px 1px 3px #999;-webkit-box-shadow:1px 1px 3px #999;}';
css_string += 'body{-webkit-text-size-adjust:none;}';

css_string = 'body{-webkit-text-size-adjust:none;}';
css add to head
document.write('<style type="text\/css">' + css_string + '<\/style>');
*/


//////// z \\\\\\\\ zwooooo - loading效果
$.fn.zdo_loading = function(cc){
	var i=0,
		zlhtml='<span>z</span><span>w</span><span>w</span><span>o</span><span>o</span><span>o</span><span>o</span><span>o</span>',
		$this=$(this),
		$thisid=$(this).attr('id');
	$this.html(zlhtml);
	cc=cc?cc:'#fff';
	(function zl(){
		if(zdo_loading==0)
			i>7 ? ( i=0, $this.html(zlhtml), setTimeout(zl,50) ) : ( $('#'+$thisid+' span').eq(i).css({color:cc}), i++, setTimeout(zl,50) );
	})();
};

//////// z \\\\\\\\ jq函数: zww's Lazyload
$.fn.zdo_Lazyload = function(){
	var $thisEach=$(this);
	var checkShow=function(event) {
		var height = $(window).height() + $(document).scrollTop();
		$thisEach.each(function(){
			if($(this).offset().top < height){
				$(this).trigger('appear');
				$thisEach = $thisEach.not(this);
			}
		});
		if(0==$thisEach.length){$(window).unbind('scroll',checkShow);}
	};
	$thisEach.each(function(){
		$(this).one('appear',function(){$(this).attr('src',$(this).attr('zlazyload'));});
	});
	$(window).bind('scroll', checkShow);
	checkShow();
};



//============================================== jQ 效果函数组
var zdo_modules_G = {};

//////// z \\\\\\\\ zww's Lazyload
zdo_modules_G.zdo_Lazyload = function(){
	$('img.zlazyload').zdo_Lazyload();
	// $('#sidebar').find('.zlazyload').zdo_Lazyload();
};

//////// z \\\\\\\\ 菜单相关 + 头部一些处理
zdo_modules_G.Header = function() {
	//判断有否下拉菜单，有则加上class：has-child
	$('#site-navi').find('ul:first').children('li').each(function(){
		if( $(this).children().is('ul') ) {
			$(this).children('a:first').addClass('has-child1');
		}
	});
	$('#site-navi').find('ul:first ul li').each(function(){
		if( $(this).children().is('ul') ) {
			$(this).children('a:first').addClass('has-child2');
		}
	});

	//mobile navi
	var $mobile_button = $('#site-navi-mobile');
	$mobile_button.click(function(){
		if ( $('#mobile-menu-list').length == 0 ) {
			$.get('./?action=Ajax_mobile_menu',
				function (data) {
					$('#search').before(data);
					$('#mobile-menu-list').toggle();
					$('#mml-close').click(function(){
						$mobile_button.click();
						return false;
					});
				}
			);
		}
		$('#mobile-menu-list').toggle();
		return false;
	});

	//////// z \\\\\\\\ 搜索选择WP还是Google自定义
	// var $searchform=$('#searchform'),
	// 	s_action=$searchform.attr('action'),
	// 	s_name=$searchform.attr('name');
	// $('#gs').hover(function(){
	// 	$(this).parent().attr('action','/search').find('#s').attr('name','q');
	// },function(){
	// 	$(this).parent().attr('action','/').find('#s').attr('name',s_name);
	// });

};

//// Slides
zdo_modules_G.Slides = function(){
	var $slides = $('#info-area'),
			slides_height = $slides.find('li:first').height();
	$slides.css('height', slides_height);
	$slides.append('<div id="slide-loading" style="display:none;position:absolute;left:0;top:0;width:0;height:100%;line-height:60px;background:#fff;text-align:center;font-size:40px;color:#ccc;">zSay <span style="font-size:20px;">loading ...</span></div>');
	$('#info-arrow-left, #info-arrow-right').click(function(){

		var thisID = $(this).attr('id'),
				$slide_current = $slides.find('li.active'),
				slide_has_prev = $slide_current.prev().attr('class'),
				slide_has_next = $slide_current.next().attr('class'),
				$loading = $('#slide-loading')
		;
		if ( thisID == 'info-arrow-right' ) {
			if ( slide_has_next == undefined ) return false;
			if ( $slide_current.next().next().attr('class') == undefined ) {
				$('#info-arrow-right').addClass('none-list');
			}
			$('#info-arrow-left').removeClass('none-list');

			$loading.css({'border-left':'none', 'border-right':'10px solid #f2f2f2', 'right':'auto', 'left':'0', 'line-height':( $loading.height() )+'px'}).show().animate({'width': '100%'}, 200, function(){
				$slide_current.stop().hide().removeClass('active').next().show().addClass('active');
				var thisHeigt = $slide_current.next().height();
				if ( thisHeigt > slides_height ) $slides.animate({'height': thisHeigt},200);
				$loading.animate({'width': '0'}, 1200, function(){
					$(this).hide();
				});
			});

		} else {
			if ( slide_has_prev == undefined ) return false;
			if ( $slide_current.prev().prev().attr('class') == undefined ) {
				$('#info-arrow-left').addClass('none-list');
			}
			$('#info-arrow-right').removeClass('none-list');

			$loading.css({'border-right':'none', 'border-left':'10px solid #f2f2f2', 'left':'auto', 'right':'0', 'line-height':( $loading.height() )+'px'}).show().animate({'width': '100%'}, 200, function(){
				$slide_current.stop().hide().removeClass('active').prev().show().addClass('active');
				var thisHeigt = $slide_current.prev().height();
				if ( thisHeigt > slides_height ) $slides.css('height', thisHeigt);
				$loading.animate({'width': '0'}, 1200, function(){
					$(this).hide();
				});
			});
		}
		// alert( has_prev ); //test

		return false;
	});

	/*if ( !$('body.single-zsay').length ) {
		var zTimeI = 0;
		var ShowOneTime = function(target) {
			zTimeI++;
			if (zTimeI<=2) {
				$('#info-arrow-right').click();
			} else if (zTimeI<=4) {
				$('#info-arrow-left').click();
			} else {
				window.clearInterval;
			}
		};
		var intervalID = window.setInterval(ShowOneTime, 5000);
		$('#info-arrow-right, #info-arrow-left').hover(function(){
			window.clearInterval(intervalID);
		});
	};*/
};

////Ajax: zSay post list for home - mobile
zdo_modules_G.zsay_posts_home_mobile = function(){
	
	if ( zdo_isMobile.any() ){
		if ( $('#post-zsay-rc').length ){
			$.get('./?action=Ajax_data_zsay_posts_home_mobile',
				function (data) {
					$('#content').find('.post:first').before(data);
				}
			);
		};
	}
	
};

////滚动
zdo_modules_G.Scroll = function(){
	
	var $scroll_a=$('#scroll');
	$scroll_a.click(function(){
		var thisHref = $(this).attr('href');
		zdo_jQbody.animate({ scrollTop: $(thisHref).offset().top }, 800);
		return false;
	});
	
};

//////// z \\\\\\\\ AD
zdo_modules_G.AD = function(){

	if ( !zdo_isMobile.any() ) { //only no mobile
		$(window).load(function(){

			//从functions.php获取数据
			if( $('#entry-single').length ){
				$.get('./?action=Ajax_data_1',
					function (data) {
						//文章页数据
							var post_AD=data.split('<!--zwwooooo-AJAX-Data-->');
							$('#entry-single p:first').before(post_AD[0]);
					}
				);
			};

		}); //window loaded.
	};

};

//////// z \\\\\\\\ TAG Cloud里面显示“每标签的文章数” by zwwooooo
zdo_modules_G.Tags = function(){
	if ($('#tags').length) { //All Tags 页面
			var $tags_a=$('#tags a');
			$tags_a.each(function(){
				var $this=$(this),
						nums=$this.attr('title').split(' ')[0],
						a=$this.html()+'<span class="tag_num">('+nums+')</span>';
				$this.html(a);
			});
	};
};

//////// z \\\\\\\\ guest comments
zdo_modules_G.guest_comments = function(){
	var $guest_comments=$('#guest_comments'),
			$guest_comments_list=$('#guest_comments_list'),
			$gc_close=$('#gc_close');
	$('#guest_comments_click').click(function(){
		var $this=$(this),
				userEmail=$this.attr('class')
		;
		$guest_comments.addClass('guest_comments_click');
		zdo_loading=0;
		if (userEmail=='click') {
			zdo_loading=1;
			$guest_comments_list.show();
			$gc_close.show();
			return false;
		}
		$gc_close.show();
		$guest_comments_list.show().html('<p id="guest_comments_loading" style="color:#999;padding:0 10px;"></p>');
		$('#guest_comments_loading').zdo_loading();
		$.get('./?action=guest_comments&gc_userEmail='+userEmail,
			function (data) {
				$this.attr('class','click');
				zdo_loading=1;
				$guest_comments_list.html(data);
			}
		);
		return false;
	});
	$gc_close.click(function(){
		$guest_comments_list.hide();
		$(this).hide();
		$guest_comments.removeClass('guest_comments_click');
		return false;
	});
};

//// Other
zdo_modules_G.Other = function(){
	// $('#rmdirs').click(function(){
	// 	$.get('./?action=Ajax_rmdirs', function (data) {
	// 		alert('目录 /var/www/zww/nginx_proxy_cache/zww.me 里的文件夹/文件已清除！');
	// 	});
	// 	return false;
	// });
};

// jQuery(document).ready(function($) { //change to use $(function() {
$(function() {
	zdo_modules_G.zdo_Lazyload();
	zdo_modules_G.Header();
	zdo_modules_G.Slides();
	zdo_modules_G.Scroll();
	zdo_modules_G.zsay_posts_home_mobile();
	zdo_modules_G.AD();
	zdo_modules_G.Tags();
	zdo_modules_G.guest_comments();
	//zdo_modules_G.Other();
});


})(jQuery, window);