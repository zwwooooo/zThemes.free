<form id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" value="<?php _e('Search ...', 'zborder'); ?>" onfocus="if (this.value == '<?php _e('Search ...', 'zborder'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search ...', 'zborder'); ?>';}" size="35" maxlength="50" name="s" id="s" />
	<input type="submit" id="searchsubmit" value="<?php _e('Search','zborder'); ?>" />
</form>