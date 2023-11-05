(function ($, window) {

	$(document).ready(function(){

		//////// for WordPress >= 4.4 ////////

		if ( $("#replycontent").length ){

			var $replycontent = $("#replycontent"), home_url = $('#wp-admin-bar-site-name .ab-item').attr('href');

			$.get('./?action=Ajax_data_zfunc_smiley_button',
				function (data_zfunc_smiley_button) {
					$('#qt_replycontent_toolbar input:last').after(data_zfunc_smiley_button);
				}
			);

			$replycontent.attr('onkeydown','if(event.ctrlKey){if(event.keyCode==13){document.getElementById(\'replybtn\').click();return false}};');
			/*$replycontent.keypress(function(e) {
				if (e.ctrlKey && e.which == 13)
					$('#replybtn').click();
			});*/

			$('#the-comment-list').on('click', '.vim-r', function(){
				$replycontent.attr('data-reply','on');
				var $thiscomment = $(this).parent().parent().parent().parent(),
						haveParent = $thiscomment.find('td.comment .comment-author').next().is('a') ? 1 : '',
						$submitted_on = $thiscomment.find('.submitted-on'),
						atid = '#' + $submitted_on.children('a:first').attr('href').split('#')[1],
						atname = $thiscomment.find('td.author').find('strong').text().replace(/^(\s|\xA0)+|(\s|\xA0)+$/g, ''),
						value = '<a href="' + atid + '">@' + atname + '</a>' + " ";
				// $replycontent.val('').focus().val(value);
				$replycontent.val('').focus().attr('data-replyto',value);
				
				// $('#replybtn').click(function(){
				// 	$replycontent.attr('onkeydown','');
				// });

				// click 后有延迟，所以改为 focus 来来改变 comment_ID 实现“对二级评论回复到其父级”
				$replycontent.on('focus',function(){
					if ($replycontent.attr('data-reply') == 'on') {
						if (haveParent == 1) {
							var parentID = $thiscomment.find('td.comment .comment-author').next().attr('href').split('#')[1].split('-')[1];
							// console.log(haveParent);
							//对二级评论的回复：改为回复到其父评论 
							$('#comment_ID').val(parentID);
						}
					}
				});

				$('#replybtn').on('click', function(){
					var replyto = $replycontent.attr('data-replyto');
					if (replyto) $replycontent.val(replyto + $replycontent.val());
					// console.log($replycontent.val());
					$replycontent.attr('data-reply','off');
					$replycontent.attr('data-replyto','');
				});
				
			});

			$('#the-comment-list').on('mouseover', 'td.comment a', function(){
				if ( $(this).prev().is('.comment-author') || $(this).parent().is('p') ) {
					var href=$(this).attr('href').split('#comment-');
					// console.log(href.length);
					if ( href.length > 1) {
						$('#wpfooter').after('<div id="replyto" style="border:3px solid #5dbef7;padding:5px 10px;position:absolute;width:450px;height:auto;background:#fff;z-index:9999;"><span style="position:absolute;top:-15px;left:5px;width:3px;height:15px;background:#5dbef7;"></span><div id="replyto_content">Loading...</div></div>');

						//// normal 方法
						$.get('./?action=Ajax_data_get_comment&commentID='+href[1],
							function (data) {
								// console.log(data);
								$('#replyto_content').html(data);
							}
						);
/*					//// wp rest api: 有权限问题，不能看其他人的
						$.getJSON(home_url+'wp-json/wp/v2/comments/'+href[1],
							function (data) {
								// console.log(data.id);
								$('#replyto_content').html(data.content.rendered);
							}
						);
*/
					}
				}
			}).mousemove(function(e){
				$('#replyto').css({left:e.pageX-2,top:e.pageY+10});
			}).mouseout(function(){
				$('#replyto').remove();
			});

		};

	});

	zdo_grin = function(tag) {
		var myField;
		tag = ' ' + tag + ' ';
			if (document.getElementById('replycontent') && document.getElementById('replycontent').type == 'textarea') {
			myField = document.getElementById('replycontent');
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

})(jQuery, window);
