<?php
/**
 * Template Name: 存档页面
 */
?>
<?php get_header(); ?>

<div id="content" class="col-8 content">
	<nav class="breadcrumbs">
		You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
		&raquo; Archives
	</nav>

	<?php the_post(); ?>
	<article class="post page">
		<h1 class="title" style="padding-left: 0;">Archives</h1>
		<div class="entry">
			<?php zoo_archives_list('post'); ?>
		</div>
	</article>

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>

