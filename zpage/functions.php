<?php
//////// Global variables, constants
// Define THEME URI
define( 'ZOO_THEME_URI', esc_url( get_template_directory_uri() ) );

//WordPress 4.3 产生大量定时作业修复方法
remove_action( 'admin_init',        '_wp_check_for_scheduled_split_terms' );


/* zww注：会不定期出现访问判断错误，可能跟缓存有关
 * via http://www.v7v3.com/wpjiaocheng/2014041154.html
 * via http://www.v7v3.com/tool/bot.txt
 */
/*
$zdo_ua = $_SERVER['HTTP_USER_AGENT'];

$zdo_now_ua = array(
		'FeedDemon',                 // 内容采集
		'BOT/0.1 (BOT for JCE)',     // sql注入
		'CrawlDaddy',                // sql注入
		'Java',                      // 内容采集
		'Jullo',                     // 内容采集
		'Feedly',                    // 内容采集
		'UniversalFeedParser',       // 内容采集
		'ApacheBench',               // cc攻击器
		'Swiftbot',                  // 爬虫
		'YandexBot',                 // 爬虫
		'AhrefsBot',                 // 爬虫
		'YisouSpider',               // 爬虫
		'jikeSpider',                // 爬虫
		'MJ12bot',                   // 爬虫
		'ZmEu',                      // phpmyadmin漏洞扫描
		'WinHttp',                   // 采集cc攻击
		'EasouSpider',               // 爬虫
		'HttpClient',                // tcp攻击
		'Microsoft URL Control',     // 扫描
		'YYSpider',                  // 爬虫
		'jaunty',                    // wordpress爆破扫描器
		'oBot',                      // 爬虫
		'Python-urllib',             // 内容采集
		'Indy Library',              // 扫描
		'FlightDeckReports Bot',     // 爬虫
	); //将恶意USER_AGENT存入数组

if (!$zdo_ua) { //禁止空USER_AGENT，dedecms等主流采集程序都是空USER_AGENT，部分sql注入工具也是空USER_AGENT
	header("Content-type: text/html; charset=utf-8");
	wp_die('Thanks!');
} else {
	foreach($zdo_now_ua as $value ) {
		if(eregi($value, $zdo_ua)) {
			header("Content-type: text/html; charset=utf-8");
			wp_die('Thanks!');
		}
	}
}
*/

/**
 * 屏蔽 XML-RPC 的功能
 * perfect: add following to .htaccess
 *   <Files xmlrpc.php>
 *       Order Deny,Allow
 *       Deny from all
 *   </Files>
 */
add_filter('xmlrpc_enabled', '__return_false');
/*add_filter( 'wp_headers', 'sw_remove_x_pingback' );
function sw_remove_x_pingback( $headers )	{
	unset( $headers['X-Pingback'] );
	return $headers;
}*/

/////// Secure WordPress by removing version
remove_action('wp_head', 'wp_generator');
/////// Secure WordPress by hiding login errors
function hide_login_errors($errors) { return 'login error'; }
add_filter('login_errors', 'hide_login_errors', 10, 1);

/*
//////// PHP warning message 
// error_reporting(E_ALL & ~E_NOTICE); // 偵錯用
*/

//////// custom-post-type
require dirname(__FILE__).'/inc/theme-custom-post-type.php';

//////// 关闭所有自动更新
add_filter( 'automatic_updater_disabled', '__return_true' );

//////// 禁用文章修订版本: 发现无效，改回用 wp-confing.php 方式
// add_action('pre_post_update','wp_save_post_revision'); // <= wp3.6
// add_action('post_updated','wp_save_post_revision',99,1); // > wp3.6

//////// 恢复WP3.5后隐藏的链接管理器
//add_filter( 'pre_option_link_manager_enabled', '__return_true' );

