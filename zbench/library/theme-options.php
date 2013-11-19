<?php
//////// Theme Options
function zbench_options_items() {
	$items = array (
		array(
			'id' => 'logo_url',
			'name' => __('Logo URL', 'zbench'),
			'desc' => __('Put your full logo image address here.(with http://) Image Height: 36px', 'zbench')
		),
		array(
			'id' => 'hide_title',
			'name' => __('Hide the title and description', 'zbench'),
			'desc' => __('If your set the "Header image", you can check it to hide the title and description.', 'zbench')
		),
		array(
			'id' => 'header_image_url',
			'name' => __('Header image link', 'zbench'),
			'desc' => __('Custom header image link. The default is Home Page.', 'zbench')
		),
		array(
			'id' => 'rss_url',
			'name' => __('RSS URL', 'zbench'),
			'desc' => __('Put your full rss subscribe address here.(with http://)', 'zbench')
		),
		array(
			'id' => 'twitter_url',
			'name' => __('twitter URL', 'zbench'),
			'desc' => __('Put your full twitter address here.(with http:// , leave it blank for display none.)', 'zbench')
		),
		array(
			'id' => 'facebook_url',
			'name' => __('facebook URL', 'zbench'),
			'desc' => __('Put your full facebook address here.(with http:// , leave it blank for no display none.)', 'zbench')
		),
		array(
			'id' => 'googleplus_url',
			'name' => __('Google+ URL', 'zbench'),
			'desc' => __('Put your full Google+ address here.(with http:// , leave it blank for no display none.)', 'zbench')
		),
		array(
			'id' => 'social_network_1_name',
			'name' => __('Custom social network 1', 'zbench'),
			'desc' => __('Social network name:', 'zbench')
		),
		array(
			'id' => 'social_network_1_img',
			'name' =>'Custom social network 1 icon',
			'desc' => __('Social network icon address: (image size limits: 16px*16px)', 'zbench')
		),
		array(
			'id' => 'social_network_1_url',
			'name' => 'Custom social network 1 url',
			'desc' => __('Social network links address:', 'zbench')
		),
		array(
			'id' => 'social_network_2_name',
			'name' => __('Custom social network 2', 'zbench'),
			'desc' => __('Social network name:', 'zbench')
		),
		array(
			'id' => 'social_network_2_img',
			'name' => 'Custom social network 2 icon',
			'desc' => __('Social network icon address: (image size limits: 16px*16px)', 'zbench')
		),
		array(
			'id' => 'social_network_2_url',
			'name' => 'Custom social network 2 url',
			'desc' => __('Social network links address:', 'zbench')
		),
		array(
			'id' => 'left_sidebar',
			'name' => __('The left Sidebar style?', 'zbench'),
			'desc' => __('If like "left Sidebar style", check.', 'zbench')
		),
		array(
			'id' => 'excerpt_check',
			'name' => __('Excerpt?', 'zbench'),
			'desc' => __('If excerpt of posts display in home and archive page, check.', 'zbench')
		),
		array(
			'id' => 'comment_notes',
			'name' => __('Disable the comment notes','zbench'),
			'desc' => __('Disabling this will remove the note text that displays with more options for adding to comments (html).', 'zbench')
		),
		array(
			'id' => 'smilies',
			'name' => __('Disable the comments smilies','zbench'),
			'desc' => __('Disabling this will remove the comments smilies.', 'zbench')
		)
	);
	return $items;
}

add_action( 'admin_init', 'zbench_theme_options_init' );
add_action( 'admin_menu', 'zbench_theme_options_add_page' );
function zbench_theme_options_init(){
	register_setting( 'zbench_options', 'zBench_options', 'zbench_options_validate' );
}
function zbench_theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'zbench' ), __( 'Theme Options', 'zbench' ), 'edit_theme_options', 'theme_options', 'zbench_theme_options_do_page' );
}

function zbench_default_options() {
	$options = get_option( 'zBench_options' );
	foreach ( zbench_options_items() as $item ) {
		if ( ! isset( $options[$item['id']] ) ) {
			$options[$item['id']] = '';
		}
	}
	update_option( 'zBench_options', $options );
}
add_action( 'init', 'zbench_default_options' );

function zbench_theme_options_do_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	if( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) {
		delete_option( 'zBench_options' );
		zbench_default_options();
	}
