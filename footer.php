		<div class="clear"></div>
		<span class="w_i_bg_l"></span>
		<span class="w_i_bg_r"></span>
	</div><!--.wrapper_inner-->
</div><!--#wrapper-->

<div id="footer">
	<div class="footer_inner">
		<div class="footer_content">
			<?php _e('Copyright', 'zborder'); ?> &copy; <?php echo date("Y"); ?> <a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a>
			<span class="sepa">|</span> <?php printf(__('%1$s powered by %2$s', 'zborder'), '<a href="http://zww.me" title="zBorder Theme">zBorder Theme</a>', '<a href="http://wordpress.org/">WordPress</a>'); ?>
		</div>
		<a class="back_to_top" href="javascript:scroll(0,0)" rel="nofollow" title="<?php _e('Back to top', 'zborder'); ?>">&#9650;</a>
	</div>
	<span class="back_to_top_mobile"><a href="#" rel="nofollow" title="<?php _e('Back to top', 'zborder'); ?>">&#9650;</a></span>
</div>

<?php wp_footer(); ?>
</body>
</html>