//////// 更改WP工具栏样式：只显示WP图标，hover出来 by immmmm.com
add_action('get_header', 'remove_admin_bar_style');
add_action( 'wp_head', 'diy_admin_bar_style' );
function remove_admin_bar_style() {
		remove_action('wp_head', 'wp_admin_bar_header');
		remove_action('wp_head', '_admin_bar_bump_cb');
}
function diy_admin_bar_style() {
	echo '
	<style type="text/css">
		#wpadminbar{background:transparent;}
		#wp-toolbar ul > li{display:none;}
		#wp-toolbar li#wp-admin-bar-wp-logo{display:block;background-color:#49629e;}
		#wp-toolbar:hover ul > li{display:block;background-color:#333;}
		#wpadminbar .ab-top-secondary{float:left;}
	</style>';
}

//////// Widgetized Sidebar.
// function zpage_widgets_init() {
// 	register_sidebar(array(
// 		'name' => __('Primary Widget Area','zpage'),
// 		'id' => 'primary-widget-area',
// 		'description' => __('The primary widget area','zpage'),
// 		'before_widget' => '<div id="%1$s" class="widget %2$s">',
// 		'after_widget' => '</div>',
// 		'before_title' => '<h3 class="widgettitle">',
// 		'after_title' => '</h3>'
// 	));
// 	register_sidebar(array(
// 		'name' => __('Singular Widget Area','zpage'),
// 		'id' => 'singular-widget-area',
// 		'description' => __('The singular widget area','zpage'),
// 		'before_widget' => '<div id="%1$s" class="widget %2$s">',
// 		'after_widget' => '</div>',
// 		'before_title' => '<h3 class="widgettitle">',
// 		'after_title' => '</h3>'
// 	));
// 	register_sidebar(array(
// 		'name' => __('Not Singular Widget Area','zpage'),
// 		'id' => 'not-singular-widget-area',
// 		'description' => __('Not the singular widget area','zpage'),
// 		'before_widget' => '<div id="%1$s" class="widget %2$s">',
// 		'after_widget' => '</div>',
// 		'before_title' => '<h3 class="widgettitle">',
// 		'after_title' => '</h3>'
// 	));
// 	register_sidebar(array(
// 		'name' => __('Footer Widget Area','zpage'),
// 		'id' => 'footer-widget-area',
// 		'description' => __('The footer widget area','zpage'),
// 		'before_widget' => '<div id="%1$s" class="widget %2$s">',
// 		'after_widget' => '</div>',
// 		'before_title' => '<h3 class="widgettitle">',
// 		'after_title' => '</h3>'
// 	));
// }
// add_action( 'widgets_init', 'zpage_widgets_init' );

//////// zpage Title Tag (Themes are REQUIRED to use 'wp_title' filter, to filter wp_title() )
function zpage_wp_title($title, $sep) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	// Add the site name.
	$site_title = get_bloginfo( 'name' );
	$title .= $site_title;
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$havepage = sprintf( ' - Page %s ', max( $paged, $page ) );
		// $title = "$title - " . sprintf( 'Page %s', max( $paged, $page ) );
	}

	#$title_split=split(' \| ', $title); // < PHP7
	$title_split=explode(' | ', $title);
	if ( is_tax('archives_category') ) {
		$title = 'Catetory Archives: ' . $title_split[0] . $havepage . " $sep " .  $title_split[1];
	} elseif ( is_tax('archives_tag') ) {
		$title = 'Tag Archives: ' . $title_split[0] . $havepage . " $sep " .  $title_split[1];
	// } elseif ( is_tax('archives') ){
		// $title = 'Archives' . " $sep " .  $title_split[1];
	} elseif ( is_category() ) {
		$title = 'Catetory Archives: ' . $title_split[0] . $havepage . " $sep " .  $title_split[1];
	} elseif ( is_tag() ) {
		$title = 'Tag Archives: ' . $title_split[0] . $havepage . " $sep " .  $title_split[1];
	} elseif ( is_search() ) {
		// printf('Search Results for %1$s%2$s', wp_specialchars($s, 1), $have_paded);
		$title = 'Search Results for: ' . $title_split[0] . $havepage . " $sep " .  $title_split[2];
	} elseif ( is_date() ) {
		if(is_day()) {
			$date = date('M',get_the_date('U')).get_the_date(' jS, Y');
		} elseif(is_year()) {
			$date = get_the_date('Y');
		} else {
			$date = date('M',get_the_date('U')).get_the_date(', Y');
		}
		$title = 'Date Archives: ' . $date . $havepage . " $sep " .  $site_title;
	} elseif ( is_author() ) {
		// $curauth = get_userdata_in_author_archive(); $author_title=$curauth->display_name;
		// printf('Author Archives: %1$s%2$s', $author_title, $have_paded);
		$title = 'Author Archives: ' . $title_split[0] . $havepage . " $sep " .  $title_split[1];
	} else {
		$title = "$title" . $havepage;
	}
	
	return $title;
}
add_filter( 'wp_title', 'zpage_wp_title', 10, 2 );

