<?php get_header(); ?>

<div id="content" class="content">
	<nav class="breadcrumbs">
		You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
		<?php
		if (get_the_category()) { echo ' &raquo; '; the_category(' &raquo; ', 'multiple'); }
		if (get_post_type()=='archives') echo ' &raquo; ', get_the_term_list( $post->ID, 'archives_category', '', ', ', '');
		?>
		&raquo; <?php the_title(); ?>
	</nav>

	<?php the_post(); ?>
	<article class="post" id="post-<?php the_ID(); ?>">
		<?php the_title( '<h1 class="title">', '</h1>' ); ?>
		<div class="post-meta">
			<?php echo date('M',get_the_time('U')), get_the_time(' jS, Y H:i'); ?>
			| <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php the_author(); ?></a>
			| <?php comments_popup_link('0 Comment', '1 Comment', '% Comment'); ?>
			<?php edit_post_link('Edit', '[', ']'); ?>
		</div>
		<div <?php if(get_post_type() == 'post') echo 'id="entry-single"'; ?> class="entry">
			<?php the_content(); ?>
			<?php wp_link_pages('before=<div class="wp_link_pages"><strong>'. 'Pages:' . '</strong>&after=</div>&next_or_number=number&pagelink=<span class="page_number">%</span>'); ?>
		</div>
		<?php if (get_post_type() != 'zsay') { ?>
			<div class="related-posts cf">
				<div class="rp-left">
					<h3 id="entry_fl">Related Posts</h3>
					<ul>
						<?php
						if (get_post_type() == 'archives') {
							zfunc_wp_cache( 'rp_'.$post->ID, 'zwwooooo_wp_cache', zfunc_related_posts(5, 'archives_category', 'archives_tag'), 28800);
						} else {
							zfunc_wp_cache( 'rp_'.$post->ID, 'zwwooooo_wp_cache', zfunc_related_posts(5), 28800);
						}
						?>
					</ul>
				</div>
				<div class="rp-right">
					<h3>Most Popular</h3>
					<ul>
						<?php
						if (get_post_type() == 'archives') {
							zfunc_wp_cache( 'zfunc_most_popular_archives', 'zwwooooo_wp_cache', zfunc_most_popular(5, 'archives'), 0);
						} else {
							zfunc_wp_cache( 'zfunc_most_popular', 'zwwooooo_wp_cache', zfunc_most_popular(5), 0);
						}
						?>
					</ul>
				</div>
				<span class="rp-bg-top"></span><span class="rp-bg-bottom"></span>
			</div>
		<?php } ?>
		<div id="nav-below" class="cf">
			<div class="nav-previous"><?php previous_post_link( '%link ', '%title' ); ?></div>
			<div class="nav-next"><?php if (get_next_post()) { next_post_link( ' %link', '%title' ); } else { echo '(This is the latest article)'; } ?></div>
		</div>
	</article>

	<div class="post-commentlist"><?php comments_template( '', true ); ?></div>

</div><!--content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>