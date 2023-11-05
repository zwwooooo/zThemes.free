<?php
/*
//////// Theme Options
function zpage_theme_options_items() {
	$items = array (
		array(
			'id'     => 'ztheme_free_ids',
			'name'   => 'zTheme: Free',
			'desc'   => '免费主题发布文章IDs',
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		),
		array(
			'id'     => 'ztheme_premium_ids',
			'name'   => 'zTheme: Premium',
			'desc'   => '付费主题发布文章IDs',
			'std'    => '',
			'hr'     => '',
			'nTable' => '',
			'nTitle' => '',
			'type'   => ''
		)
	);
	return $items;
}

add_action( 'admin_init', 'zpage_theme_options_init' );
add_action( 'admin_menu', 'zpage_theme_options_add_page' );
function zpage_theme_options_init(){
	register_setting( 'zpage_options', 'zpage_theme_options', 'zpage_options_validate' );
}
function zpage_theme_options_add_page() {
	add_theme_page( __( 'Theme Options', 'zpage' ), __( 'Theme Options', 'zpage' ), 'edit_theme_options', 'theme_options', 'zpage_theme_options_do_page' );
}
function zpage_default_options() {
	$options = get_option( 'zpage_theme_options' );
	foreach ( zpage_theme_options_items() as $item ) {
		if ( ! isset( $options[$item['id']] ) ) {
			if ( !empty($item['std']) )
				$options[$item['id']] = $item['std'];
			else
				$options[$item['id']] = '';
		}
	}
	update_option( 'zpage_theme_options', $options );
}
add_action( 'init', 'zpage_default_options' );
function zpage_theme_options_do_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	if( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) {
		delete_option( 'zpage_theme_options' );
		zpage_default_options();
	}
?>
	<div class="wrap zpage_wrap">

		<style>
			.zpage_wrap label{cursor:text;}
			.has-sidebar-content{overflow:hidden;}
			.stuffbox h3{border-bottom:1px solid #e5e5e5;}
			.form-table, .form-table td, .form-table th, .form-table td p, .form-wrap label{font-size:12px;}
		</style>

		<?php screen_icon(); ?>
		<h2><?php echo sprintf( __( '%1$s Theme Options', 'zpage' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>
		<div id="poststuff" class="metabox-holder has-right-sidebar">
			<div class="inner-sidebar">
				<div style="position:relative;" class="meta-box-sortabless ui-sortable" id="side-sortables">
					<div class="postbox" id="sm_pnres">
								<h3 class="hndle"><span><?php _e('Donation','zpage'); ?></span></h3>
								<div class="inside" style="margin:0;padding-top:10px;background-color:#ffffe0;">
									<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
										<?php printf(__('Created, Developed and maintained by %s . If you feel my work is useful and want to support the development of more free resources, you can donate me. Thank you very much!','zpage'), '<a href="http://zww.me">zwwooooo</a>'); ?>
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
					<?php settings_fields( 'zpage_options' ); ?>
					<?php $options = get_option( 'zpage_theme_options' ); ?>
					<div class="stuffbox" style="padding-bottom:10px;">
						<h3><label for="link_url"><?php _e( 'General settings', 'zpage' ); ?></label></h3>
						<div class="inside">
							<table class="form-table">
							<?php foreach (zpage_theme_options_items() as $item) {
							
								$zpage_name = $item['name'];
								$zpage_form_name = 'zpage_theme_options['.$item['id'].']';
								$zpage_value = !empty($options[$item['id']]) ? $options[$item['id']] : $item['std'];
								$checked = $zpage_value ? ' checked="checked"' : '';
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
										<th scope="row"><strong><?php echo $zpage_name; ?></strong></th>
										<td>
											<input name="<?php echo $zpage_form_name; ?>" type="checkbox" value="true" <?php echo $checked; ?> />
											<label class="description" for="<?php echo $zpage_form_name; ?>"><?php echo $item['desc']; ?></label>
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
										<th scope="row"><strong><?php echo $zpage_name; ?></strong></th>
										<td>
											<textarea name="<?php echo $zpage_form_name; ?>" type="code" cols="65%" rows="4"><?php echo $zpage_value; ?></textarea>
											<br/>
											<label class="description" for="<?php echo $zpage_form_name; ?>"><?php echo $item['desc']; ?></label>
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
										<th scope="row"><strong><?php echo $zpage_name; ?></strong></th>
										<td>
											<input name="<?php echo $zpage_form_name; ?>" type="text" value="<?php echo $zpage_value; ?>" size="40" />
											<br/>
											<label class="description" for="<?php echo $zpage_form_name; ?>"><?php echo $item['desc']; ?></label>
										</td>
									</tr>
									<?php if ($item['hr']) echo '<tr valign="top"><th style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </th><td style="margin:0;padding:0;border-bottom:1px solid #ddd;"> </td></tr>'; ?>

								<?php } ?>

							<?php } ?>
							</table>
						</div>
					</div>
					<p class="submit" style="margin:0;padding:0;">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'zpage' ); ?>" />
					</p>
				</form>
				<form method="post" style="position:relative;margin:0;padding:0;">
					<input class="button" name="reset" type="submit" value="<?php _e('Reset All Settings','zpage'); ?>" onclick="return confirm('<?php _e('Click OK to reset. Any settings will be lost!', 'zpage'); ?>');" style="position:absolute;left:120px;top:-28px;" />
					<input type="hidden" name="action" value="reset" />
				</form>
			</div>
		</div>
	</div>
<?php
}

function zpage_options_validate($input) {
	return apply_filters( 'zpage_options_validate', $input);
}
*/