//////// WP nav menu
if (function_exists('wp_nav_menu')) {
	register_nav_menus(array(
		'zpage_primary' => 'zPage Primary Navigation',
		'zpage_sidebar' => 'zPage Sidebar Navigation'
	));
}
/* Custom wp_list_pages */
function zpage_wp_list_pages(){
	echo wp_list_pages('title_li=');
}
function zpage_wp_list_categories(){
	echo wp_list_categories('title_li=');
}

//////// Custom Navi Function
function zwwooooo_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="<?php echo $nav_id; ?>">
			<?php if(function_exists('pagenavi')) { ?>
				<?php pagenavi(); ?>
			<?php } else { ?>
				<?php posts_nav_link(' | ', __('&laquo; Previous page'), __('Next page &raquo;')); ?>
			<?php } ?>
		</div>
	<?php endif;
}

//////// This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );
//// post_thumbnail by zwwooooo
function post_thumbnail( $width=200, $height=140, $echo=true, $zTheme=false ){
	global $post;
	$post_link=get_permalink($post->ID);
	if ($zTheme) {
		if ($post->ID <= 25737 && get_post_type($post->ID) == 'archives') {
			$post_link = '/archives/' . $post->ID;
		}
	}
	if( has_post_thumbnail() ){
		$timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_timthumb = '<a href="'.$post_link.'" title="'.esc_attr(get_post_field('post_title', $post->ID)).'" rel="bookmark"><img src="'.$timthumb_src[0].'" alt="'.$post->post_title.'" /></a>';
	} else {
		$width=($width==0) ? '' : (' width='.$width);
		$height=($height==0) ? '' : (' height='.$height);
				$post_timthumb = '';
				ob_start();
				ob_end_clean();
		preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content,$index_matches);
		$first_img_src = $index_matches[1];
		if( !empty($first_img_src) ){
			$post_timthumb = '<a href="'.$post_link.'" title="'.esc_attr(get_post_field('post_title', $post->ID)).'" rel="bookmark"><img src="'.$first_img_src.'" alt="'.$post->post_title.'"'.$width.$height.' /></a>';
		} else {
			$post_timthumb = '<a href="'.$post_link.'" title="'.esc_attr(get_post_field('post_title', $post->ID)).'" rel="bookmark"><img src="'.ZOO_THEME_URI.'/images/thumbnail-default.jpg" alt="'.$post->post_title.'"'.$width.$height.'" /></a>';
		}
	}
	if ($echo==false)
		return $post_timthumb;
	else
		echo $post_timthumb;
}



