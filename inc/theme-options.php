<?php
/**
 * Theme Options (Customizer)
 */
add_action( 'customize_register', 'zoo_customize_register' );
function zoo_customize_register( $wp_customize ) {

	/**
	 * section: zsimple_themes_page_option_section
	 */
	$wp_customize->add_section( 'zsimple_themes_page_option_section' , array(
		'title'       => 'zSimple 主题设置',
		'priority'    => 130,
		'description' => '',
	) );

	//settings
	$wp_customize->add_setting( 'zsimple_theme_options[ztheme_free_ids]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh', // refresh or postMessage
		'type'           => 'option',
		'default'        => '26017',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[ztheme_premium_ids]', array(
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		'transport'      => 'refresh', // refresh or postMessage
		'default'        => '25509',
	) );

	//control
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ztheme_free_ids_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[ztheme_free_ids]',
		'type'        => 'text',
		'label'      => '免费主题发布文章IDs',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ztheme_premium_ids_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[ztheme_premium_ids]',
		'type'        => 'text',
		'label'      => '付费主题发布文章IDs',
		'description' => '',
	) ) );

	/**
	 * section: zsimple_sidebar_ad_area_section
	 */
	$wp_customize->add_section( 'zsimple_sidebar_ad_area_section' , array(
		'title'       => '侧边栏广告',
		'priority'    => 155,
		'description' => '',
	) );

	//settings
	$wp_customize->add_setting( 'zsimple_theme_options[sidebar_ad_area_img_ad]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[sidebar_ad_area_long_text_ad]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[sidebar_ad_area_long_text_ad_only_home]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'refresh', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );

	//control
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_ad_area_img_ad_html_id', array(
		'label'       => '侧边栏图片广告区代码',
		'section'     => 'zsimple_sidebar_ad_area_section',
		'settings'    => 'zsimple_theme_options[sidebar_ad_area_img_ad]',
		'type'        => 'textarea',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_ad_area_long_text_ad_html_id', array(
		'label'       => '侧边栏长文本广告代码',
		'section'     => 'zsimple_sidebar_ad_area_section',
		'settings'    => 'zsimple_theme_options[sidebar_ad_area_long_text_ad]',
		'type'        => 'textarea',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'sidebar_ad_area_long_text_ad_only_home_html_id', array(
		'label'       => '侧边栏长文本广告代码[首页]',
		'section'     => 'zsimple_sidebar_ad_area_section',
		'settings'    => 'zsimple_theme_options[sidebar_ad_area_long_text_ad_only_home]',
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

function zoo_customize_backend_init(){
wp_enqueue_script('zoo_theme_customizer', ZOO_THEME_URI . '/js/customizer.js');
}
add_action( 'customize_controls_enqueue_scripts', 'zoo_customize_backend_init' );
*/