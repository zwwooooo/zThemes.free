<?php
//////// Theme Options
function zborder_theme_options_items() {
	$items = array (
		array(
			'id'     => 'custom_favicon',
			'name'   => __('Custom Favicon', 'zborder'),
			'desc'   => __('Put your full favicon image address here.(with http://).', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'logo_url',
			'name' => __('Logo URL', 'zborder'),
			'desc' => __('Put your full logo image address here.(with http://) Image size: 200px*100px', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'hide_desc',
			'name' => __('Hide description', 'zborder'),
			'desc' => __('You can hide description here.', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => 'checkbox'
		),
		array(
			'id' => 'header_image_url',
			'name' => __('Header image link', 'zborder'),
			'desc' => __('Custom header image link. The default is Home Page.', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'rss_url',
			'name' => __('RSS URL', 'zborder'),
			'desc' => __('Put your full rss subscribe address here.(with http://)', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'excerpt_check',
			'name' => __('Excerpt?', 'zborder'),
			'desc' => __('If excerpt of posts display in home and archive page, check.', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => 'checkbox'
		),
		array(
			'id' => 'comment_notes',
			'name' => __('Disable the comment notes','zborder'),
			'desc' => __('Disabling this will remove the note text that displays with more options for adding to comments (html).', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => 'checkbox'
		),
		array(
			'id' => 'smilies',
			'name' => __('Disable the comments smilies','zborder'),
			'desc' => __('Disabling this will remove the comments smilies.', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => 'checkbox'
		),
		array(
			'id' => 'twitter_url',
			'name' => __('twitter URL', 'zborder'),
			'desc' => __('Put your full twitter address here.(with http:// , leave it blank for display none.)<br /><strong>This can be replaced by the following custom.</strong>', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '1',
			'nTitle' => __('Social Links', 'zborder'),
			'type'   => ''
		),
		array(
			'id' => 'twitter_custom_name',
			'name' => __('Custom social network name', 'zborder'),
			'desc' => __('Social network name', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'twitter_custom_icon',
			'name' => __('Custom social network icon', 'zborder'),
			'desc' => __('Social network icon address: (image size: 26px*26px)', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'twitter_custom_url',
			'name' => __('Custom social network url', 'zborder'),
			'desc' => __('Social network links address', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'facebook_url',
			'name' => __('facebook URL', 'zborder'),
			'desc' => __('Put your full facebook address here.(with http:// , leave it blank for no display none.)<br /><strong>This can be replaced by the following custom.</strong>', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'facebook_custom_name',
			'name' => __('Custom social network name', 'zborder'),
			'desc' => __('Social network name', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'facebook_custom_icon',
			'name' => __('Custom social network icon', 'zborder'),
			'desc' => __('Social network icon address: (image size: 26px*26px)', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'facebook_custom_url',
			'name' => __('Custom social network url', 'zborder'),
			'desc' => __('Social network links address', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'googleplus_url',
			'name' => __('Google+ URL', 'zborder'),
			'desc' => __('Put your full Google+ address here.(with http:// , leave it blank for no display none.)<br /><strong>This can be replaced by the following custom.</strong>', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'googleplus_custom_name',
			'name' => __('Custom social network name', 'zborder'),
			'desc' => __('Social network name', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'googleplus_custom_icon',
			'name' => __('Custom social network icon', 'zborder'),
			'desc' => __('Social network icon address: (image size: 26px*26px)', 'zborder'),
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id' => 'googleplus_custom_url',
			'name' => __('Custom social network url', 'zborder'),
			'desc' => __('Social network links address', 'zborder'),
			'std'    => '',
			'hr'     => '1',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		)
	);
	return $items;
}

add_action( 'admin_init', 'zborder_theme_options_init' );
add_action( 'admin_menu', 'zborder_theme_options_add_page' );
function zborder_theme_options_init(){
	register_setting( 'zborder_options', 'zborder_theme_options', 'zborder_options_validate' );
}
function zborder_theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'zborder' ), __( 'Theme Options', 'zborder' ), 'edit_theme_options', 'theme_options', 'zborder_theme_options_do_page' );
}
function zborder_default_options() {
	$options = get_option( 'zborder_theme_options' );
	foreach ( zborder_theme_options_items() as $item ) {
		if ( ! isset( $options[$item['id']] ) ) {
			if ( !empty($item['std']) )
				$options[$item['id']] = $item['std'];
			else
				$options[$item['id']] = '';
		}
	}
	update_option( 'zborder_theme_options', $options );
}
add_action( 'init', 'zborder_default_options' );
function zborder_theme_options_do_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	if( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) {
		delete_option( 'zborder_theme_options' );
		zborder_default_options();
	}
?>
	<div class="wrap zborder_wrap">

		<style>
			.zborder_wrap label{cursor:text;}
			.has-sidebar-content{overflow:hidden;}
			.stuffbox h3{border-bottom:1px solid #e5e5e5;}
			.form-table, .form-table td, .form-table th, .form-table td p, .form-wrap label{font-size:12px;}
		</style>

		<?php screen_icon(); ?>
		<h2><?php echo sprintf( __( '%1$s Theme Options', 'zborder' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div class="inner-sidebar">
				<div style="position:relative;" class="meta-box-sortabless ui-sortable" id="side-sortables">
					<div class="postbox" id="sm_pnres">
								<h3 class="hndle"><span><?php _e('Donation','zborder'); ?></span></h3>
								<div class="inside" style="margin:0;padding-top:10px;background-color:#ffffe0;">
									<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
										<?php printf(__('Created, Developed and maintained by %s . If you feel my work is useful and want to support the development of more free resources, you can donate me. Thank you very much!','zborder'), '<a href="http://zww.me">zwwooooo</a>'); ?>
											<br /><br />
											<input type="hidden" name="cmd" value="_s-xclick">
											<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
											">
											<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
											<img alt="" border="0" src="https://www.paypal.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
									</form>
								</div>
						</div>
				</div>
			</div>
			<div class="has-sidebar-content" id="post-body-content">
				<form method="post" action="options.php">
					<?php settings_fields( 'zborder_options' ); ?>
					<?php $options = get_option( 'zborder_theme_options' ); ?>
					<div class="stuffbox" style="padding-bottom:10px;">
						<h3><label for="link_url"><?php _e( 'General settings', 'zborder' ); ?></label></h3>
						<div class="inside">
							<table class="form-table">
							<?php foreach (zborder_theme_options_items() as $item) {
							
								$zborder_name = $item['name'];
								$zborder_form_name = 'zborder_theme_options['.$item['id'].']';
								$zborder_value = !empty($options[$item['id']]) ? $options[$item['id']] : $item['std'];
								$checked = $zborder_value ? ' checked="checked"' : '';
							?>

								<?php if ($item['type'] == 'checkbox') { ?>
								
		<?php if ($item['nTable']) { ?>
							</table>
						</div>
					</div>
					<div class="stuffbox" style="padding-bottom:10px;">
						<h3><label for="link_url"><?php echo $item['nTitle']; ?></label></h3>
						<div class="inside">
							<table class="form-table">
		<?php } ?>
									<tr valign="top">
										<th scope="row"><strong><?php echo $zborder_name; ?></strong></th>
										<td>
											<input name="<?php echo $zborder_form_name; ?>" type="checkbox" value="true" <?php echo $checked; ?> />
											<label class="description" for="<?php echo $zborder_form_name; ?>"><?php echo $item['desc']; ?></label>
										</td>
									</tr>
									<?php if ($item['hr']) echo '<tr valign="top"><th style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </th><td style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </td></tr>'; ?>

								<?php } elseif ($item['type'] == 'code') { ?>
								
		<?php if ($item['nTable']) { ?>
							</table>
						</div>
					</div>
					<div class="stuffbox" style="padding-bottom:10px;">
						<h3><label for="link_url"><?php echo $item['nTitle']; ?></label></h3>
						<div class="inside">
							<table class="form-table">
		<?php } ?>
									<tr valign="top">
										<th scope="row"><strong><?php echo $zborder_name; ?></strong></th>
										<td>
											<textarea name="<?php echo $zborder_form_name; ?>" type="code" cols="65%" rows="4"><?php echo $zborder_value; ?></textarea>
											<br/>
											<label class="description" for="<?php echo $zborder_form_name; ?>"><?php echo $item['desc']; ?></label>
										</td>
									</tr>
									<?php if ($item['hr']) echo '<tr valign="top"><th style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </th><td style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </td></tr>'; ?>

								<?php } else { ?>
								
		<?php if ($item['nTable']) { ?>
							</table>
						</div>
					</div>
					<div class="stuffbox" style="padding-bottom:10px;">
						<h3><label for="link_url"><?php echo $item['nTitle']; ?></label></h3>
						<div class="inside">
							<table class="form-table">
		<?php } ?>
									<tr valign="top">
										<th scope="row"><strong><?php echo $zborder_name; ?></strong></th>
										<td>
											<input name="<?php echo $zborder_form_name; ?>" type="text" value="<?php echo $zborder_value; ?>" size="40" />
											<br/>
											<label class="description" for="<?php echo $zborder_form_name; ?>"><?php echo $item['desc']; ?></label>
										</td>
									</tr>
									<?php if ($item['hr']) echo '<tr valign="top"><th style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </th><td style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </td></tr>'; ?>

								<?php } ?>

							<?php } ?>
							</table>
						</div>
					</div>
					<p class="submit" style="margin:0;padding:0;">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'zborder' ); ?>" />
					</p>
				</form>
				<form method="post" style="position:relative;margin:0;padding:0;">
					<input class="button" name="reset" type="submit" value="<?php _e('Reset All Settings','zborder'); ?>" onclick="return confirm('<?php _e('Click OK to reset. Any settings will be lost!', 'zborder'); ?>');" style="position:absolute;left:120px;top:-28px;" />
					<input type="hidden" name="action" value="reset" />
				</form>
			</div>
		</div>
	</div>
<?php
}

function zborder_options_validate($input) {
	return apply_filters( 'zborder_options_validate', $input);
}

//////// Add Favicon
function zborder_favicon() {
	global $zborder_theme_options;
	if ( !empty($zborder_theme_options['custom_favicon']) ) {
		echo '<link rel="shortcut icon" href="'. $zborder_theme_options['custom_favicon'] .'"/>'."\n";
	}
	else { ?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/imgs/favicon.ico" />
<?php }
}
add_action('wp_head', 'zborder_favicon');