//////// wp_list_comments() callback
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
//主评论计数器初始化 begin - by zwwooooo
	global $commentcount,$page;
	if(!$commentcount) { //初始化楼层计数器
		$page = ( get_query_var('cpage') ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;//获取当前评论列表页码
		$cpp=get_option('comments_per_page');//获取每页评论显示数量
		$commentcount = $cpp * $page;
	}
//主评论计数器初始化 end - by zwwooooo
	switch ($pingtype=$comment->comment_type) {
		case 'pingback' :
		case 'trackback' : ?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<div id="comment-<?php comment_ID(); ?>">
					<div class="comment-author vcard pingback">
						<?php comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php echo mysql2date('Y/m/d/ H:i', $comment->comment_date); ?>
					</div>
					<div class="floor"><!-- 主评论楼层号 - by zwwooooo -->
						<?php
						if(!$parent_id = $comment->comment_parent) {
							switch ($commentcount) {
								case 0:
									echo '<span>沙发</span>'; ++$commentcount;
									break;
								case 1:
									echo '<span>板凳</span>'; ++$commentcount;
									break;
								case 2:
									echo '<span>地板</span>'; ++$commentcount;
									break;
								default:
									echo ++$commentcount,'楼';
									break;
							}
						}
						?>
					</div>
				</div>
<?php
		break;
	default :
?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
				<div class="comment-author vcard">
					<?php echo get_avatar_zlazyload($comment->comment_author_email,$size='50',$default='',$comment->comment_author); ?>
					<?php /* <img src="http://im.zww.im/gravatar/cache/avatar/<?php echo md5(strtolower($comment->comment_author_email)); ?>" alt="" class='avatar' />
					printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) */  ?>
					<cite class="fn"><?php comment_author_link(); ?></cite>
					<span class="comment-meta commentmetadata"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?> <a rel="nofollow" href="<?php echo get_permalink($comment->comment_post_ID).'/comment-page-'.($page+1).'#comment-'.$comment->comment_ID; //esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">#</a><?php edit_comment_link(__('(Edit)'),'  ',''); ?></span>
					<?php if(function_exists('useragent_output_custom')){ ?><span class="useragent_output_custom"><?php useragent_output_custom(); ?></span> <?php } ?>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
				<p class="approved"><?php _e('Your comment is awaiting moderation.'); ?></p>
				<?php endif; ?>
				<div class="comment-text">
					<div class="comment-content"><?php comment_text(); ?></div>
				</div>
				<div class="reply">
					<?php //comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
					<?php
					//if ($depth == get_option('thread_comments_depth')) : //评论深度等于设置的最大深度
					if ($depth > 1) :
					?>
						<!-- 将第二个参数改为父一级评论的id -->
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_reply" rel="nofollow">Reply</a> |
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_quote" rel="nofollow">Quote</a>
					<?php else : ?>
						<!-- 正常情况 -->
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_reply" rel="nofollow">Reply</a> |
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_quote" rel="nofollow">Quote</a>
					<?php endif; ?>
				</div>
				<div class="floor"><!-- 主评论楼层号 - by zwwooooo -->
					<?php
					if(!$parent_id = $comment->comment_parent) {
						switch ($commentcount) {
							case 0:
								echo '<span>沙发</span>'; ++$commentcount;
								break;
							case 1:
								echo '<span>板凳</span>'; ++$commentcount;
								break;
							case 2:
								echo '<span>地板</span>'; ++$commentcount;
								break;
							default:
								echo ++$commentcount, '楼';
								break;
						}
					}
					?>
				</div>
			</div>
<?php
		break;
	}
}

