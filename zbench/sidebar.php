<div id="sidebar-border">
	<div id="rss_border">
		<div class="rss_border">
			<div id="rss_wrap">
				<div class="rss_wrap">
					<?php global $zbench_options; $rss_text='';
					if($zbench_options['twitter_url'] == '' && $zbench_options['facebook_url'] == '' && $zbench_options['googleplus_url'] == '') $rss_text='rss_text'; ?>
					<a class="rss <?php echo $rss_text;?>" href="<?php if($zbench_options['rss_url'] != '') { echo($zbench_options['rss_url']); } else { bloginfo('rss2_url'); } ?>" rel="bookmark" title="<?php _e('RSS Feed', 'zbench'); ?>"><?php _e('RSS Feed', 'zbench'); ?></a>
					<?php if($zbench_options['twitter_url'] != '') : ?>
					<a class="twitter" href="<?php echo($zbench_options['twitter_url']); ?>" rel="author" title="<?php _e('Follow me on twitter.', 'zbench'); ?>"><?php _e('Follow me on twitter.', 'zbench'); ?></a>
					<?php endif; ?>
					<?php if($zbench_options['facebook_url'] != '') : ?>
					<a class="facebook" href="<?php echo($zbench_options['facebook_url']); ?>" rel="author" title="<?php _e('Facebook', 'zbench'); ?>"><?php _e('Facebook', 'zbench'); ?></a>
					<?php endif; ?>
					<?php if($zbench_options['googleplus_url'] != '') : ?>
					<a class="googleplus" href="<?php echo($zbench_options['googleplus_url']); ?>" rel="publisher" title="<?php _e('Google+', 'zbench'); ?>"><?php _e('Google+', 'zbench'); ?></a>
					<?php endif; ?>
					<?php if($zbench_options['social_network_1_name'] != '' && $zbench_options['social_network_1_img'] != '' && $zbench_options['social_network_1_url'] != '') : ?>
					<a style="background:url(<?php echo $zbench_options['social_network_1_img']; ?>) no-repeat 0 0;" href="<?php echo($zbench_options['social_network_1_url']); ?>" title="<?php echo($zbench_options['social_network_1_name']); ?>" rel="bookmark"><?php echo($zbench_options['social_network_1_name']); ?></a>
					<?php endif; ?>
					<?php if($zbench_options['social_network_2_name'] != '' && $zbench_options['social_network_2_img'] != '' && $zbench_options['social_network_2_url'] != '') : ?>
					<a style="background:url(<?php echo $zbench_options['social_network_2_img']; ?>) no-repeat 0 0;" href="<?php echo($zbench_options['social_network_2_url']); ?>" title="<?php echo($zbench_options['social_network_2_name']); ?>" rel="bookmark"><?php echo($zbench_options['social_network_2_name']); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<div id="sidebar">

<?php if ( !dynamic_sidebar('primary-widget-area') ) : ?>

<?php if ( is_singular() ) { ?>
	<div class="widget">
		<h3><?php _e('Recent Posts', 'zbench'); ?></h3>
		<ul>
			<?php
			$myposts = get_posts('numberposts=5&offset=0&category=0');
			foreach($myposts as $post) : setup_postdata($post);
			?>
			<li><span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php } else { ?>
	<div class="widget">
		<h3><?php _e('Random Posts', 'zbench'); ?></h3>
		<ul>
			<?php
			$rand_posts = get_posts('numberposts=5&orderby=rand');
			foreach( $rand_posts as $post ) :
			?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php } ?>
	<div class="widget">
		<h3><?php _e('Search by Tags!', 'zbench'); ?></h3>
		<div><?php wp_tag_cloud('smallest=9&largest=18'); ?></div>
	</div>	
	<div class="widget">
		<h3><?php _e('Archives', 'zbench'); ?></h3>
		<ul>
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>
	</div>
	<div class="widget">
		<h3><?php _e('Links', 'zbench'); ?></h3>
		<ul>
			<?php wp_list_bookmarks('title_li=&categorize=0&orderby=id'); ?>
		</ul>
	</div>
	<div class="widget">
		<h3><?php _e('Meta', 'zbench'); ?></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</div>

<?php endif; ?>

<?php if ( is_singular() ) { if ( is_active_sidebar('singular-widget-area') ) dynamic_sidebar('singular-widget-area'); } ?>
<?php if (!is_singular()) { if ( is_active_sidebar('not-singular-widget-area') ) dynamic_sidebar('not-singular-widget-area'); } ?>
<?php if ( is_active_sidebar('footer-widget-area') ) dynamic_sidebar('footer-widget-area'); ?>

	</div><!-- end: #sidebar -->
</div><!-- end: #sidebar-border -->