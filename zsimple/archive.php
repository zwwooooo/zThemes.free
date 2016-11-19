<?php get_header(); global $zsimple_theme_options; ?>

<div id="content" class="col-8 content">

<?php if (have_posts()) : ?>

	<?php
	$home = '您在这里: <a class="first_home" rel="nofollow" title="返回首页" href="' . home_url('/') . '">首页</a>';
	$categories = (get_page_by_path('categories')) ? ' &raquo; <a href="'.home_url('/categories').'">全部分类</a>' : '';
	$tags= (get_page_by_path('tags')) ? ' &raquo; <a href="'.home_url('/tags').'">全部标签</a>' : '';

	if ( is_category() ) {
		$breadcrumbs = single_cat_title( '', false );
		
		$cat_parents='';
		$catID = zoo_single_term_id( '', false );
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
			$breadcrumbs = get_the_date(get_option('date_format'));
		} elseif(is_year()) {
			$breadcrumbs = get_the_date('Y年');
		} else {
			$breadcrumbs = get_the_date('Y年m月');
		}
		$breadcrumbs = $home. ' &raquo; 归档: <h1>' .$breadcrumbs. '</h1>';
	} elseif ( is_author() ) {
		$curauth = get_userdata_in_author_archive();
		$breadcrumbs = $home. ' &raquo; 作者: <h1><a href="' . esc_url( get_author_posts_url( get_the_author_meta('ID',$curauth->ID) ) ). '" title="' .esc_attr( $curauth->display_name ). '" rel="author">' .$curauth->display_name. '</a></h1>';
	} else {
		$breadcrumbs=$home. ' &raquo; 博客归档';
	}
	?>
	<nav class="breadcrumbs">
		<?php echo $breadcrumbs; ?>
		<?php if ($paged > 1 ) echo ' | 第', $paged, '页'; ?>
	</nav>

	<?php while (have_posts()) : the_post();?>

		<?php
		$num = 80;
		$class = '';
		if (function_exists('zoo_post_thumbnail')) {
			if ($thumb_img_src = zoo_post_thumbnail('thumbnail', 'src')) {
				$class = ' has-thumb';
				$num = 50;
			}
		}
		?>
		<article class="post<?php echo $class; ?>" id="post-<?php the_ID(); ?>">

			<div class="post-header">
				<?php
				if ( get_post_type() == 'post' ) {
					echo '<i class="p-type">Blog</i>';
				} elseif ( get_post_type() == 'page' ) {
					echo '<i class="p-type p-type-page">Page</i>';
				}
				?>
				<?php the_title( '<h2 class="title"><a class="tr-4s" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			</div>
			<div class="excerpt">
				<p><?php echo zoo_substr(strip_tags(apply_filters('the_content', $post->post_content)), 0, $num); ?></p>
			</div>
			<div class="post-meta">
				<?php the_time(get_option('date_format')); //echo date('M',get_the_time('U')), get_the_time(' jS, Y'); ?>
				| <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
				<?php
				if (get_the_category()) { echo ' | '; the_category(', '); }
				?>
				<?php if (function_exists('the_views')) { echo '| '; the_views(); } ?>
				| <?php comments_popup_link('没有评论', '1条评论', '%条评论'); ?>
				<?php edit_post_link('编辑', '[', ']'); ?>
			</div>
			<?php if ($class) { ?>
				<a class="thumb-img" href="<?php the_permalink(); ?>" style="background-image:url(<?php echo $thumb_img_src; ?>);"></a>
			<?php } ?>

		</article>

	<?php endwhile; ?>

<?php else: ?>

	<article class="post">
		<div class="post-header">
			<h2 class="title" style="padding-left: 0;">未找到</h2>
		</div>
		<div class="entry">
			<p>抱歉，没有符合您搜索条件的结果。请换其它关键词再试。</p>
		</div>
	</article>

<?php endif; ?>

<?php zoo_content_nav('pagination'); ?>

</div><!--content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>