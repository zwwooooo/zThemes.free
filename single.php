<?php get_header(); ?>
<div id="content">
	<?php the_post(); ?>

	<div class="post_path">
		<?php _e('You are here:', 'zborder'); ?> <a class="first_home" rel="nofollow" title="<?php _e('Go to homepage', 'zborder'); ?>" href="<?php echo home_url('/'); ?>"><?php _e('Home', 'zborder'); ?></a>
		&raquo; <?php the_category(' &raquo; ', 'multiple'); ?> &raquo; <?php the_title(); ?>
	</div>
	<div <?php post_class('post post_s'); ?> id="post-<?php the_ID(); ?>">
		<?php the_title( '<h1 class="title title_s">', '</h1>' ); ?>
		<div id="scroll_s_p" class="p_meta_s_t">
			<?php echo get_the_date(); ?>
			| <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
			<?php edit_post_link( __( 'Edit', 'zborder' ), '[', ']' ); ?>
			<?php if (comments_open()) : ?>
				<span class="p_comment_s">&nabla; <a href="#respond" title="<?php _e('Go to respond', 'zborder'); ?>" rel="nofollow"><?php _e('Leave a comment', 'zborder'); ?></a><?php comments_number('(0)', '(1)', '(%)'); ?></span>
				<span class="p_comment_s">&oplus; <a href="#comments" title="<?php _e('Go to comments', 'zborder'); ?>" rel="nofollow"><?php _e('Go to comments', 'zborder'); ?></a></span>
			<?php endif; ?>
			<span class="jtxs_bg"></span>
		</div>
		<div class="entry" id="entry_font">
			<?php the_content(); ?>
			<?php wp_link_pages('before=<div class="wp_link_pages"><strong>'. __('Pages:', 'zborder') . '</strong>&after=</div>&next_or_number=number&pagelink=<span class="page_number">%</span>'); ?>
		</div>
		<div class="p_meta">
			<?php _e('Filed under', 'zborder'); ?> <h2><?php the_category(', '); ?></h2>
			| <?php _e('Tags:', 'zborder'); ?> <h2><?php the_tags('', ', ', ''); ?></h2>
		</div>
		<div id="nav_below">
			<p class="nav-previous"><?php previous_post_link( '&laquo; %link ', '%title' ); ?></p>
			<p class="nav-next"><?php if (get_next_post()) { next_post_link( ' %link &raquo;', '%title' ); } else { _e('(This is the latest article)', 'zborder'); } ?></p>
		</div>
	</div>

	<?php comments_template( '', true ); ?>

</div><!--content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>