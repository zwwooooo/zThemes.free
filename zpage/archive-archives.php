<?php get_header(); ?>

<div id="content" class="content">
	<nav class="breadcrumbs">
		You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
		&raquo; Archives
	</nav>

	<?php the_post(); ?>
	<article class="post page">
		<h1 class="title">Archives</h1>
		<div class="entry">
			<?php zww_archives_list(); ?>
		</div>
	</article>

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>