?>
	<div class="wrap zbench_wrap">
		<style>.zbench_wrap label{cursor:text;}</style>
		<?php screen_icon(); echo "<h2>" . sprintf( __( '%1$s Theme Options', 'zbench' ), wp_get_theme() )	 . "</h2>"; ?>
		<?php settings_errors(); ?>
		<div id="poststuff" class="metabox-holder">
			<form method="post" action="options.php">
				<?php settings_fields( 'zbench_options' ); ?>
				<?php $options = get_option( 'zBench_options' ); ?>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'zbench' ); ?>" />
				</p>
				<div class="stuffbox" style="padding-bottom:10px;max-width:990px;">
					<h3><label for="link_url"><?php _e( 'Header settings', 'zbench' ); ?></label></h3>
					<table class="form-table">
					<?php foreach (zbench_options_items() as $item) { ?>
						<?php if ($item['id'] == 'hide_title' || $item['id'] == 'excerpt_check' || $item['id'] == 'comment_notes' || $item['id'] == 'smilies' || $item['id'] == 'left_sidebar') { ?>
						<tr valign="top">
							<th scope="row"><?php echo $item['name']; ?></th>
							<td>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="checkbox" value="true" <?php if ( $options[$item['id']] ) { $checked = "checked=\"checked\""; } else { $checked = ""; } echo $checked; ?> />
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
							</td>
						</tr>
						<?php } elseif ($item['id'] == 'social_network_1_name') { ?>
						<tr valign="top">
							<th scope="row"><?php echo $item['name']; ?></th>
							<td>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
								<br/>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="20" />
						<?php } elseif ($item['id'] == 'social_network_1_img') { ?>
								<br/>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
								<br/>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="60" />
						<?php } elseif ($item['id'] == 'social_network_1_url') { ?>
								<br/>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
								<br/>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="60" />
							</td>
						</tr>
						<?php } elseif ($item['id'] == 'social_network_2_name') { ?>
						<tr valign="top">
							<th scope="row"><?php echo $item['name']; ?></th>
							<td>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
								<br/>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="20" />
						<?php } elseif ($item['id'] == 'social_network_2_img') { ?>
								<br/>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
								<br/>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="60" />
						<?php } elseif ($item['id'] == 'social_network_2_url') { ?>
								<br/>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
								<br/>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="60" />
							</td>
						</tr>
					</table>
				</div>
				<div class="stuffbox" style="padding-bottom:10px;max-width:990px;">
					<h3><label for="link_url"><?php _e( 'General settings', 'zbench' ); ?></label></h3>
					<table class="form-table">
						<?php } else { ?>
						<tr valign="top">
							<th scope="row"><?php echo $item['name']; ?></th>
							<td>
								<input name="<?php echo 'zBench_options['.$item['id'].']'; ?>" type="text" value="<?php if ( $options[$item['id']] != "") { echo $options[$item['id']]; } else { echo ''; } ?>" size="60" />
								<br/>
								<label class="description" for="<?php echo 'zBench_options['.$item['id'].']'; ?>"><?php echo $item['desc']; ?></label>
							</td>
						</tr>
						<?php } ?>
						<?php if ($item['id'] == 'header_image_url') { ?>
					</table>
				</div>
				<div class="stuffbox" style="padding-bottom:10px;max-width:990px;">
					<h3><label for="link_url"><?php _e( 'Social network settings', 'zbench' ); ?></label></h3>
					<table class="form-table">
						<?php } ?>
					<?php } ?>
					</table>
				</div>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'zbench' ); ?>" />
				</p>
			</form>
			<div style="position:relative;">
			<form method="post">
				<p class="submit" style="position:absolute;left:130px;top:-65px;margin:0;">
					<input class="button" name="reset" type="submit" value="<?php _e('Reset All Settings','zbench'); ?>" onclick="return confirm('<?php _e('Click OK to reset. Any settings will be lost!', 'zbench'); ?>');" />
					<input type="hidden" name="action" value="reset" />
				</p>
			</form>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="max-width:990px;">
				<div class="stuffbox" style="max-width:990px;background-color:#ffffe0;border:1px solid #e6db55;">
					<h3><label for="link_url"><strong><?php _e('Donation','zbench'); ?></strong></label></h3>
					<div style="padding:10px;">
						<?php printf(__('Created, Developed and maintained by %s . If you feel my work is useful and want to support the development of more free resources, you can donate me. Thank you very much!','zbench'), '<a href="http://zww.me">zwwooooo</a>'); ?>
						<br /><br />
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
						">
						<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
					</div>
				</div>
			</form>
			</div>
		</div>
<?php
}
function zbench_options_validate($input) {
	return apply_filters( 'zbench_options_validate', $input);
}