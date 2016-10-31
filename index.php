<?php get_header(); ?>

<div id="content" class="col-8 content">

<?php if (have_posts()) : ?>

	<?php if ( is_home() || is_front_page() ){ ?>
			<nav class="breadcrumbs">
				您在这里: <a class="first_home" rel="nofollow" title="返回首页" href="<?php echo home_url('/'); ?>">首页</a>
				<?php if ($paged > 1 ) echo '&raquo; 全部文章 | 第', $paged, '页'; ?>
			</nav>
	<?php } ?>

	<?php if (is_search()) : ?>
		<nav class="breadcrumbs">
			您在这里: <a class="first_home" rel="nofollow" title="返回首页" href="<?php echo home_url('/'); ?>">首页</a>
			&raquo; <?php echo sprintf( '<h1>搜索结果: <strong>%s</strong></h1>', get_search_query() ); ?>
			<?php if ($paged > 1) echo '| Page ', $paged; ?>
		</nav>
	<?php endif; ?>

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
				<?php if ($paged<2) {
					if (is_sticky()) {
						echo '<span class="sticky-mark">置顶!</span>';
					} else {
						echo zoo_time_since('post',get_the_time('U'),7,'',true);
					}
				} else {
					the_time(get_option('date_format')); //echo date('M',get_the_time('U')), get_the_time(' jS, Y');
				}
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