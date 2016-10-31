<?php
global $zsimple_theme_options;
if ( isset($zsimple_theme_options['page_loading']) && $zsimple_theme_options['page_loading'] ) {
?>
	<script>(function(b,a,c){b(function(){b(".progressbar i").css("width","75%");});})(jQuery,window);</script>
<?php } ?>

<div class="col-4">
	<aside class="sidebar">
		<?php if ( !dynamic_sidebar('primary-widget-area') ) : ?>
			<div class="widget">
				<h3>最新评论</h3>
				<ul class="zsimple-rc">
					<?php zoo_wp_cache( 'zoo_rc_comments', 'simple_wp_cache', zoo_rc_comments(5), 0); ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if (is_singular()) { ?>
			<?php if ( !dynamic_sidebar('singular-widget-area') ) : ?>
				<div class="widget widget-mostactive">
					<h3>读者墙</h3>
					<div class="zsimple-mostactive"><?php zoo_wp_cache( 'zoo_mostactive', 'simple_wp_cache', zoo_mostactive(12, 1), 0); ?></div>
				</div>
			<?php endif; ?>
		<?php } else {	?>
			<?php if ( !dynamic_sidebar('not-singular-widget-area') ) : ?>
			<?php endif; ?>
		<?php }	?>


		<span id="respond-follow-start"></span>

	</aside>
</div>

<?php
if ( isset($zsimple_theme_options['page_loading']) && $zsimple_theme_options['page_loading'] ) {
?>
	<script>(function(b,a,c){b(function(){b(".progressbar i").css("width","85%");});})(jQuery,window);</script>
<?php } ?>
