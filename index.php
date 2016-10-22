<?php get_header(); ?>

<div id="content" class="col-8 content">

<?php if (have_posts()) : ?>

	<?php if ( is_home() || is_front_page() ){ ?>
			<nav class="breadcrumbs">
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
						echo '<span class="sticky-mark">Sticky post!</span>';
					} else {
						echo zoo_time_since('post',get_the_time('U'),7,'',true);
					}
				} else {
					echo date('M',get_the_time('U')), get_the_time(' jS, Y');
				}
				if (get_the_category()) { echo ' | '; the_category(', '); }
				?>
				<?php if (function_exists('the_views')) { echo '| '; the_views(); } ?>
				| <?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?>
				<?php edit_post_link('Edit', '[', ']'); ?>
			</div>
			<?php if ($class) { ?>
				<a class="thumb-img" href="<?php the_permalink(); ?>" style="background-image:url(<?php echo $thumb_img_src; ?>);"></a>
			<?php } ?>

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

<?php zoo_content_nav('pagination'); ?>

</div><!--content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>