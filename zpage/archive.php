<?php get_header(); global $zpage_theme_options; ?>

<div id="content" class="content">

<?php if (have_posts()) : ?>

	<?php
	$home = 'You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="' . home_url('/') . '">Home</a>';
	$categories = ' &raquo; <a href="'.home_url('/categories').'">All Categories</a>';
	$tags= ' &raquo; <a href="'.home_url('/tags').'">All Tags</a>';

	if ( is_category() ) {
		$breadcrumbs = single_cat_title( '', false );
		
		$cat_parents='';
		$catID = single_term_id_by_zww( '', false );
		if ( $parentIDs = get_ancestors($catID, 'category') ) {
			$parentIDs = array_reverse($parentIDs);
			foreach ($parentIDs as $parentID) {
				$cat_parents .= ' &raquo; <a href="'. get_category_link($parentID) .'">'. get_cat_name($parentID) .'</a>';
			}
		}
		$breadcrumbs = $home.$categories.$cat_parents. ' &raquo; <h1>' .$breadcrumbs. '</h1>';
	} elseif ( is_tag() ) {
		$breadcrumbs = single_tag_title( '', false );
		$breadcrumbs = $home.$tags. ' &raquo; <h1>'.$breadcrumbs.'</h1>';
	} elseif ( is_date() ) {
		$breadcrumbs='';
		if(is_day()) {
			$breadcrumbs = date('M',get_the_date('U')).get_the_date(' jS, Y');
		} elseif(is_year()) {
			$breadcrumbs = get_the_date('Y');
		} else {
			$breadcrumbs = date('M',get_the_date('U')).get_the_date(', Y');
		}
		$breadcrumbs = $home. ' &raquo; Date Archives: <h1>' .$breadcrumbs. '</h1>';
	} elseif ( is_author() ) {
		$curauth = get_userdata_in_author_archive();
		$breadcrumbs = $home. ' &raquo; Archives for <h1><a href="' . esc_url( get_author_posts_url( get_the_author_meta('ID',$curauth->ID) ) ). '" title="' .esc_attr( $curauth->display_name ). '" rel="author">' .$curauth->display_name. '</a></h1>';
	} elseif ( is_post_type_archive()=='zsay' ) {
		$breadcrumbs = $home. ' &raquo; zwwooooo: Say/Share/Be interested ...';
	} elseif ( is_tax('archives_category') ){
		$categories = ' &raquo; <a href="'.home_url('/categories').'">Old Categories</a>';
		$breadcrumbs = single_term_title('', false);
		$cat_parents='';
		$catID = single_term_id_by_zww( '', false );
		if ( $parentIDs=get_ancestors($catID, 'archives_category') ) {
			$parentIDs=array_reverse($parentIDs);
			foreach ($parentIDs as $parentID) {
				$term=get_term($parentID, 'archives_category');
				$cat_parents .= ' &raquo; <a href="'. get_term_link($parentID, 'archives_category') .'">'. $term->name .'</a>';
			}
		}
		$breadcrumbs = $home.$categories.$cat_parents. ' &raquo; <h1>' .$breadcrumbs. '</h1>';
	} elseif ( is_tax('archives_tag') ){
		$tags= ' &raquo; <a href="'.home_url('/tags').'">Old Tags</a>';
		$breadcrumbs = single_term_title('', false);
		$breadcrumbs = $home.$tags. ' &raquo; <h1>'.$breadcrumbs.'</h1>';
	} else {
		$breadcrumbs=$home. ' &raquo; Blog Archives';
	}
	?>
	<nav class="breadcrumbs">
		<?php echo $breadcrumbs; ?>
		<?php if ($paged > 1 ) echo ' | Page ', $paged; ?>
	</nav>

	<?php while (have_posts()) : the_post();?>

		<article class="post" id="post-<?php the_ID(); ?>">

			<?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<div class="post-meta">
				<?php echo date('M',get_the_time('U')), get_the_time(' jS, Y'); ?>
				| <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
				<?php
				if (get_the_category()) { echo '| '; the_category(', '); }
				if (get_post_type()=='archives') echo '| ', get_the_term_list( $post->ID, 'archives_category', '', ', ', '');
				?>
				<?php if(function_exists('custom_the_views')) { _e('| '); custom_the_views($posd->ID); } ?>
				| <?php comments_popup_link('0 Comment', '1 Comment', '% Comment'); ?>
				<?php edit_post_link('Edit', '[', ']'); ?>
			</div>
			<div class="entry">
				<p><?php echo z_substr(strip_tags(apply_filters('the_content', $post->post_content)), 0, 180); ?></p>
				<p><a class="more-link" href="<?php the_permalink(); ?>" rel="nofollow">Read more...</a></p>
			</div>

		</article>

	<?php endwhile; ?>

<?php else: ?>

	<article class="post">
		<div class="entry">
			<p>Sorry, but you are looking for something that isn't here.</p>
			<p><strong>Random Posts</strong></p>
			<ul>
				<?php
					$rand_posts = get_posts('numberposts=5&orderby=rand');
					foreach( $rand_posts as $post ) :
				?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</article>

<?php endif; ?>

<?php zwwooooo_content_nav('pagination'); ?>

</div><!--content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>