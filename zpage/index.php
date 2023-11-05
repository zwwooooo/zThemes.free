<?php get_header(); global $zpage_theme_options; ?>

<div id="content" class="content">

<?php if (have_posts()) : ?>

	<?php if ( is_home() || is_front_page() ){ ?>
			<nav class="breadcrumbs"<?php if ($paged < 2) echo ' id="post-zsay-rc"'; ?>>
				You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
				<?php if ($paged > 1 ) echo '&raquo; All posts | Page ', $paged; ?>
			</nav>
	<?php } ?>

	<?php if (is_search()) : ?>
		<nav class="breadcrumbs">
			You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
			&raquo; <?php echo sprintf( '<h1>Search Results for <strong>%s</strong></h1>', get_search_query() ); ?>
			<?php if ($paged > 1) echo '| Page ', $paged; ?>
		</nav>
	<?php endif; ?>

	<?php while (have_posts()) : the_post();?>

		<article class="post" id="post-<?php the_ID(); ?>">

			<?php the_title( '<h2 class="title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<div class="post-meta">
				<?php if ($paged<2) {
					if (is_sticky()) {
						echo '<span class="sticky-mark">Sticky post!</span>';
					} else {
						echo time_since_zww('post',get_the_time('U'),7,'',true);
					}
				} else {
					echo date('M',get_the_time('U')), get_the_time(' jS, Y');
				} ?>
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