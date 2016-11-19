<?php get_header(); ?>

<div id="content" class="col-8 content">
	<nav class="breadcrumbs">
		You are here: <a class="first_home" rel="nofollow" title="Go to homepage" href="<?php echo home_url('/'); ?>">Home</a>
		&raquo; 404 Error - Not found
	</nav>

	<article class="post">
		<h1 class="title" style="padding-left: 0;">404 Error - Not found</h1>
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

</div><!--content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>