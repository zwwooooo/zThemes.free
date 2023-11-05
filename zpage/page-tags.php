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
			<div id="tags">
				<h3>New Tags</h3>
				<div class="tags">
					<?php
					$zww_tag_cloud_new = wp_tag_cloud( array(
						// 'taxonomy'  => array('post_tag', 'archives_tag'),
						'taxonomy'  => array('post_tag'),
						'echo'      => 0,
						'unit'      => 'px',
						'smallest'  => 12,
						'largest'   => 24,
						'number'    => 0,
						'separator' => ' '
					) );
					echo $zww_tag_cloud_new;
					?>
				</div>

				<h3>Old Tags</h3>
				<div class="tags">
					<?php
					$zww_tag_cloud_old = wp_tag_cloud( array(
						'taxonomy'  => array('archives_tag'),
						'echo'      => 0,
						'unit'      => 'px',
						'smallest'  => 12,
						'largest'   => 24,
						'number'    => 0,
						'separator' => ' '
					) );
					echo $zww_tag_cloud_old;
					?>

					<?php //wp_tag_cloud('echo=1&unit=px&smallest=12&largest=36&number=0&orderby=count&order=DESC&separator=, '); ?>
				</div>
			</div>
		</div>
	</article>

	<div class="post-commentlist"><?php comments_template( '', true ); ?></div>

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>