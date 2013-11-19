<?php get_header(); global $zbench_options; ?>
<div id="content">
<?php if (have_posts()) : ?>
	<?php if (is_search()) { ?>
	<div class="page-title">
		<h1>
			<?php $archive_title=''; if($paged && $paged > 1) $archive_title='<span class="page-title-paged"> - '.sprintf(__('Page %s','zbench'),$paged).'</span>'; ?>
			<?php _e('Search Results for:','zbench'); ?> <?php echo get_search_query(),$archive_title; ?>
		</h1>
	</div>
	<?php } ?>
	<?php while (have_posts()) : the_post();?>
	<div <?php post_class('post'); ?> id="post-<?php the_ID(); ?>"><!-- post div -->
		<h2 class="title<?php if(is_sticky()) {echo " sticky-h2";} ?>"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'zbench'), the_title_attribute('echo=0') ); ?>"><?php the_title(); ?></a></h2>
		<div class="post-info-top">
			<span class="post-info-date">
				<?php _e('Posted by', 'zbench'); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" title="<?php printf( __( 'View all posts by %s', 'zbench' ), get_the_author() ) ?>" rel="author"><?php the_author(); ?></a>
				<?php _e('on', 'zbench'); ?> <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark"><?php the_time(get_option( 'date_format' )); ?></a>
				<?php edit_post_link(__('Edit','zbench'), '[', ']'); ?>
			</span>
			<span class="gotocomments"><?php comments_popup_link(__('No comments', 'zbench'), '1 '.__('comment', 'zbench'), '% '.__('comments', 'zbench')); ?><?php if(function_exists('the_views')) { echo " | ";the_views(); } ?></span>
		</div>
		<div class="clear"></div>
		<div class="entry">
			<?php if ( $zbench_options['excerpt_check']=='true' ) { the_excerpt(__('Read more &raquo;','zbench')); } else { the_content(__('Read more &raquo;','zbench')); } ?>
		</div><!-- END entry -->
		<?php if(is_sticky()) { ?>
			<div class="entry"><p><?php _e('This is a sticky post!', 'zbench'); ?> <a href="<?php the_permalink(); ?>" class="more-links"><?php _e('continue reading?', 'zbench'); ?></a></p></div>
		<?php } ?>
	</div><!-- END post -->
	<?php endwhile; ?>
<?php else: ?>
	<div class="post post-single">
		<h2 class="title title-single"><?php _e('Error 404 - Not Found', 'zbench'); ?></h2>
		<div class="post-info-top" style="height:1px;"></div>
		<div class="entry">
			<p><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'zbench'); ?></p>
			<h3><?php _e('Random Posts', 'zbench'); ?></h3>
			<ul>
				<?php
					$rand_posts = get_posts('numberposts=5&orderby=rand');
					foreach( $rand_posts as $post ) :
				?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<h3><?php _e('Tag Cloud', 'zbench'); ?></h3>
			<?php wp_tag_cloud('smallest=9&largest=22&unit=pt&number=200&format=flat&orderby=name&order=ASC');?>
		</div><!--entry-->
	</div><!--post-->
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
			posts_nav_link(' | ', __('&laquo; Previous page','zbench'), __('Next page &raquo;','zbench'));
		echo '</div>';
	}
}
?>
</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>