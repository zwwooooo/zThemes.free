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
		'description' => '<strong style="color:#d6492f;">支持主题作者？</strong><a href="http://zww.me/wordpress-theme-zsimple.z-turn#donation" target="_blank">去打赏 &raquo;</a>',
	) );

	//settings
	$wp_customize->add_setting( 'zsimple_theme_options[custom_admin_tools]', array(
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		'transport'      => 'postMessage', // refresh or postMessage
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[page_loading]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[chong_jiong]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[guess_comments]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[disable_before_title_tag]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[rp_and_mp]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[custom_smiley]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[default_thumb]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[auto_thumb]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[social1_name]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[social1_link]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[social2_name]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[social2_link]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[rss_name]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[rss_link]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );
	$wp_customize->add_setting( 'zsimple_theme_options[copyright]', array(
		'capability'     => 'edit_theme_options',
		'transport'      => 'postMessage', // refresh or postMessage
		'type'           => 'option',
		'default'        => '',
	) );

	//control
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'custom_admin_tools_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[custom_admin_tools]',
		'type'        => 'checkbox',
		'label'      => '启用自定义管理工具栏样式',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'page_loading_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[page_loading]',
		'type'        => 'checkbox',
		'label'      => '启用头部页面加载效果',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'chong_jiong_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[chong_jiong]',
		'type'        => 'checkbox',
		'label'      => '启用无聊的长短虫囧效果',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'guess_comments_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[guess_comments]',
		'type'        => 'checkbox',
		'label'      => '启用访客最近评论',
		'description' => '在页面左下角显示',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'disable_before_title_tag_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[disable_before_title_tag]',
		'type'        => 'checkbox',
		'label'      => '关闭文章标题前的标识',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rp_and_mp_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[rp_and_mp]',
		'type'        => 'checkbox',
		'label'      => '文章末尾显示相关文章和热评文章',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'custom_smiley_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[custom_smiley]',
		'type'        => 'checkbox',
		'label'      => '启用自定义评论表情',
		'description' => '',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'default_thumb_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[default_thumb]',
		'type'        => 'text',
		'label'      => '默认缩略图地址',
		'description' => '(可选)，这里填默认缩略图地址 (http://..../default.png)，图片大小为 135px*120px。留空时，没图片的文章不显示任何缩略图。',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'auto_thumb_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[auto_thumb]',
		'type'        => 'checkbox',
		'label'      => '启用自动缩略图',
		'description' => '开启后，如果没有设置“特色图片”的文章将：调用文章里面第一张媒体库图片作为缩略图（thumbnail尺寸）。如果图片全部是外链的，那么第一张外链图片作为缩略图（Full尺寸）。',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'social1_name_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[social1_name]',
		'type'        => 'text',
		'label'      => '社交链接1',
		'description' => '名称 (如 Twitter)，填入数字 -1 将关闭此链接',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'social1_link_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[social1_link]',
		'type'        => 'text',
		'label'      => '',
		'description' => '链接 (http://...)',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'social2_name_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[social2_name]',
		'type'        => 'text',
		'label'      => '社交链接2',
		'description' => '名称 (如 Google+)，填入数字 -1 将关闭此链接',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'social2_link_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[social2_link]',
		'type'        => 'text',
		'label'      => '',
		'description' => '链接 (http://...)',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rss_name_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[rss_name]',
		'type'        => 'text',
		'label'      => '自定义订阅',
		'description' => '名称 (默认 RSS)，填入数字 -1 将关闭订阅链接',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'rss_link_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[rss_link]',
		'type'        => 'text',
		'label'      => '',
		'description' => '地址 (http://...)',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright_html_id', array(
		'section'    => 'zsimple_themes_page_option_section',
		'settings'   => 'zsimple_theme_options[copyright]',
		'type'        => 'textarea',
		'label'      => 'Copyright',
		'description' => '',
	) ) );
}
