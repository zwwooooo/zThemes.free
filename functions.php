<?php
// -----------------------------------------------
// Global variables, constants
// -----------------------------------------------

// Define THEME URI
define( 'ZOO_THEME_URI', esc_url( get_template_directory_uri() ) );
// Load custom theme options
$zsimple_theme_options = get_option('zsimple_theme_options');

// -----------------------------------------------
// Theme 
// -----------------------------------------------

add_action('after_setup_theme', 'zoo_after_setup_theme');
function zoo_after_setup_theme() {
	// theme support
	require dirname(__FILE__).'/inc/theme-support.php';
	// theme functions
	require dirname(__FILE__).'/inc/theme-functions.php';
	// Load up our theme options page and related code.
	require( dirname( __FILE__ ).'/inc/theme-options.php' );
}


/**
 * enqueuing scripts and styles
 */
if (!is_admin()) {

	function themeslug_enqueue_script() {
		$ver = '1.0.2';

		// Load main stylesheet.
		wp_enqueue_style( 'main-style', ZOO_THEME_URI . '/style-main.css', false, $ver );

		wp_enqueue_script('jquery');

		wp_enqueue_script( 'global-js', ZOO_THEME_URI . '/js/global.js', array(), $ver, true );
		// 传递参数: theme url
		wp_localize_script('global-js', 'zdo_ajax_url', array('theme_url' => ZOO_THEME_URI, 'home_url' => home_url()) );

		if (is_singular() || is_post_type_archive('archives')) wp_enqueue_script( 'singular-js', ZOO_THEME_URI . '/js/singular.js', array(), $ver, true );

		// if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	}

	add_action('wp_enqueue_scripts', 'themeslug_enqueue_script');
}
