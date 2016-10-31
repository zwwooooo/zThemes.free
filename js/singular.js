(function ($, window) {


//本js文件常用参数
var zdo_themeurl = zdo_ajax_url.theme_url;

//============================================== jq 函数

//////// z \\\\\\\\ click for reply / quote
$.fn.zdo_reply_quote = function(quote){
	//点击 reply 生成 @用户名 + 链接
	$(this).click(function(){
		var atid = '#' + $(this).parent().parent().attr("id");
		var atname = $(this).parent().parent().find('cite:first').text();
		// $('#comment').focus().attr("value",'<a href="' + atid + '">@' + atname + " </a>\n"); //新版jQuery下失效
		// $('#comment').focus().val('<a href="' + atid + '">@' + atname + " </a>\n");
		$('#comment').focus().attr('data-replyto','<a href=\'' + atid + '\'>@' + atname + "</a> ");
		// alert(atid);
	});
	//点击取消回复评论清空评论框的内容
	$('#cancel-comment-reply-link').click(function(){
		$('#comment').val('');
		$('#comment').attr('data-replyto','');
	});
	if(quote){
		//点击 quote 生成 @用户名 + 链接 + 引用
		$(quote).click(function(){
			var atid = '#' + $(this).parent().parent().attr("id");
			var atname = $(this).parent().parent().find('cite:first').text();
			// var quotecontent = $(this).parent().parent().find('.comment-content:first').html().replace(/<a.*?@.*?<\/a>/ig, "");//replace(/<a.*<\/a>/ig, "")
			var quotecontent = $(this).parent().parent().find('div.comment-content:first').text().replace(/@.*? /ig, "");//replace(/<a.*<\/a>/ig, "")
			$('#comment').focus().val("<a href=" + atid + ">@" + atname + " </a>\n" + "<blockquote>\n<strong>" + atname + ": </strong>" + quotecontent + "</blockquote>\n");
		});
	}
};



//============================================== jQ 效果函数组
var zdo_modules_S = {};

//////// z \\\\\\\\ zShowBox 图片点击放大效果 by zwwooooo
zdo_modules_S.zShowBox = function() {
	zShowBox('#content .entry');

	function zShowBox(domChunk) {
		//为每张图片链接加上 class="zshowbox"
		var zcounter=0;
		$(domChunk+' a').each(function(){
			var a_href = $(this).attr('href').toLowerCase();
			var file_type = a_href.substring(a_href.lastIndexOf('.'));
			if (file_type == '.jpeg' || file_type == '.jpg' || file_type == '.png' || file_type == '.gif' || file_type == '.bmp'){ $(this).addClass('zshowbox').attr('id','zsb-'+zcounter); zcounter++; };
		});
		$(domChunk+' a.zshowbox').click(function(){
			var current=$(this).attr('id').split(/zsb-/)[1],
					pagesize=zsb_getPageSize(),
					zsb_img_url=$(this).attr('href'),
					css_zsb_bg='z-index:9999;overflow:hidden;position:fixed;left:0;top:0;width:100%;height:100%;background-color:#000;',
					css_zshowbox_loading = 'z-index:0;position:absolute;left:50%;top:50%;margin:-50px 0 0 -50px;font-size:16px;color:#fff;',
					css_zsb='z-index:99999;position:fixed;left:50%;top:50%;min-width:180px;min-height:80px;margin-left:-90px;margin-top:-40px;',
					css_zsb_img='z-index:1;position:relative;display:none;border:6px solid rgba(119, 119, 119, .45);box-shadow:1px 1px 5px #333,-1px -1px 5px #333;-moz-box-shadow:1px 1px 5px #333,-1px -1px 5px #333;-webkit-box-shadow:1px 1px 5px #333,-1px -1px 5px #333;',
					css_zsb_p_n='display:none;cursor:pointer;position:absolute;top:50%;line-height:80px;margin:-40px 0 0 0;color:#eee;text-shadow:1px 3px 5px #000;font-size:40px;font-family:Arial,Tahoma;';
					zsb_big='position:absolute;width:160px;line-height:20px;left:50%;margin-left:-80px;bottom:-25px;text-align:center;color:#333;background:#fff;border-radius:6px;opacity:0.65;';
			if (typeof document.body.style.maxHeight === "undefined") { //if IE 6
				alert('zShowBox不支持IE6！请你们放过IE6吧，它太老了，就让它安心的去吧……');
				return false;
			} else {
				// alert('zww'); //test
				jQuery('body').append(
					'<div id="zsb_bg" style="'+css_zsb_bg+'"></div>'
				+ '<div id="zsb" style="'+css_zsb+'">'
						+ '<span id="zshowbox_loading" style="'+css_zshowbox_loading+'"></span>'
						+ '<img id="zsb_img" style="'+css_zsb_img+'" />'
						+ '<span id="zsb_prev" style="left:-30px;'+css_zsb_p_n+'">&laquo;</span>'
						+ '<span id="zsb_next" style="right:-30px;'+css_zsb_p_n+'">&raquo;</span>'
						+ '<a href="' +zsb_img_url+'" target="_blank" style="' +zsb_big+ '">新窗口查看原图</a>'
				+ '</div>'
				);
				$('#zsb_bg').fadeTo(600,0.85);
				zdo_loading=0;
				$zshowbox_loading=$('#zshowbox_loading');
				$zshowbox_loading.zdo_loading('#49629e');
				zsh_img('#zsb_img',zsb_img_url,pagesize,current,zcounter);
				$('#zsb_prev,#zsb_next').click(function(){
					if ($(this).attr('id')=='zsb_prev') current--; else current++;
					$('#zsb').find('img').remove().end().append('<img id="zsb_img" style="'+css_zsb_img+'" />');
					zsb_img_url=$('#zsb-'+current).attr('href');
					zsh_img('#zsb_img',zsb_img_url,pagesize,current,zcounter);
					return false;
				});
				$('#zsb_bg,#zsb_img').click(function(){
					zdo_loading=1;
					$zshowbox_loading.remove();
					$('#zsb_bg,#zsb_img').unbind('click');
					$('#zsb_bg,#zsb').fadeOut(400,function(){$(this).remove();});
					return false;
				});
				return false;
			};
		});
	};
	function zsh_img(img_id,zsb_img_url,pagesize,current,zcounter) { //图片放大load function
		$(img_id).parent().css({"margin-left":'-90px',"margin-top":'-40px'});
		$('#zsb_prev,#zsb_next').hide();
		var ni = new Image();
		ni.onload = function(){
			var x = pagesize[0] - 50, y = pagesize[1] - 50, img_w=ni.width, img_h=ni.height;
			if (img_w > x) {
				img_h = img_h * (x / img_w);
				img_w = x;
				if (img_h > y) {
					img_w = img_w * (y / img_h);
					img_h = y;
				}
			} else if (img_h > y) {
				img_w = img_w * (y / img_h);
				img_h = y;
				if (img_w > x) {
					img_h = img_h * (x / img_w);
					img_w = x;
				}
			}
			var marginleft=-(img_w/2+5)+'px', margintop=-(img_h/2+5)+'px';
			img_w=img_w+'px', img_h=img_h+'px'; 
			$(img_id).attr('src',zsb_img_url).css({"width":img_w,"height":img_h}).fadeIn(600).parent().css({"margin-left":marginleft,"margin-top":margintop}).prev().css("background-image","none");
			if (current>0) $('#zsb_prev').show();
			if (current<zcounter-1) $('#zsb_next').show();
		};
		ni.src = zsb_img_url;
	};
	function zsb_getPageSize(){ //获取浏览器窗口大小
		var de = document.documentElement;
		var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
		var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight;
		arrayPageSize = [w,h];
		return arrayPageSize;
	};
};

//////// z \\\\\\\\ 存档页面 jQ伸缩
zdo_modules_S.Archives = function() {
	var $a = $('#archives'),
		$m = $('.al_mon', $a),
		$l = $('.al_post_list', $a),
		$l_f = $('.al_post_list:first', $a);
	$l.hide();
	$l_f.show();
	$m.css('cursor', 's-resize').on('click', function(){
		$(this).next().slideToggle(400);
	});
	var animate = function(index, status, s) {
		if (index > $l.length) {
			return;
		}
		if (status == 'up') {
			$l.eq(index).slideUp(s, function() {
				animate(index+1, status, (s-10<1)?0:s-10);
			});
		} else {
			$l.eq(index).slideDown(s, function() {
				animate(index+1, status, (s-10<1)?0:s-10);
			});
		}
	};
	$('#al_expand_collapse').on('click', function(e){
		e.preventDefault();
		if ( $(this).data('s') ) {
			$(this).data('s', '');
			animate(0, 'up', 100);
		} else {
			$(this).data('s', 1);
			animate(0, 'down', 100);
		}
	});
};

//////// z \\\\\\\\ 评论 ajax 提交
zdo_modules_S.AjaxComment = function() {
	var $commentform = $('#commentform'),
			comment_ajax_php_file = 'comments-ajax.php';
			ajax_php_url=zdo_themeurl+'/'+comment_ajax_php_file,
			pic_sb = ajax_php_url.replace(comment_ajax_php_file,'')+'img/spinner.gif',//提交ajax_c_loading图片位置
			pic_no = zdo_themeurl+'/img/no.png', // 错误 icon
			pic_ys = zdo_themeurl+'/img/yes.png', // 成功 icon
			loading_htm = '<div id="ajax_c_loading" style="display:none;margin-bottom:10px;padding:8px;background-color:#fff;border:1px solid #e4e5e1;"><span id="ajax_c_zl" style="color:#999;"></span> | Submitting, please wait... 努力提交中...</div>',
			ok_htm = '<div id="ajax_c_ok" style="display:none;margin-bottom:10px;padding:8px;background:#fff;border:1px solid #e4e5e1;"><img src="' + pic_ys + '" style="vertical-align:middle;" alt="" /> Submit success! 提交成功!</div>',
			error_htm = '<div id="ajax_c_error" style="display:none;margin-bottom:10px;padding:8px;background:#fff;border:1px solid #e4e5e1;color:#f00;"><img src="' + pic_no + '" style="vertical-align:middle;" alt="" /> <span>#</span></div>',
			num_z = 1;
	$('#respond h3').before(loading_htm+ok_htm+error_htm);
	$('#submit').click(function(){
		var replyto = $('#comment').attr('data-replyto');
		if (replyto) $('#comment').val(replyto + $('#comment').val());
		$('#comment').attr('data-replyto','');
		
		editcode();
		$('#commentform,#respond div.cancel-comment-reply,#respond h3').hide();
		zdo_loading=0;
		$('#ajax_c_zl').zdo_loading('#000');
		$('#ajax_c_loading').show();
		$.ajax({
			// url:$("#commentform").attr("action"), //获取提交目的地址
			url:ajax_php_url, //获取提交目的地址
			data:$commentform.serialize(), //处理数据
			type:$commentform.attr('method'),//'POST',
			dataType:'text',
			success:function(data){
				zdo_loading=1;
				$('#ajax_c_loading').hide();
				//$('#comment').attr("value",'');//$('textarea').each(function() {this.value = ''});
				$('#comment').val('');//$('textarea').each(function() {this.value = ''});
				var t = addComment, parent = t.I('comment_parent').value,
					new_htm = ( parent == '0' ) ? ('\n<ol style="clear:both;" class="commentlist" id="new_' + num_z + '"></ol>') : ('\n<ul class="children comments-ajax" id="new_' + num_z + '"></ul>');
				$('#respond').before(new_htm);
				// $('#new_' + num_z).hide().append(data).animate({fontSize:'0.1em'},1).animate({fontSize:'1.6em',opacity:'toggle'},600).animate({fontSize:'1em'},900);
				zdo_jQbody.animate( { scrollTop: $('#new_' + num_z).offset().top - 200}, 900);
				$('#new_' + num_z).hide().append(data).animate({fontSize:'0.1em'},1).animate({fontSize:'1.6em',opacity:'toggle'},100).animate({fontSize:'1em'},200);
				setTimeout(function(){
					$('#ajax_c_ok').animate({height:'toggle',opacity:'toggle'},400);
				},300);
				setTimeout(function(){
					$('#ajax_c_ok').animate({height:'toggle',opacity:'toggle'},200,function(){
						$('#cancel-comment-reply-link').click();
						$('#commentform,#respond div.cancel-comment-reply,#respond h3').animate({height:'toggle',opacity:'toggle'},900);
					});
				},4000);
				num_z++;
			},
			error:function(dataxml){
				var eStart=dataxml.responseText.indexOf('<p>');
				var eend = dataxml.responseText.indexOf('</p>');
				var error_data = dataxml.responseText.substring(eStart+3,eend);
				zdo_loading=1;
				$('#ajax_c_loading').hide();
				$('#ajax_c_error').slideToggle().find("span").empty().html(error_data);
				// setTimeout(function(){$('#respond').attr('disabled', false).fadeTo("slow",1);},2000);
				setTimeout(function(){$('#ajax_c_error').slideToggle();$('#commentform,#respond div.cancel-comment-reply,#respond h3').animate({height:'toggle',opacity:'toggle'},900);},4000);
			}
		});
		return false;
	});

	/** comment-reply.dev.js */
	addComment={moveForm:function(d,f,i,c){var m=this,a,h=m.I(d),b=m.I(i),l=m.I("cancel-comment-reply-link"),j=m.I("comment_parent"),k=m.I("comment_post_ID");if(!h||!b||!l||!j){return}m.respondId=i;c=c||false;if(!m.I("wp-temp-form-div")){a=document.createElement("div");a.id="wp-temp-form-div";a.style.display="none";b.parentNode.insertBefore(a,b)}h.parentNode.insertBefore(b,h.nextSibling);if(k&&c){k.value=c}j.value=f;l.style.display="";l.onclick=function(){var n=addComment,e=n.I("wp-temp-form-div"),o=n.I(n.respondId);if(!e||!o){return}n.I("comment_parent").value="0";e.parentNode.insertBefore(o,e);e.parentNode.removeChild(e);this.style.display="none";this.onclick=null;return false};try{m.I("comment").focus()}catch(g){}return false},I:function(a){return document.getElementById(a)}};
	//===================================评论 ajax 提交 - end!
};

//////// z \\\\\\\\ 点击回复、引用自动@xxx + 评论框跟随
zdo_modules_S.ReplyQuoteAndRespond = function() {

	//点击回复、引用自动@xxx
	$('#thecomments a.zsnos_reply').zdo_reply_quote('#thecomments a.zsnos_quote');

	//评论框跟随
	if ( !zdo_isMobile.any() ){ //移动设备不要执行

		$(window).load(function(){
			var $respond = $('#respond'),
				r_h = $respond.outerHeight(true) //respond_height
			;
			$respond.parent().css('min-height', r_h+'px');

			var	$respond_follow = function() {
				var w_h = $(window).height(), //windows height
						w_w = $(window).width(), //windows height
						r_h = $respond.outerHeight(true), //respond_height
						st = $(document).scrollTop(), //scrollTop
						start_h = $('#respond-follow-start').offset().top - (w_h - r_h),
						end_h = $('#respond-area').offset().top + r_h - w_h
				;
				if (w_w >= 1180 && w_h >= r_h+100) {
					if (st > start_h+60 && st < end_h) {
						$respond.addClass('respond-follow');
					} else {
						$respond.removeClass('respond-follow');
					}
				} else {
					$respond.removeClass('respond-follow');
				}
			};

			$(window).bind('scroll', $respond_follow);
			$(window).bind('resize', $respond_follow);
		});

	} // no in mobile

};

//////// z \\\\\\\\ Ajax 评论翻页
zdo_modules_S.AjaxCommentLoad = function() {
	var $thecomments=$('#thecomments'),
			$navigation=$('#navigation'),
			AjaxCommentCallback='mytheme_comment'
	;
	$navigation.delegate('a','click',function(){
		var wpurl=$(this).attr("href").split(/(\?|&)action=AjaxCommentsPage.*$/)[0];
		var commentPage = 1;
		if (/comment-page-/i.test(wpurl)) {
		commentPage = wpurl.split(/comment-page-/i)[1].split(/(\/|#|&).*$/)[0];
		} else if (/cpage=/i.test(wpurl)) {
		commentPage = wpurl.split(/cpage=/)[1].split(/(\/|#|&).*$/)[0];
		};
		//alert(commentPage);//获取页数
		var postId =$('#cp_post_id').text();
		//alert(postId);//获取postid
		var url = wpurl.split(/#.*$/)[0];
		url += /\?/i.test(wpurl) ? '&' : '?';
		url += 'action=AjaxCommentsPage&post=' + postId + '&page=' + commentPage + '&callback=' + AjaxCommentCallback;
		//alert(url);//看看传入参数是否正确
		zdo_jQbody.animate({scrollTop: $thecomments.offset().top - 80}, 1000);
		$thecomments.empty().html('<p id="ajax_c_loading" style="padding:10px 0;text-align:center;color:#8c9fcc"></p>');
		zdo_loading=0;
		$ajax_c_loading=$('#ajax_c_loading');
		$ajax_c_loading.zdo_loading();
		$navigation.empty();
		$.ajax({
			url: url,
			type: 'get',
			// beforeSend: function() {
			// },
			error: function(request) {
				alert(request.responseText);
				zdo_loading=1;
			},
			success : function (data) {
				// console.time('ajacpload_success');
				zdo_loading=1;
				var responses=data.split('<!--zww-AJAX-COMMENT-PAGE-->');
				$thecomments.hide().html(responses[0]).fadeIn(600);
				$navigation.hide().html(responses[1]).fadeIn(600);
				// $navigation_a.unbind('click');
				zdo_jQbody.animate({scrollTop: $thecomments.offset().top - 80}, 1000);
				$('#thecomments a.zsnos_reply').zdo_reply_quote('#thecomments a.zsnos_quote');
				// console.timeEnd('ajacpload_success');
				$('#thecomments img').zdo_Lazyload();
			}
		});
		return false;
	});
};

$(function() {
	if ( $('#archives').length ) {
		zdo_modules_S.Archives();
	} else {
		zdo_modules_S.zShowBox();
		zdo_modules_S.AjaxComment();
		zdo_modules_S.ReplyQuoteAndRespond();
		zdo_modules_S.AjaxCommentLoad();
	}
});

/*
* 1、将下面的js代码在页面任意位置引入
* 2、在评论框附近，需要添加编辑器按钮的地方，依此格式调用相应函数
* 	 <a href="javascript:SIMPALED.Editor.strong()">加粗</a>
* 	 <a href="javascript:SIMPALED.Editor.ahref()">链接</a>
* 	 <a href="javascript:SIMPALED.Editor.html()">代码转换</a>
*/
(function(){
	function addEditor(myField,ftag,etag){
			if (document.selection) {
					myField.focus();
					sel = document.selection.createRange();
					etag ? sel.text = ftag + sel.text + etag : sel.text = ftag;
					myField.focus();
			} else if (myField.selectionStart || myField.selectionStart == '0') {
					var startPos = myField.selectionStart;
					var endPos = myField.selectionEnd;
					var cursorPos = endPos;
					etag ? myField.value = myField.value.substring(0, startPos) + ftag + myField.value.substring(startPos, endPos) + etag + myField.value.substring(endPos, myField.value.length) : myField.value = myField.value.substring(0, startPos) + ftag + myField.value.substring(endPos, myField.value.length);
					etag ? cursorPos += ftag.length + etag.length : cursorPos += ftag.length - endPos + startPos;
					if(startPos == endPos && etag)cursorPos -= etag.length;
					myField.focus();
					myField.selectionStart = cursorPos;
					myField.selectionEnd = cursorPos;
			} else {
					myField.value += ftag + etag;
					myField.focus();
			}
	}
	var myField=document.getElementById("comment")||0;
	var Editor={
			strong:function(){
					addEditor(myField,'<strong>','</strong>');
			},
			em:function(){
					addEditor(myField,'<em>','</em>');
			},
			del:function(){
					addEditor(myField,'<del>','</del>');
			},
			underline:function(){
					addEditor(myField,'<u>','</u>');
			},
			quote:function(){
					addEditor(myField,'<blockquote>','</blockquote>');
			},
			ahref:function(){
					var URL = prompt('Enter the URL' ,'http://');
					if (URL) {
							addEditor(myField,'<a target="_blank" href="' + URL + '" rel="external">','</a>');
					}
			},
			code:function(){
					addEditor(myField,'<pre>','</pre>');
			}
	};
	window['SIMPALED'] = {};
	window['SIMPALED']['Editor'] = Editor;
})();

function editcode(){
	var myField='',
		str=$('#comment').val(),
		start=str.indexOf('<code>'),
		end=str.indexOf('</code>');
	if(start>-1&&end>-1&&start<end){
		myField='';
		while(end!=-1){
			myField+=str.substring(0,start+6)+str.substring(start+6,end).replace(/<(?=[^>]*?>)/gi,'&lt;').replace(/>/gi,'&gt;');
			str=str.substring(end+7,str.length);
			start=str.indexOf('<code>')==-1?-6:str.indexOf('<code>');
			end=str.indexOf('</code>');
			if(end==-1){
				myField+='</code>'+str;
				$('#comment').val(myField);
			}else if(start==-6){
				myFielde+='&lt;/code&gt;';
			}else{
				myField+='</code>';
			}
		}
	}
	var str=myField ? myField : $('#comment').val(),
		myField='',
		start=str.indexOf('<pre>'),
		end=str.indexOf('</pre>');
	if(start>-1&&end>-1&&start<end){
		myField=myField;
	}else return;
	while(end!=-1){
		myField+=str.substring(0,start+5)+str.substring(start+5,end).replace(/<(?=[^>]*?>)/gi,'&lt;').replace(/>/gi,'&gt;');
		str=str.substring(end+6,str.length);
		start=str.indexOf('<pre>')==-1?-5:str.indexOf('<pre>');
		end=str.indexOf('</pre>');
		if(end==-1){
			myField+='</pre>'+str;
			$('#comment').val(myField);
		}else if(start==-5){
			myFielde+='&lt;/pre&gt;';
		}else{
			myField+='</pre>';
		}
	}
}

/* <![CDATA[ */
		zoo_grin = function (tag) {
			var myField;
			tag = ' ' + tag + ' ';
				if (document.getElementById("comment") && document.getElementById("comment").type == 'textarea') {
				myField = document.getElementById("comment");
			} else {
				return false;
			}
			if (document.selection) {
				myField.focus();
				sel = document.selection.createRange();
				sel.text = tag;
				myField.focus();
			}
			else if (myField.selectionStart || myField.selectionStart == '0') {
				var startPos = myField.selectionStart;
				var endPos = myField.selectionEnd;
				var cursorPos = endPos;
				myField.value = myField.value.substring(0, startPos)
								+ tag
								+ myField.value.substring(endPos, myField.value.length);
				cursorPos += tag.length;
				myField.focus();
				myField.selectionStart = cursorPos;
				myField.selectionEnd = cursorPos;
			}
			else {
				myField.value += tag;
				myField.focus();
			}
		}
/* ]]> */


})(jQuery, window);