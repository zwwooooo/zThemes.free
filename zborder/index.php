<?php get_header(); global $zborder_theme_options; ?>

<div id="content">

<?php if (have_posts()) : ?>

	<?php if ( is_home() || is_front_page() ){
		if ($paged > 1 ) { ?>
			<div class="archive_title">
				<?php echo __('All posts', 'zborder') . '<span class="archive_page"> | '. sprintf(__('Page %s','zborder'), $paged) .'</span>'; ?>
				<span class="jtxs_bg"></span>
			</div>
		<?php }
	} ?>

	<?php if (is_search()) : ?>
		<div class="post_path">
			<?php _e('You are here:', 'zborder'); ?> <a class="first_home" rel="nofollow" title="<?php _e('Go to homepage', 'zborder'); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e('Home', 'zborder'); ?></a> &raquo; <?php echo sprintf(__('<h1>Search Results for %s</h1>','zborder'), get_search_query()); ?>
		</div>
		<div class="archive_title">
			<?php echo sprintf(__('Search Results for %s','zborder'), get_search_query()); ?>
			<?php if ($paged > 1) echo '<span class="archive_page"> | '. sprintf(__('Page %s','zborder'), $paged) .'</span>'; ?>
		</div>
	<?php endif; ?>

	<?php while (have_posts()) : the_post();?>

		<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>">
			<?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<div class="entry">
				<?php if ( $zborder_theme_options['excerpt_check']=='true' ) { the_excerpt(__('read more','zborder')); } else { the_content(__('read more','zborder')); } ?>
			</div>
			<div class="p_meta">
				<?php if ( $paged<2 && is_sticky() ) {
					echo '<span class="sticky_mark">'. __('Sticky post!', 'zborder') . '</span>';
				} ?>
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>
				| <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
				| <?php the_category(', '); ?>
				<?php if(function_exists('the_views')) { echo '| '; the_views(); } ?>
				<?php edit_post_link( __( 'Edit', 'zborder' ), '[', ']' ); ?>
				<p class="p_comment"><?php comments_popup_link('0', '1', '%'); ?></p>
			</div>
		</div>

	<?php endwhile; ?>

<?php else: ?>

	<div class="post">
		<h2 class="title"><?php _e('Error 404 - Not Found', 'zborder'); ?></h2>
		<div class="entry">
			<p><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'zborder'); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>

<?php endif; ?>

<?php
if(function_exists('wp_page_numbers')) {
	wp_page_numbers();
}
elseif(function_exists('wp_pagenavi')) {
	wp_pagenavi();
} else {
	global $wp_query;
	$total_pages = $wp_query->max_num_pages;
	if ( $total_pages > 1 ) {
		echo '<div id="pagination">';
			posts_nav_link(' | ', __('&laquo; Previous page','zborder'), __('Next page &raquo;','zborder'));
		echo '</div>';
	}
}
?>
</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>