<?php get_header(); ?>

<div id="content" class="content">
	<nav class="breadcrumbs">
		You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
		&raquo; <?php the_title(); ?>
	</nav>

	<?php the_post(); ?>
	<article class="post" id="post-<?php the_ID(); ?>">
		<?php the_title( '<h1 class="title">', '</h1>' ); ?>
		<div class="entry">
			<?php the_content(); ?>
			<?php wp_link_pages('before=<div class="wp_link_pages"><strong>'. __('Pages:', 'zpage') . '</strong>&after=</div>&next_or_number=number&pagelink=<span class="page_number">%</span>'); ?>
			<div id="categories">
				<h3>New Categories (2013)</h3>
				<ul class="cf">
					<?php wp_list_categories( array(
						'taxonomy'  => 'category',
						'title_li'   => '',
						'depth'      => 2,
						'show_count' => 1
					) ); ?>
				</ul>
				<h3>Old Categories</h3>
				<ul class="cf">
					<?php wp_list_categories( array(
						'taxonomy'  => 'archives_category',
						'title_li'   => '',
						'depth'      => 2,
						'show_count' => 1
					) ); ?>
				</ul>
			</div>
		</div>
	</article>

	<div class="post-commentlist"><?php comments_template( '', true ); ?></div>

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>