//////// wp_list_comments() callback: for top3
function mytheme_comment_top3($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
//主评论计数器初始化 begin - by zwwooooo
	global $commentcount_top,$page;
	if(!$commentcount_top) { //初始化楼层计数器
		$page = ( !empty($in_comment_loop) ) ? get_query_var('cpage')-1 : get_page_of_comment( $comment->comment_ID, $args )-1;//获取当前评论列表页码
		$cpp=get_option('comments_per_page');//获取每页评论显示数量
		$commentcount_top = $cpp * $page;
	}
//主评论计数器初始化 end - by zwwooooo
	switch ($pingtype=$comment->comment_type) {
		case 'pingback' :
		case 'trackback' : ?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>">
						<div class="comment-author vcard pingback">
							<?php comment_author_link(); ?> - <?php echo $pingtype; ?> on <?php echo mysql2date('Y/m/d/ H:i', $comment->comment_date); ?>
						</div>
						<div class="floor"><!-- 主评论楼层号 - by zwwooooo -->
							<?php
							if(!$parent_id = $comment->comment_parent) {
								switch ($commentcount_top) {
									case 0:
										echo '<span>沙发</span>'; ++$commentcount_top;
										break;
									case 1:
										echo '<span>板凳</span>'; ++$commentcount_top;
										break;
									case 2:
										echo '<span>地板</span>'; ++$commentcount_top;
										break;
									default:
										echo ++$commentcount_top,'楼';
										break;
								}
							}
							?>
						</div>
					</div>
<?php
		break;
	default : ?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>">
				<div class="comment-author vcard">
					<?php echo get_avatar_zlazyload($comment->comment_author_email,$size='50',$default='',$comment->comment_author); ?>
					<?php /* <img src="http://im.zww.im/gravatar/cache/avatar/<?php echo md5(strtolower($comment->comment_author_email)); ?>" alt="" class='avatar' />
					printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) */  ?>
					<cite class="fn"><?php comment_author_link(); ?></cite>
					<span class="comment-meta commentmetadata"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?> <a rel="nofollow" href="<?php echo get_permalink($comment->comment_post_ID).'/comment-page-'.($page+1).'#comment-'.$comment->comment_ID; //esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">#</a><?php edit_comment_link(__('(Edit)'),'  ',''); ?></span>
					<?php if(function_exists('useragent_output_custom')){ ?><span class="useragent_output_custom"><?php useragent_output_custom(); ?></span> <?php } ?>
				</div>
				<?php if ($comment->comment_approved == '0') : ?>
				<p class="approved"><?php _e('Your comment is awaiting moderation.'); ?></p>
				<?php endif; ?>
				<div class="comment-text">
					<div class="comment-content"><?php comment_text(); ?></div>
				</div>
				<div class="reply">
					<?php //comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
					<?php
					//if ($depth == get_option('thread_comments_depth')) : //评论深度等于设置的最大深度
					if ($depth > 1) :
					?>
						<!-- 将第二个参数改为父一级评论的id -->
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_reply" rel="nofollow">Reply</a> |
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php echo $comment->comment_parent; ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' )" href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_quote" rel="nofollow">Quote</a>
					<?php else : ?>
						<!-- 正常情况 -->
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_reply" rel="nofollow">Reply</a> |
						<a onclick="return addComment.moveForm( 'comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID(); ?>#respond" class="comment-reply-link zsnos_quote" rel="nofollow">Quote</a>
					<?php endif; ?>
				</div>
				<div class="floor"><!-- 主评论楼层号 - by zwwooooo -->
					<?php
					if(!$parent_id = $comment->comment_parent) {
						switch ($commentcount_top) {
							case 0:
								echo '<span>沙发</span>'; ++$commentcount_top;
								break;
							case 1:
								echo '<span>板凳</span>'; ++$commentcount_top;
								break;
							case 2:
								echo '<span>地板</span>'; ++$commentcount_top;
								break;
							default:
								echo ++$commentcount_top, '楼';
								break;
						}
					}
					?>
				</div>
			</div>
<?php
		break;
	}
}

//////// enqueuing scripts and styles
if (!is_admin()) {

	function themeslug_enqueue_script() {
		// Load main stylesheet.
		wp_enqueue_style( 'zpage-style', ZOO_THEME_URI . '/style.css', false, '1.0.0' );

		wp_enqueue_script('jquery');

		wp_enqueue_script( 'zpage-global', ZOO_THEME_URI . '/js/zpage.global.js', array(), '1.0.0', true );
		// 传递参数: theme url
		wp_localize_script('zpage-global', 'zdo_ajax_url', array('theme_url' => ZOO_THEME_URI, 'home_url' => home_url()) );

		if (is_singular() || is_post_type_archive('archives')) wp_enqueue_script( 'zpage-singular', ZOO_THEME_URI . '/js/zpage.singular.js', array(), '1.0.0', true );

		// if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
	}

	add_action('wp_enqueue_scripts', 'themeslug_enqueue_script');
}

//////// theme functions / plugins
require dirname(__FILE__).'/inc/theme-functions.php';
require dirname(__FILE__).'/inc/theme-plugins.php';
//////// Load up our theme options page and related code.
require( dirname( __FILE__ ) . '/inc/theme-options.php' );
//////// Load custom theme options
$zpage_theme_options = get_option('zpage_theme_options');
