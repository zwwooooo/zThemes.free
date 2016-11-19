<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'zbench'); ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->

	<?php if ( have_comments() ) { ?>
		<div id="comments-div"><?php if ( comments_open() ) { ?><span id="comments-addcomment"><a href="#respond"  rel="nofollow" title="<?php _e('Leave a comment ?', 'zbench'); ?>"><?php _e('Leave a comment ?', 'zbench'); ?></a></span><?php } ?><h2 id="comments"><?php comments_number('0', '1', '%' );?> <?php _e('Comments.','zbench'); ?></h2></div>
		<ol class="commentlist" id="thecomments">
				<?php wp_list_comments('type=all&callback=zbench_mytheme_comment'); ?>
		</ol>
		<div class="navigation"><?php paginate_comments_links(); ?></div>
	<?php } else { // this is displayed if there are no comments so far ?>
		<?php if ( comments_open() ) { ?>
			<div id="comments-div"><?php if ( comments_open() ) { ?><span id="comments-addcomment"><a href="#respond"  rel="nofollow" title="<?php _e('Leave a comment ?', 'zbench'); ?>"><?php _e('Leave a comment ?', 'zbench'); ?></a></span><?php } ?><h2 id="comments"><?php comments_number('0', '1', '%' );?> <?php _e('Comments.','zbench'); ?></h2></div>
		<?php } elseif ( ! comments_open() && !is_page() ) { ?>
			<div id="comments-div"><h2 id="comments"><?php _e('Comments are closed.','zbench'); ?></h2></div>
		<?php } // end ! comments_open() ?>
	<?php } // end have_comments()

global $zbench_options;
$smilies='';
if ($zbench_options['smilies'] != 'true') { ?>

	<script type="text/javascript">
	/* <![CDATA[ */
		function grin(tag) {
			var myField;
			tag = ' ' + tag + ' ';
			if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
				myField = document.getElementById('comment');
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
	</script>
	<?php
	$wpurl = site_url(); // get_bloginfo("wpurl");
	$smilies = '
	<a href="javascript:grin(\':?:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_question.gif" alt="" /></a>
	<a href="javascript:grin(\':razz:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_razz.gif" alt="" /></a>
	<a href="javascript:grin(\':sad:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_sad.gif" alt="" /></a>
	<a href="javascript:grin(\':evil:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_evil.gif" alt="" /></a>
	<a href="javascript:grin(\':!:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_exclaim.gif" alt="" /></a>
	<a href="javascript:grin(\':smile:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_smile.gif" alt="" /></a>
	<a href="javascript:grin(\':oops:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_redface.gif" alt="" /></a>
	<a href="javascript:grin(\':grin:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_biggrin.gif" alt="" /></a>
	<a href="javascript:grin(\':eek:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_surprised.gif" alt="" /></a>
	<a href="javascript:grin(\':shock:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_eek.gif" alt="" /></a>
	<a href="javascript:grin(\':???:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_confused.gif" alt="" /></a>
	<a href="javascript:grin(\':cool:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_cool.gif" alt="" /></a>
	<a href="javascript:grin(\':lol:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_lol.gif" alt="" /></a>
	<a href="javascript:grin(\':mad:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_mad.gif" alt="" /></a>
	<a href="javascript:grin(\':twisted:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_twisted.gif" alt="" /></a>
	<a href="javascript:grin(\':roll:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_rolleyes.gif" alt="" /></a>
	<a href="javascript:grin(\':wink:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_wink.gif" alt="" /></a>
	<a href="javascript:grin(\':idea:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_idea.gif" alt="" /></a>
	<a href="javascript:grin(\':arrow:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_arrow.gif" alt="" /></a>
	<a href="javascript:grin(\':neutral:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_neutral.gif" alt="" /></a>
	<a href="javascript:grin(\':cry:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_cry.gif" alt="" /></a>
	<a href="javascript:grin(\':mrgreen:\')"><img src="'.$wpurl.'/wp-includes/images/smilies/icon_mrgreen.gif" alt="" /></a>
	<br />';
	$smilies='<p class="smilies">'.$smilies.'</p>';
}
	$comment_notes='<p class="comment-note">' . __('NOTE - You can use these ','zbench') . sprintf(('<abbr title="HyperText Markup Language">HTML</abbr> '.__('tags and attributes:','zbench').'<br />%s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>';
	if($zbench_options['comment_notes']=='true') $comment_notes='';
	$fields =  array(
			'author' => '<p class="comment-form-author">' .
			'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" />'. ' <label for="author"><small>' . __( 'NAME','zbench' ) . '</small></label></p>',
			'email'  => '<p class="comment-form-email">' .
			'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" /> <label for="email">' . __( 'EMAIL', 'zbench' ) . '</label></p>',
			'url'    => '<p class="comment-form-url">' .
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /> <label for="url">' . __( 'Website URL', 'zbench' ) . '</label></p>',
			);
	$args = array(
			'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_notes_before' => '',
			'comment_field'        => $smilies.'<p class="comment-form-comment"><textarea aria-required="true" rows="8" cols="45" name="comment" id="comment" onkeydown="if(event.ctrlKey){if(event.keyCode==13){document.getElementById(\'submit\').click();return false}};"></textarea></p>',
			'comment_notes_after'  => $comment_notes,
			'title_reply'          => __( 'Leave a Comment', 'zbench'),
			'title_reply_to'       => __('Reply to %s &not;<br />','zbench'), 
			'cancel_reply_link'    => __( '<small>Cancel reply</small>', 'zbench' ),
			'label_submit'         => __( 'SUBMIT', 'zbench' )
			);

	comment_form($args); 

	$havepings = 0;
	foreach($comments as $comment){ if(get_comment_type() != 'comment' && $comment->comment_approved != '0'){ $havepings = 1; break; } }
	if($havepings == 1) : ?>
		<div class="trackbacks-pingbacks">
			<h3><?php _e('Trackbacks and Pingbacks:', 'zbench'); ?></h3>
			<ul id="pinglist">
				<?php wp_list_comments('type=pings&per_page=0&callback=zbench_custom_pings'); ?>
			</ul>
		</div>
	<?php endif; ?>