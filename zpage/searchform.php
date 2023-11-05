<form id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" value="<?php _e('Search ...', 'zpage'); ?>" onfocus="if (this.value == '<?php _e('Search ...', 'zpage'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search ...', 'zpage'); ?>';}" size="35" maxlength="50" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="<?php _e('Search','zpage'); ?>" />
</form>