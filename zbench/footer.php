</div><!--wrapper-->
<div class="clear"></div>
<div id="footer">
	<div id="footer-inside">
		<p>
			<?php _e('Copyright', 'zbench'); ?> &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>
			| <?php printf(__('Powered by %1$s and %2$s', 'zbench'), '<a href="http://zww.me">zBench</a>', '<a href="http://wordpress.org/">WordPress</a>'); ?>
		</p>
		<span id="back-to-top">&uarr; <a href="#" rel="nofollow" title="Back to top"><?php _e('Top', 'zbench'); ?></a></span>
	</div>
</div><!--footer-->

<script type="text/javascript">
	//////// Handles toggling the navigation menu for small screens
	( function() {
		var nav = document.getElementById( 'menus' ), button = document.getElementById( 'menus-m' ), menu = document.getElementById( 'menus-dt' );
		if ( ! nav ) {
			return;
		}
		if ( ! button ) {
			return;
		}
		// Hide button if menu is missing or empty.
		if ( ! menu || ! menu.childNodes.length ) {
			button.style.display = 'none';
			return;
		}
		button.onclick = function() {
			if ( -1 !== button.className.indexOf( 'b-toggled-on' ) ) {
				button.className = button.className.replace( ' b-toggled-on', '' );
				menu.className = menu.className.replace( ' toggled-on', '' );
			} else {
				button.className += ' b-toggled-on';
				menu.className += ' toggled-on';
			}
		};
	} )();
</script>

<?php wp_footer(); ?>
</body>
</html>