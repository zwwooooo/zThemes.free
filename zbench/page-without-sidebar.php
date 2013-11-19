<?php
/*
Template Name: Page without Sidebar
*/
get_header(); ?>
<div id="content_ns">
	<?php the_post(); $nocomment_class=''; if ('open' != $post->comment_status) $nocomment_class=' post-page-nocomment'; ?>
	<div <?php post_class('post post-page post_ns'.$nocomment_class); ?> id="post-<?php the_ID(); ?>"><!-- post div -->
		<h2 class="title title-single"><?php the_title(); ?></h2>
		<?php if ('open' == $post->comment_status) { ?>
		<div class="post-info-top">
			<span class="addcomment"><a href="#respond"  rel="nofollow" title="<?php _e('Leave a comment ?', 'zbench'); ?>"><?php _e('Leave a comment', 'zbench'); ?></a><?php comments_number(' (0)', ' (1)', ' (%)'); ?></span>
			<span class="gotocomments"><a href="#comments"  rel="nofollow" title="<?php _e('Go to comments ?', 'zbench'); ?>"><?php _e('Go to comments', 'zbench'); ?></a></span>
		</div>
		<?php } else { ?>
		<div class="post-info-top post-info-top-nocomment"></div>
		<?php } ?>
		<div class="clear"></div>
		<div class="entry">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page_link"><strong>' . __( 'Pages:', 'zbench' ) . '</strong>' , 'after' => '</div>' ) ); ?>
		</div><!-- END entry -->
	</div><!-- END post -->
	<?php comments_template( '', true ); ?>
</div><!--content-->
<?php get_footer(); ?>