<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
/*	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	} *///不需要密码判断就关了hzlzh
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : $comments_top = $comments; ?>

	<h3 id="comments"><?php comments_number('0 comment', '1 comment', '% comments');?></h3>

	<ol class="commentlist" id="thecomments">
		<?php
		global $cpage;
		if ( (int) get_option('page_comments') === 1 && get_comment_pages_count() > 1 && $cpage != 1 ) {
			wp_list_comments( 'type=all&callback=mytheme_comment_top3&per_page=3&page=1&max_depth=-1', get_comments('status=approve&order=ASC&post_id='.get_the_id()) );
			echo '<li class="comment_top3">......</li>';
		}
		wp_list_comments('type=all&callback=mytheme_comment');
		?>
	</ol>
	
	<?php if ((int) get_option('page_comments') === 1 && get_comment_pages_count() > 1) { ?>
		<div class="pagination">
			<div id="navigation" class="navigation">
				<?php $args=array('prev_text'=>'&laquo;', 'next_text'=>'&raquo;'); paginate_comments_links($args); ?>
			</div>
		</div>
		<span id="cp_post_id" class="hidden"><?php echo $post->ID; ?></span>
	<?php } ?>
	
<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : //If comments are open, but there are no comments. ?>
		<h3 id="comments"><?php comments_number('0 comment', '1 comment', '% comments');?></h3>
	<?php elseif (!is_page()) : //If comments are closed	?>
		<h3 id="comments">Comments are closed.</h3>
	<?php endif; ?>
	
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

	<div id="respond-area">
		<div id="respond" class="respond">
			<h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>
			<div class="cancel-comment-reply">
				<small><?php cancel_comment_reply_link(); ?></small>
			</div>
		
			<?php /* if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
			<?php else : *///不需要强制注册就关了hzlzh ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
			
				<?php if ( $user_ID ) : ?>
				<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
				<?php else : ?>
				<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
				<label for="author"><small>Name <?php if ($req) echo "*"; ?></small></label></p>
				<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
				<label for="email"><small>Mail <?php if ($req) echo "*"; ?></small></label></p>
				<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				<label for="url"><small>Website</small></label></p>
				<?php endif; ?>
				<?php if (function_exists('zfunc_smiley_button')) zfunc_smiley_button(true, '<p class="smiley">', '</p>'); ?>
				<div class="textarea" id="textareaID">
					<textarea name="comment" id="comment" cols="100%" rows="6" tabindex="4" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
					<div class="editor_tools">
						<a href="javascript:SIMPALED.Editor.strong()">B</a>
						<a href="javascript:SIMPALED.Editor.em()">em</a>
						<a href="javascript:SIMPALED.Editor.del()">del</a>
						<a href="javascript:SIMPALED.Editor.underline()">U</a>
						<a href="javascript:SIMPALED.Editor.ahref()">Link</a>
						<a href="javascript:SIMPALED.Editor.code()">Code</a>
						<a href="javascript:SIMPALED.Editor.quote()">Quote</a>
					</div>
					<?php /* if (!$user_ID && home_url()!='http://z.turn/zww') { ?>
					<div id="comment-ad">
						<script type="text/javascript">var cpro_id = 'u66854';</script><script src="http://cpro.baidu.com/cpro/ui/c.js" type="text/javascript"></script>
					</div>
					<?php } */ ?>
				</div>
				<p><input name="submit" type="submit" id="submit" tabindex="5" value="SUBMIT / Ctrl + Enter" /><?php comment_id_fields(); ?></p>
				<?php do_action('comment_form', $post->ID); ?>
				
			</form>
			<?php //endif;//hzlzh // If registration required and not logged in	?>
		
		</div><!-- end #respond -->
	</div><!-- end .respond-area -->
	
<?php endif; // if you delete this the sky will fall on your head ?>

