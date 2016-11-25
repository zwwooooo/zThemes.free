// jQuery.noConflict();
// var $ = jQuery.noConflict();
(function ($, window) {

	//----------------------------------------------- 全局变量
	//// opera fix 这行是 Opera 的补丁
	zdo_jQbody = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

	//// 判断是否移动设备
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

	//----------------------------------------------- js/jq函数
	//// zwooooo - loading效果
	$.fn.zdo_loading = function(cc){
		var i=0,
			zlhtml='<span>l</span><span>o</span><span>a</span><span>d</span><span>i</span><span>n</span><span>g</span><span>...</span>',
			$this=$(this),
			$thisid=$(this).attr('id');
		$this.html(zlhtml);
		cc=cc?cc:'#fff';
		(function zl(){
			if(zdo_loading==0)
				i>7 ? ( i=0, $this.html(zlhtml), setTimeout(zl,50) ) : ( $('#'+$thisid+' span').eq(i).css({color:cc}), i++, setTimeout(zl,50) );
		})();
	};

	//----------------------------------------------- jQ 效果函数组
	var zdo_modules_G = {};

	//// 菜单相关 + 头部一些处理
	zdo_modules_G.Header = function() {
		//mobile navi
		$('#site-navi-mobile, #mml-close').on('click', function(){
			$('body').toggleClass('mobile-show');
		});

	};

	//// 滚动
	zdo_modules_G.Scroll = function(){
		
		$('#scroll').click(function(e){
			e.preventDefault();
			zdo_jQbody.animate({ scrollTop: 0 }, 800);
		});
		
	};

	//// TAG Cloud里面显示“每标签的文章数” by zwwooooo
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

	//// guest comments
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
	// 囧效果
	zdo_modules_G.Other = function(){
		$(window).on('load', function () {
			$('.progressbar i').css('left', '100%');

			if ( $('body').hasClass('jiong') ) {
				var clone_num = 8,
						time_tr = 600,
						time_change = 3600,
						time_clone = 7200,
						time_standy = 7200,
						s_go = '150%',
						b_where = '-100%';

				setTimeout(function(){
					$('.progressbar i').remove();

					//initialize
					//short
					var fc_l = '';
					for (var i = clone_num; i >= 0; i--) {
						fc_l = Math.ceil(Math.random()*2)==1 ? '-300%' : '200%';
						$('.progressbar').append('<i class="hide" style="left:'+ fc_l +';width:2px;border-radius:2px;background-color:#49629e;"></i>');
					};
					//long
					$('.progressbar').append('<i class="long" style="left:105%;width:100%;background-color:#b91f1f;"></i>');

					$('.progressbar i.hide:first').addClass('s3600 show').removeClass('hide');

					var fcc_l = '0',
							fcc_w = '0';
					var func_css_change = function(){
						$('.progressbar i.show').each(function(){
							fcc_l = Math.ceil(Math.random()*100) +'%';
							fcc_w = Math.ceil(Math.random()*50) +'px';
							$(this).css({'left':fcc_l, 'width':fcc_w});
						});
					};
					var int1 = setInterval(func_css_change, time_change);
					
					var func_clone = function() {
						if ( $('.progressbar i.hide').length ) {
							$('.progressbar i.hide:first').addClass('s3600 show').removeClass('hide');
						} else {
							window.clearInterval(int2);
							if ( Math.ceil(Math.random()*2) == 1 ) {
								s_go = '-150%', b_where = '105%', s_go_return = '-105%';
							} else {
								s_go = '150%', b_where = '-105%', s_go_return = '105%';
							};
							setTimeout(function(){
								$('.progressbar i.long').css({'left':b_where});

								$('.progressbar i.show').removeClass('s3600').addClass('s600').css({'left':s_go});
								window.clearInterval(int1);
								setTimeout(function(){
									$('.progressbar i.show').removeClass('show s600').addClass('hide');
									setTimeout(function(){
										$('.progressbar i.long').addClass('s600').css({'left':s_go});
										setTimeout(function(){
											//initialize
											$('.progressbar i.hide').each(function(){
												fc_l = Math.ceil(Math.random()*2)==1 ? '-300%' : '200%';
												$(this).css({'width':'10px','left':fc_l});
											});
											$('.progressbar i.long').removeClass('s600').css({'left':s_go_return});
											int1 = setInterval(func_css_change, time_change);
											int2 = setInterval(func_clone, time_clone);
										}, time_tr);
									}, time_tr);
								}, time_tr);
							}, time_standy);
						};
					};
					var int2 = setInterval(func_clone, time_clone);
				}, 1000);
			}
		});
	};

	$(function() {
		zdo_modules_G.Header();
		zdo_modules_G.Scroll();
		zdo_modules_G.Tags();
		zdo_modules_G.guest_comments();
		zdo_modules_G.Other();
	});

})(jQuery, window);