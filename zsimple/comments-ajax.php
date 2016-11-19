<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

/** Sets up the WordPress Environment. */
#require( dirname(__FILE__) . '/../../../wp-load.php' ); // 此 comments-ajax.php 位於主題資料夾,所以位置已不同
require( realpath(dirname(dirname(dirname(dirname($_SERVER["SCRIPT_FILENAME"]))))).'/wp-load.php' ); // 此 comments-ajax.php 位於主題資料夾,所以位置已不同

nocache_headers();

$comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;

$post = get_post($comment_post_ID);

if ( empty($post->comment_status) ) {
	do_action('comment_id_not_found', $comment_post_ID);
	exit;
}

// get_post_status() will get the parent status for attachments.
$status = get_post_status($post);

$status_obj = get_post_status_object($status);

/* if ( !comments_open($comment_post_ID) ) {
	do_action('comment_closed', $comment_post_ID);
	wp_die( __('Sorry, comments are closed for this item.') );
} elseif ( 'trash' == $status ) {
	do_action('comment_on_trash', $comment_post_ID);
	wp_die(__('Invalid comment status.')); // 將 exit 改為錯誤提示
} elseif ( !$status_obj->public && !$status_obj->private ) {
	do_action('comment_on_draft', $comment_post_ID);
	wp_die(__('Invalid comment status.')); // 將 exit 改為錯誤提示
} elseif ( post_password_required($comment_post_ID) ) {
	do_action('comment_on_password_protected', $comment_post_ID);
	wp_die(__('Password Protected')); // 將 exit 改為錯誤提示
} else { */
	do_action('pre_comment_on_post', $comment_post_ID);
//}

$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
// $edit_id              = ( isset($_POST['edit_id']) ) ? $_POST['edit_id'] : null; // 提取 edit_id，再编辑功能 by willin

// If the user is logged in
$user = wp_get_current_user();
if ( $user->exists() ) {
	if ( empty( $user->display_name ) )
		$user->display_name=$user->user_login;
	$comment_author       = $wpdb->escape($user->display_name);
	$comment_author_email = $wpdb->escape($user->user_email);
	$comment_author_url   = $wpdb->escape($user->user_url);
	if ( current_user_can('unfiltered_html') ) {
		if ( wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment'] ) {
			kses_remove_filters(); // start with a clean slate
			kses_init_filters(); // set up the filters
		}
	}
} else {
	if ( get_option('comment_registration') || 'private' == $status )
		wp_die( __('Sorry, you must be logged in to post a comment.') );
}

$comment_type = '';

if ( get_option('require_name_email') && !$user->exists() ) {
	if ( 6 > strlen($comment_author_email) || '' == $comment_author )
		wp_die( __('<strong>ERROR</strong>: please fill the required fields (name, email).') );
	elseif ( !is_email($comment_author_email))
		wp_die( __('<strong>ERROR</strong>: please enter a valid email address.') );
}

if ( '' == $comment_content )
	wp_die( __('<strong>ERROR</strong>: please type a comment.') );

$comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;

/* 公告栏禁止访客发主评论 by zwwooooo */
if (!$user->ID && $comment_post_ID==25111 && $comment_parent==0)
	wp_die(__('抱歉，这里只有博主才能发公告/吐槽（主评论），您只能回复博主的某条公告。'));

$commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

$comment_id = wp_new_comment( $commentdata );

$comment = get_comment($comment_id);
do_action('set_comment_cookies', $comment, $user);

// $location = empty($_POST['redirect_to']) ? get_comment_link($comment_id) : $_POST['redirect_to'] . '#comment-' . $comment_id; //取消原有的刷新重定向
// $location = apply_filters('comment_post_redirect', $location, $comment);

// wp_safe_redirect( $location );
// exit;

$comment_depth = 1;   //为评论的 class 属性准备的 by willin
$tmp_c = $comment;
while($tmp_c->comment_parent != 0){
$comment_depth++;
$tmp_c = get_comment($tmp_c->comment_parent);
}
//以下是评论样式，根据你的模板样式copy覆盖，移除“reply”部分
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar($comment->comment_author_email,$size='50',$default='',$comment->comment_author); ?>
			<?php /* <img src="http://im.zww.im/gravatar/cache/avatar/<?php echo md5(strtolower($comment->comment_author_email)); ?>" alt="" class='avatar' />
			printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) */  ?>
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