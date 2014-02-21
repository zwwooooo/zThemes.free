<?php
//////// Widgetized Sidebar.
function zborder_widgets_init() {
	register_sidebar(array(
		'name' => __('Primary Widget Area','zborder'),
		'id' => 'primary-widget-area',
		'description' => __('The primary widget area','zborder'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => __('Singular Widget Area','zborder'),
		'id' => 'singular-widget-area',
		'description' => __('The singular widget area','zborder'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => __('Not Singular Widget Area','zborder'),
		'id' => 'not-singular-widget-area',
		'description' => __('Not the singular widget area','zborder'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => __('Footer Widget Area','zborder'),
		'id' => 'footer-widget-area',
		'description' => __('The footer widget area','zborder'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
}
add_action( 'widgets_init', 'zborder_widgets_init' );

//////// Enqueue scripts and styles
function zborder_scripts() {
	// Load main stylesheet.
	wp_enqueue_style( 'zborder-style', get_stylesheet_uri(), false, '0.9.0' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zborder_scripts' );

//////// zborder Title Tag (Themes are REQUIRED to use 'wp_title' filter, to filter wp_title() )
function zborder_wp_title($title, $sep) {
	global $paged, $page;
	if ( is_feed() ) {
		return $title;
	}
	// Add the site name.
	$title .= get_bloginfo( 'name' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'zborder' ), max( $paged, $page ) );
	}
	return $title;
}
add_filter( 'wp_title', 'zborder_wp_title', 10, 2 );

//////// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 630;

//////// WP nav menu
register_nav_menus(array('primary' => 'Primary Navigation'));
//////// Custom wp_list_pages
function zborder_wp_list_pages(){
	echo wp_list_pages('title_li=');
}

//////// LOCALIZATION
load_theme_textdomain('zborder', get_template_directory() . '/lang');

//////// custom excerpt
function zborder_excerpt_length( $length ) {
	return 160;
}
add_filter( 'excerpt_length', 'zborder_excerpt_length' );
//Returns a "Read more &raquo;" link for excerpts
function zborder_continue_reading_link() {
	return '<p class="read-more"><a href="'. esc_url(get_permalink()) . '">read more</a></p>';
}
//Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and zborder_continue_reading_link().
function zborder_auto_excerpt_more( $more ) {
	return ' &hellip;' . zborder_continue_reading_link();
}
add_filter( 'excerpt_more', 'zborder_auto_excerpt_more' );
//Adds a pretty "Read more &raquo;" link to custom post excerpts.
function zborder_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= zborder_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'zborder_custom_excerpt_more' );
//Custom more-links for zborder
function zborder_custom_more_link($link) { 
	return '<span class="zborder-more-link">'.$link.'</span>';
}
add_filter('the_content_more_link', 'zborder_custom_more_link');

//////// Tell WordPress to run zborder_setup() when the 'after_setup_theme' hook is run.
add_action( 'after_setup_theme', 'zborder_setup' );
if ( ! function_exists( 'zborder_setup' ) ):
function zborder_setup() {

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	// add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'extra-featured-image', 180, 135, true );
	function zborder_featured_content($content) {
		if (is_home() || is_archive()) {
			the_post_thumbnail( 'extra-featured-image' );
		}
		return $content;
	}
	add_filter( 'the_content', 'zborder_featured_content',1 );
	function zborder_post_image_html( $html, $post_id, $post_image_id ) {
		if ($html)
			$html = '<a href="' . esc_url(get_permalink( $post_id )) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
		return $html;
	}
	add_filter( 'post_thumbnail_html', 'zborder_post_image_html', 10, 3 );
	
	// This theme allows users to set a custom background
	add_theme_support('custom-background');

	// Custom Headers: Since WP3.4
	$defaults = array(
		'default-image'          => '',
		'random-default'         => false,
		'width'                  => 970,
		'height'                 => 200,
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

} // end of zborder_setup()
endif;

//////// Load up our theme options page and related code.
require( dirname( __FILE__ ) . '/inc/theme-options.php' );
//////// Load custom theme options
$zborder_theme_options = get_option('zborder_theme_options');

//////// Custom Function: get single term id by zwwooooo
function single_term_id_by_zww( $prefix = '', $display = true, $value='term_id' ) {
	global $wp_query;
	$term = $wp_query->get_queried_object();
	if ( !$term )
		return;
	if ( is_category() )
		$return = apply_filters( 'single_cat_title', $term->$value );
	elseif ( is_tag() )
		$return = apply_filters( 'single_tag_title', $term->$value );
	elseif ( is_tax() )
		$return = apply_filters( 'single_term_title', $term->$value );
	else
		return;
	if ( empty( $return ) )
		return;
	if ( $display )
		echo $prefix . $return;
	else
		return $return;
}

//////// get userdata in archive.php
function get_userdata_in_author_archive() {
	if (is_author()) { //work in wp2.8+
		return (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
	}
	return false;
}

//////// Custom Comments List.
function zborder_mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
	switch ($pingtype=$comment->comment_type) {
		case 'pingback' :
		case 'trackback' : ?>

<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard pingback">
			<cite class="fn zborder_pingback"><?php comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php printf(__('%1$s at %2$s', 'zborder'), get_comment_date(),  get_comment_time()); ?></cite>
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
			<span class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf(__('%1$s at %2$s', 'zborder'), get_comment_date(),  get_comment_time()); ?></a><?php edit_comment_link(__('[Edit]','zborder'),' ',''); ?></span>
		</div>
		<div class="comment-text">
			<?php comment_text(); ?>
			<?php if ($comment->comment_approved == '0') : ?>
			<p><em class="approved"><?php _e('Your comment is awaiting moderation.','zborder'); ?></em></p>
			<?php endif; ?>
		</div>
		<div class="reply">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
		</div>
	</div>

<?php 		break;
	}
}
