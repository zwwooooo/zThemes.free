<?php
//////// Widgetized Sidebar.
function zbench_widgets_init() {
	register_sidebar(array(
		'name' => __('Primary Widget Area','zbench'),
		'id' => 'primary-widget-area',
		'description' => __('The primary widget area','zbench'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => __('Singular Widget Area','zbench'),
		'id' => 'singular-widget-area',
		'description' => __('The singular widget area','zbench'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => __('Not Singular Widget Area','zbench'),
		'id' => 'not-singular-widget-area',
		'description' => __('Not the singular widget area','zbench'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => __('Footer Widget Area','zbench'),
		'id' => 'footer-widget-area',
		'description' => __('The footer widget area','zbench'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
}
add_action( 'widgets_init', 'zbench_widgets_init' );

//////// Custom Comments List.
function zbench_mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
	switch ($pingtype=$comment->comment_type) {
		case 'pingback' :
		case 'trackback' : ?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard pingback">
			<cite class="fn zbench_pingback"><?php comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php printf(__('%1$s at %2$s', 'zbench'), get_comment_date(),  get_comment_time()); ?></cite>
		</div>
	</div>
<?php
			break;
		default : ?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar($comment,$size='40',$default='' ); ?>
			<cite class="fn"><?php comment_author_link(); ?></cite>
			<span class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf(__('%1$s at %2$s', 'zbench'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('[Edit]','zbench'),' ',''); ?></span>
		</div>
		<div class="comment-text">
			<?php comment_text(); ?>
			<?php if ($comment->comment_approved == '0') : ?>
			<p><em class="approved"><?php _e('Your comment is awaiting moderation.','zbench'); ?></em></p>
			<?php endif; ?>
		</div>
		<div class="reply">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		</div>
	</div>

<?php 		break;
	}
}

//////// wp_list_comments()->pings callback
function zbench_custom_pings($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    if('pingback' == get_comment_type()) $pingtype = 'Pingback';
    else $pingtype = 'Trackback';
?>
    <li id="comment-<?php echo $comment->comment_ID ?>">
        <?php comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php echo mysql2date('Y/m/d/ H:i', $comment->comment_date); ?>
<?php }

//////// zBench Title Tag (Themes are REQUIRED to use 'wp_title' filter, to filter wp_title() - 120331 REQUIRED)
// apply_filters('wp_title', $title, $sep, $seplocation)
function zbench_wp_title($title) {
	global $page, $paged;
	if ( !is_feed() )
		$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		$title .= ' | ' . sprintf( __( 'Page %s', 'zbench' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'zbench_wp_title' );

//////// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 620;

//////// Enqueue comment-reply script via callback (120331 REQUIRED)
function zbench_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zbench_enqueue_comment_reply' );
	
//////// WP nav menu
register_nav_menus(array('primary' => 'Primary Navigation'));
//////// Custom wp_list_pages
function zbench_wp_list_pages(){
	if (is_home() || is_front_page()) $isHome = ' class="current_page_item"';
	echo '<li' . $isHome . '><a href="' . home_url('/') . '">' . __('Home', 'zbench') . '</a></li>';
	echo wp_list_pages('title_li=');
}

//////// LOCALIZATION
load_theme_textdomain('zbench', get_template_directory() . '/lang');

//////// custom excerpt
function zbench_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'zbench_excerpt_length' );
//Returns a "Read more &raquo;" link for excerpts
function zbench_continue_reading_link() {
	return '<p class="read-more"><a href="'. esc_url(get_permalink()) . '">' . __( 'Read more &raquo;', 'zbench' ) . '</a></p>';
}
//Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and zbench_continue_reading_link().
function zbench_auto_excerpt_more( $more ) {
	return ' &hellip;' . zbench_continue_reading_link();
}
add_filter( 'excerpt_more', 'zbench_auto_excerpt_more' );
//Adds a pretty "Read more &raquo;" link to custom post excerpts.
function zbench_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= zbench_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'zbench_custom_excerpt_more' );
//Custom more-links for zBench
function zbench_custom_more_link($link) { 
	return '<span class="zbench-more-link">'.$link.'</span>';
}
add_filter('the_content_more_link', 'zbench_custom_more_link');

//////// Tell WordPress to run zbench_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'zbench_setup' );
if ( ! function_exists( 'zbench_setup' ) ):
function zbench_setup() {

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'extra-featured-image', 620, 200, true );
	function zbench_featured_content($content) {
		if (is_home() || is_archive()) {
			the_post_thumbnail( 'extra-featured-image' );
		}
		return $content;
	}
	add_filter( 'the_content', 'zbench_featured_content',1 );
	function zbench_post_image_html( $html, $post_id, $post_image_id ) {
		if ($html)
			$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
		return $html;
	}
	add_filter( 'post_thumbnail_html', 'zbench_post_image_html', 10, 3 );


	// This theme allows users to set a custom background
	add_theme_support('custom-background');

	// Custom Headers: Since WP3.4
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 950,
		'height'                 => 180,
		'flex-height'            => false,
		'flex-width'             => false,
		'default-text-color'     => '',
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $defaults );

} // end of zbench_setup()
endif;

//////// Load up our theme options page and related code.
require( dirname( __FILE__ ) . '/library/theme-options.php' );
//////// Load custom theme options
$zbench_options = get_option('zBench_options');
