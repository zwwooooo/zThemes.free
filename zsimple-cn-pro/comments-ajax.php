<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	$protocol = $_SERVER['SERVER_PROTOCOL'];
	if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
		$protocol = 'HTTP/1.0';
	}

	header('Allow: POST');
	header("$protocol 405 Method Not Allowed");
	header('Content-Type: text/plain');
	exit;
}

/** Sets up the WordPress Environment. */
#require( dirname(__FILE__) . '/wp-load.php' );
require( realpath(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))).'/wp-load.php' );

nocache_headers();

$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
if ( is_wp_error( $comment ) ) {
	$data = intval( $comment->get_error_data() );
	if ( ! empty( $data ) ) {
		#wp_die( '<p>' . $comment->get_error_message() . '</p>', __( 'Comment Submission Failure' ), array( 'response' => $data, 'back_link' => true ) );
		wp_die( __($comment->get_error_message()) );
	} else {
		exit;
	}
}

$user = wp_get_current_user();

/**
 * Perform other actions when comment cookies are set.
 *
 * @since 3.4.0
 *
 * @param WP_Comment $comment Comment object.
 * @param WP_User    $user    User object. The user may not exist.
 */
do_action( 'set_comment_cookies', $comment, $user );

#$location = empty( $_POST['redirect_to'] ) ? get_comment_link( $comment ) : $_POST['redirect_to'] . '#comment-' . $comment->comment_ID;

/**
 * Filters the location URI to send the commenter after posting.
 *
 * @since 2.0.5
 *
 * @param string     $location The 'redirect_to' URI sent via $_POST.
 * @param WP_Comment $comment  Comment object.
 */
#$location = apply_filters( 'comment_post_redirect', $location, $comment );

#wp_safe_redirect( $location );
#exit;

//以下是评论样式，根据你的模板样式copy覆盖，移除“reply”部分
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar($comment->comment_author_email,$size='50',$default='',$comment->comment_author); ?>
			<cite class="fn"><?php comment_author_link(); ?></cite>
			<span class="comment-meta commentmetadata"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?> <a rel="nofollow" href="<?php echo get_permalink($comment->comment_post_ID).'/comment-page-'.($page+1).'#comment-'.$comment->comment_ID; //esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">#</a><?php edit_comment_link(__('(Edit)'),'  ',''); ?></span>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<p class="approved"><?php _e('Your comment is awaiting moderation.'); ?></p>
		<?php endif; ?>
		<div class="comment-text">
			<div class="comment-content"><?php comment_text(); ?></div>
		</div>
	</div>