add_action( 'customize_register', 'zdo_customize_register' );
function zdo_customize_register( $wp_customize ) {

	/**
	 * section: zpage_themes_page_option_section
	 */
	$wp_customize->add_section( 'zpage_themes_page_option_section' , array(
		'title'       => 'Themes Page 设置',
		'priority'    => 130,
		'description' => '',
	) );

	//settings
	$wp_customize->add_setting( 'zpage_theme_options[ztheme_free_ids]', array(
		'default'        => '26017',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh'
	) );
	$wp_customize->add_setting( 'zpage_theme_options[ztheme_premium_ids]', array(
		'default'        => '25509',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh'
	) );

	//control
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ztheme_free_ids_html_id', array(
		'label'      => '免费主题发布文章IDs',
		'section'    => 'zpage_themes_page_option_section',
		'settings'   => 'zpage_theme_options[ztheme_free_ids]',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ztheme_premium_ids_html_id', array(
		'label'      => '付费主题发布文章IDs',
		'section'    => 'zpage_themes_page_option_section',
		'settings'   => 'zpage_theme_options[ztheme_premium_ids]',
		'description' => '',
	) ) );

	/**
	 * section: zpage_sidebar_ad_area_section
	 */
	$wp_customize->add_section( 'zpage_sidebar_ad_area_section' , array(
		'title'       => '侧边栏广告',
		'priority'    => 155,
		'description' => '',
	) );

	//settings
	$wp_customize->add_setting( 'zpage_theme_options[sidebar_ad_area_img_ad]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh'
	) );
	$wp_customize->add_setting( 'zpage_theme_options[sidebar_ad_area_long_text_ad]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh'
	) );
	$wp_customize->add_setting( 'zpage_theme_options[sidebar_ad_area_long_text_ad_only_home]', array(
		'default'        => '',
		'type'           => 'option',
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh'
	) );

	//control
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_ad_area_img_ad_html_id', array(
		'label'       => '侧边栏图片广告区代码',
		'section'     => 'zpage_sidebar_ad_area_section',
		'settings'    => 'zpage_theme_options[sidebar_ad_area_img_ad]',
		'type'        => 'textarea',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_ad_area_long_text_ad_html_id', array(
		'label'       => '侧边栏长文本广告代码',
		'section'     => 'zpage_sidebar_ad_area_section',
		'settings'    => 'zpage_theme_options[sidebar_ad_area_long_text_ad]',
		'type'        => 'textarea',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_ad_area_long_text_ad_only_home_html_id', array(
		'label'       => '侧边栏长文本广告代码[首页]',
		'section'     => 'zpage_sidebar_ad_area_section',
		'settings'    => 'zpage_theme_options[sidebar_ad_area_long_text_ad_only_home]',
		'type'        => 'textarea',
		'description' => '',
	) ) );
}

/* //有bug：html 模式点击编辑框会默认点击 strong 按钮，而且无法保存
if( class_exists('WP_Customize_Control') ) {
	class Customize_WP_Customize_Control_wysiwyg extends WP_Customize_Control {
		public $type = 'textarea';
		public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php
				$content = $this->value();
				$editor_id = $this->id;
				$settings = array( 'media_buttons' => true, 'drag_drop_upload'=>true );
				wp_editor( $content, $editor_id, $settings );
				?>
			</label>
		<?php }
	}
}

function zdo_customize_backend_init(){
wp_enqueue_script('zdo_theme_customizer', ZOO_THEME_URI . '/js/customizer.js');
}
add_action( 'customize_controls_enqueue_scripts', 'zdo_customize_backend_init' );
*/