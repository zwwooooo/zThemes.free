<?php
/**
 * Template Name: 存档页面
 */
?>
<?php get_header(); ?>

<div id="content" class="col-8 content">
	<nav class="breadcrumbs">
		您在这里: <a class="first_home" rel="nofollow" title="返回首页" href="<?php echo home_url('/'); ?>">首页</a>
		&raquo; 存档
	</nav>

	<?php the_post(); ?>
	<article class="post page">
		<h1 class="title" style="padding-left: 0;">存档</h1>
		<div class="entry">
			<?php the_content(); ?>
			<?php wp_link_pages('before=<div class="wp_link_pages"><strong>'. __('分页: ', 'zsimple') . '</strong>&after=</div>&next_or_number=number&pagelink=<span class="page_number">%</span>'); ?>
			<?php zoo_archives_list('post'); ?>
		</div>
	</article>

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>

