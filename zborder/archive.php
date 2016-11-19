<?php get_header(); global $zborder_theme_options; ?>
<div id="content">

<?php if ( have_posts() ) :
	$categories='';
	$tags='';
	if ( is_category() ) {
		$post_path = single_cat_title( '', false );
		
		$cat_parents='';
		$catID = single_term_id_by_zww( '', false );
		if ( $parentIDs=get_ancestors($catID, 'category') ) {
			$parentIDs=array_reverse($parentIDs);
			foreach ($parentIDs as $parentID) {
				$cat_parents .= '<a href="'. get_category_link($parentID) .'">'. get_cat_name($parentID) .'</a> &raquo; ';
			}
		}
		
		$archive_title = __('Category Archives:', 'zborder') . ' <span>' . $post_path . '</span>';
		$post_path = $categories.$cat_parents.'<h1>'.$post_path.'</h1>';
	} elseif ( is_tag() ) {
		$post_path=single_tag_title( '', false );
		$archive_title = __('Tag Archives:', 'zborder') . ' <span>' . $post_path . '</span>';
		$post_path=$tags.'<h1>'.$post_path.'</h1>';
	} elseif ( is_date() ) {
		$post_path='';
		if(is_day()) {
			$post_path = get_the_date();
		} elseif(is_year()) {
			$post_path = get_the_date( _x( 'Y', 'yearly archives date format', 'zborder' ) );
		} else {
			$post_path = get_the_date( _x( 'F Y', 'monthly archives date format', 'zborder' ) );
		}
		$archive_title = __('Date Archives:', 'zborder') . ' <span>'. $post_path . '</span>';
	} elseif ( is_author() ) {
		$curauth = get_userdata_in_author_archive();
		$post_path=$curauth->display_name;
		$archive_title = sprintf(__('All posts by <span>%s</span>','zborder'), $post_path);
		$post_path= sprintf(__('All posts by <h1>%s</h1>','zborder'), $post_path);
	} else {
		$post_path=__('Blog Archives', 'zborder');
		$archive_title = __('Blog Archives', 'zborder');
	}
	if($paged && $paged > 1) $archive_title .= '<span class="archive_page"> - ' . sprintf(__('Page %s','zborder'), $paged) . '</span>'; ?>
	<div class="post_path">
		<?php _e('You are here:', 'zborder'); ?> <a class="first_home" rel="nofollow" title="<?php _e('Go to homepage', 'zborder'); ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e('Home', 'zborder'); ?></a> &raquo; <?php echo $post_path; ?>
	</div>
	<div class="archive_title"><?php echo $archive_title; ?><span class="jtxs_bg"></span></div>

	<?php while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">
			<?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<div class="entry">
				<?php if ( $zborder_theme_options['excerpt_check']=='true' ) { the_excerpt(__('read more','zborder')); } else { the_content(__('read more','zborder')); } ?>
			</div>
			<div class="p_meta">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a>
				| <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
				| <?php the_category(', '); ?>
				<?php if(function_exists('the_views')) { echo '| '; the_views(); } ?>
				<?php edit_post_link( __( 'Edit', 'zborder' ), '[', ']' ); ?>
				<p class="p_comment"><?php comments_popup_link('0', '1', '%'); ?></p>
			</div>
		</div>
	<?php endwhile; ?>

	<?php if(function_exists('wp_page_numbers')) {
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
	} ?>

<?php else: ?>
	<div class="post post_s">
		<h2 class="title title_s"><?php _e('Error 404 - Not Found', 'zborder'); ?></h2>
		<div class="entry">
			<p><?php _e('Sorry, but you are looking for something that isn&#8217;t here.', 'zborder'); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
<?php endif; ?>

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>