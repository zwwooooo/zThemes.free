<?php
//////// Mini Gavatar Cache by Willin Kan. Modify by zwwooooo
/*
if (!is_admin()) {
	function my_avatar( $email, $size = '50', $default = '', $alt = '', $zll='' ) {
		// $alt = (false === $alt) ? '' : esc_attr( $alt );
		$alt = ('' == $alt) ? '' :  $alt ;
		$zLazyload=ZOO_THEME_URI.'/img/zlazyload.gif';
		$f = md5( strtolower( $email ) );
		$w = home_url(); //$w = get_bloginfo('url');
			$w = ($w=='http://zww.me') ? ('http://im.zww.im') : $w; //for zww.me
		$a = $w. '/avatar/'. $f . '.jpg';
		$e = preg_replace('/wordpress\//', '', ABSPATH) . 'avatar/' . $f . '.jpg';
			$e = ($w=='http://im.zww.im') ? preg_replace('/zww.me\//', 'im.zww.im/', $e) : $e; //for zww.me
		$t = 604800; //设定7天, 单位:秒
		// if ( empty($default) ) $default = $w. '/avatar/default.jpg';
		if ( empty($default) ) $default = $w. '/default.jpg'; //for zww.me
		if ( !is_file($e) || (time() - filemtime($e)) > $t ){ //当头像不存在或者文件超过7天才更新
			$r = get_option('avatar_rating');
			$g = sprintf( "http://www.gravatar.com", ( hexdec( $f{0} ) % 2 ) ). '/avatar/'. $f. '?s='. $size. '&d='. $default. '&r='. $r;
			copy($g, $e);
		}
		if (filesize($e) < 500) copy($default, $e);
		if ($zll)
			$avatar = "<img title='{$alt}' alt='{$alt}' src='{$zLazyload}' zLazyload='{$a}' class='avatar avatar-{$size} photo zll' height='{$size}' width='{$size}' />";
		else
			$avatar = "<img title='{$alt}' alt='{$alt}' src='{$a}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		return apply_filters('my_avatar', $avatar, $email, $size, $default, $alt);
	}
}
*/

/*function my_avatar_admin($avatar) {
	$tmp = strpos($avatar, 'http');
	$g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
	$tmp = strpos($g, 'avatar/') + 7;
	$f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
	$w = home_url(); // $w = get_bloginfo('url');
		$w = ($w=='http://zww.me') ? ('http://im.zww.im') : $w; //for zww.me
	$e = preg_replace('/wordpress\//', '', ABSPATH) .'avatar/'. $f .'.jpg';
		$e = ($w=='http://im.zww.im') ? preg_replace('/zww.me\//', 'im.zww.im/', $e) : $e; //for zww.me
	$t = 604800; //设定7天, 单位:秒
	// if ( empty($default) ) $default = $w. '/avatar/default.jpg';
	if ( empty($default) ) $default = $w. '/images/avatar-default.jpg'; //for zww.me
	if ( !is_file($e) || (time() - filemtime($e)) > $t ) {//当头像不存在或者文件超过7天才更新
		copy(htmlspecialchars_decode($g), $e);
	} else {
		// if (filesize($e) < 500) $avatar = strtr($avatar, array($g => $w.'/default.jpg'));
		if (filesize($e) < 500) {
			$avatar = strtr($avatar, array($g => $default));
		} else {
			$avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.jpg'));
		}
	}
	// if (filesize($e) < 500) copy($default, $e);
	return $avatar;
}
add_filter('get_avatar', 'my_avatar_admin');*/

function get_avatar_zlazyload($comment_author_email,$size='50',$default='',$alt='') {
	$avatar = get_avatar($comment_author_email,$size='50',$default,$alt);
	$avatar = str_replace(' src=', ' zlazyload=', $avatar);
	$avatar = str_replace('<img', '<img class="avatar zlazyload" src="'.ZOO_THEME_URI.'/img/zlazyload.gif"', $avatar);
	return $avatar;
}

//////// 邮件通知 by Qiqiboy
function comment_mail_notify($comment_id) {
	$comment = get_comment($comment_id);//根据id获取这条评论相关数据
	$content=$comment->comment_content;
	//对评论内容进行匹配
	$match_count=preg_match_all('/<a href="#comment-([0-9]+)?" rel="nofollow">/si',$content,$matchs);
	if($match_count>0){//如果匹配到了
		foreach($matchs[1] as $parent_id){//对每个子匹配都进行邮件发送操作
			SimPaled_send_email($parent_id,$comment);
		}
	}elseif($comment->comment_parent!='0'){//以防万一，有人故意删了@回复，还可以通过查找父级评论id来确定邮件发送对象
		$parent_id=$comment->comment_parent;
		SimPaled_send_email($parent_id,$comment);
	}else return;
}
add_action('comment_post', 'comment_mail_notify');
function SimPaled_send_email($parent_id,$comment){//发送邮件的函数 by Qiqiboy.com
	$admin_email = get_bloginfo ('admin_email');//管理员邮箱
	$parent_comment=get_comment($parent_id);//获取被回复人（或叫父级评论）相关信息
	$author_email=$comment->comment_author_email;//评论人邮箱
	$to = trim($parent_comment->comment_author_email);//被回复人邮箱
	$spam_confirmed = $comment->comment_approved;
	// if ($spam_confirmed != 'spam' && $to != $admin_email && $to != $author_email) {
	if ($spam_confirmed == 1 && $to != $admin_email && $to != $author_email) {
		// $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
		$wp_email = 'no-reply@v1.zww.im'; // e-mail 發出點, no-reply 可改為可用的 e-mail.
		$subject = '您在 [' . get_option("blogname") . '] 的评论有了回复';
		$message = '<div style="padding:10px;color:#fff;background-color:#666;border:1px solid #d8e3e8;border-bottom:none;border-radius:5px 5px 0 0;-moz-border-radius:5px 5px 0 0;-webkit-border-radius:5px 5px 0 0;-khtml-border-radius:5px 5px 0 0;">
			您在 {<a style="font-size:14px;font-weight:bold;color:#fff;text-decoration:none;" href="' . home_url('/') . '">' . get_bloginfo('name') . '</a>} 的评论有了回复</div>
			<div style="padding:0 15px;color:#111;background-color:#eef2fa;border:1px solid #d8e3e8;border-radius:0 0 5px 5px;-moz-border-radius:0 0 5px 5px;-webkit-border-radius:0 0 5px 5px;-khtml-border-radius:0 0 5px 5px;">
			<p><strong>' . trim(get_comment($parent_id)->comment_author) . '</strong>, 您好！</p>
			<p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的评论：</p>
			<p style="padding:10px;background-color:#e5e5e5;">' . trim(get_comment($parent_id)->comment_content) . '</p>
			<p><strong>' . trim($comment->comment_author) . '</strong> 给您的回复：</p>
			<p style="padding:10px;background-color:#d5d5d5;">' . trim($comment->comment_content) . '</p>
			<p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id,array("type" => "all"))) . '">查看回复的完整內容</a>，
			欢迎再度光临 <a href="' . home_url('/') . '">' . get_bloginfo('name') . '</a></p>
			<p>(此邮件由系统自动发出，请勿回复。)</p></div>';
		$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
		$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
		wp_mail( $to, $subject, $message, $headers );
	}
}

//////// <<小牆>> Anti-Spam v1.81 by Willin Kan.
//建立
class anti_spam {
	function anti_spam() {
		if ( !current_user_can('level_0') ) {
			add_action('template_redirect', array($this, 'w_tb'), 1);
			add_action('init', array($this, 'gate'), 1);
			add_action('preprocess_comment', array($this, 'sink'), 1);
		}
	}
	//設欄位
	function w_tb() {
		if ( is_singular() ) {
			ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
			"textarea$1name=$2ooxx$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
		}
	}
	//檢查
	function gate() {
		if ( !empty($_POST['ooxx']) && empty($_POST['comment']) ) {
			$_POST['comment'] = $_POST['ooxx'];
		} else {
			$request = $_SERVER['REQUEST_URI'];
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']         : '隐瞒';
			$IP      = isset($_SERVER["HTTP_VIA"])     ? $_SERVER["HTTP_X_FORWARDED_FOR"]. ' (透过代理)' : $_SERVER["REMOTE_ADDR"];
			$way     = isset($_POST['ooxx'])           ? '手动操作'                       : '未经评论表格';
			$spamcom = isset($_POST['comment'])        ? $_POST['comment']                : null;
			$_POST['spam_confirmed'] = "请求: ". $request. "\n来路: ". $referer. "\nIP: ". $IP. "\n方式: ". $way. "\n內容: ". $spamcom. "\n -- 记录成功 --";
		}
	}
	//處理
	function sink( $comment ) {
		if ( !empty($_POST['spam_confirmed']) ) {
			if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment; //不管 Trackbacks/Pingbacks
			//方法一: 直接擋掉, 將 die(); 前面兩斜線刪除即可.
			die();
			//方法二: 標記為 spam, 留在資料庫檢查是否誤判.
			add_filter('pre_comment_approved', create_function('', 'return "spam";'));
			$comment['comment_content'] = "[ 小墙判断这是Spam! ]\n". $_POST['spam_confirmed'];
		} else {
			/* 沒頭像的列入待審 by willin - http://kan.willin.org/?p=1324&cpage=3 */
			$f = md5( strtolower($comment['comment_author_email']) );
			$g = sprintf( "http://www.gravatar.com", (hexdec($f{0}) % 2) ) .'/avatar/'. $f .'?d=404';
			$headers = @get_headers( $g );
			if ( !preg_match("|200|", $headers[0]) ) add_filter('pre_comment_approved', create_function('', 'return "0";'));
		}
		return $comment;
	}
}
$anti_spam = new anti_spam();


//////// Mini Pagenavi v1.0 by Willin Kan. Edit by zwwooooo */
if ( !function_exists('pagenavi') ) {
	function pagenavi( $p = 6 ) { // 取当前页前后各 $p-1 页
		if ( is_singular() ) return; // 文章与页面不用
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; // 只有一页不用
		$pagenavi = '';
		if ( empty( $paged ) ) $paged = 1;
		// if ( $paged == 1 ) $pagenavi .= '<span class="begin-page">Beginning</span>';
		if ( $paged > 1 ){
			// $pagenavi .= '<span class="begin-page">'. p_link( 1, 'Beginning' ). '</span>';
			$pagenavi .= '<span class="prev-page">'. p_link( $paged - 1, '&laquo;' ). '</span>';
		}
		if ( $paged > $p + 1 ) $pagenavi .= p_link( 1 );
		if ( $paged > $p + 2 ) $pagenavi .= '<em>...</em>';
		$i = $paged - $p; // 中间页初始化
		while ( $i <= $paged + $p ) { // 中间页
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? $pagenavi .= "<span class='page-numbers current'>{$i}</span>" : $pagenavi .= p_link( $i );
			++$i;
		}
		if ( $paged < $max_page - $p - 1 ) $pagenavi .= '<em>...</em>';
		if ( $paged < $max_page - $p ) $pagenavi .= p_link( $max_page );
		if ( $paged < $max_page ) {
			$pagenavi .= '<span class="next-page">'. p_link( $paged + 1, '&raquo;' ). '</span>';
			// $pagenavi .= '<span class="end-page">'. p_link( $max_page, 'End' ). '</span>';
		}
		// if ( $paged == $max_page ) $pagenavi .= '<span class="end-page">End</span>';
		echo '<div class="pagenavi">', $pagenavi , '</div>';
	}
	function p_link( $i, $linktext = '' ) {
		$linktext = ( $linktext ) ? $linktext : $i;
		return "<a class='page-numbers' href='". esc_html( get_pagenum_link( $i ) ). "'>{$linktext}</a> ";
	}
}


/*
postviews
Origin: http://of.gs/un-plugin-post-views.html
Modify: zwwooooo http://zww.me
Version：0.2.0
*/
function custom_the_views($post_id, $echo=true, $unit=' views') {
	$count_key = 'views';
	$views = get_post_custom($post_id);
	$views = intval($views['views'][0]);
	if ($views == '') {
		return '';
	} else {
		if ($echo) {
			echo number_format_i18n($views) . $unit;
		} else {
			return number_format_i18n($views) . $unit;
		}
	}
}
function set_post_views() {
	global $post;
	$post_id = intval($post->ID);
	$count_key = 'views';
	$views = get_post_custom($post_id);
	$views = intval($views['views'][0]);
	if (is_single() || is_page()) {
		if(!update_post_meta($post_id, 'views', ($views + 1))) {
			add_post_meta($post_id, 'views', 1, true);
		}
	}
}
add_action('get_header', 'set_post_views');

/*
Plugin Name: Quotmarks Replacer
Plugin URI: http://sparanoid.com/work/quotmarks-replacer/
Description: A plugin disables wptexturize founction that keeps all quotation marks and suspension points in half-width form.
Version: 2.6.5
Author: Tunghsiao Liu
Author URI: http://sparanoid.com/
Author Email: info@sparanoid.com
License: GPLv2 or later
*/
$qmr_work_tags = array(
	'the_title',             // http://codex.wordpress.org/Function_Reference/the_title
	'the_content',           // http://codex.wordpress.org/Function_Reference/the_content
	'the_excerpt',           // http://codex.wordpress.org/Function_Reference/the_excerpt
	// 'list_cats',          Deprecated. http://codex.wordpress.org/Function_Reference/list_cats
	'single_post_title',     // http://codex.wordpress.org/Function_Reference/single_post_title
	'comment_author',        // http://codex.wordpress.org/Function_Reference/comment_author
	'comment_text',          // http://codex.wordpress.org/Function_Reference/comment_text
	// 'link_name',          Deprecated.
	// 'link_notes',         Deprecated.
	'link_description',      // Deprecated, but still widely used.
	'bloginfo',              // http://codex.wordpress.org/Function_Reference/bloginfo
	'wp_title',              // http://codex.wordpress.org/Function_Reference/wp_title
	'term_description',      // http://codex.wordpress.org/Function_Reference/term_description
	'category_description',  // http://codex.wordpress.org/Function_Reference/category_description
	'widget_title',          // Used by all widgets in themes
	'widget_text'            // Used by all widgets in themes
);
foreach ( $qmr_work_tags as $qmr_work_tag ) {
	remove_filter ($qmr_work_tag, 'wptexturize');
}

/*
Plugin Name: spam_to_blacklist
Plugin URI: http://www.jiucool.com/Spam_To_Blacklist/
Description: spam_to_blacklist 本插件功能是当后面将某些评论进行spam归类的时候，顺便直接将留言者的邮箱加入到后面的评论黑名单里，以后此邮件永远不会评论成功^_^ Version: 1.1 由 zwwooooo 修正兼容新版 WP (WP3.5.1测试通过) http://zww.me/spam-to-blacklist.z-turn
Author: <a href="http://www.jiucool.com">Jiucool</a> ,邮箱：jiucool@gmail.com
Version: 1.1
*/
add_action ( 'spammed_comment','spam_to_blacklist',1,1);
function spam_to_blacklist($comment_id) {
	global $wpdb;
	$blackvalues = get_option("blacklist_keys");
	$blackvalues_array = explode("\n", $blackvalues);
	if ( $the_email = get_comment($comment_id)->comment_author_email ) {
		if ( in_array($the_email, $blackvalues_array) ) {
			$the_email = '';
		} else {
			$the_email = "\n". $the_email;
		}
	}
	if ( $the_url = get_comment($comment_id)->comment_author_url ) {
		#$the_url = split( '//', esc_url($the_url) );
		$the_url = explode( '//', esc_url($the_url) );
		$the_url = rtrim($the_url[1],'/');
		if ( in_array($the_url, $blackvalues_array) ) {
			$the_url = '';
		} else {
			$the_url = "\n". $the_url;
		}
	}
	if ($the_email || $the_url) {
		$blackvalues .= $the_email . $the_url;
		update_option('blacklist_keys', $blackvalues);
	}
}

//////// Mp3 player
function mp3player($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'no',"loop"=>'no'),$atts));
	return '<embed src="'.get_bloginfo('template_directory').'/player.swf?soundFile='.$content.'&bg=0xf8f8f8&leftbg=0xeeeeee&lefticon=0x666666&rightbg=0xcccccc&rightbghover=0x999999&righticon=0x666666&righticonhover=0xFFFFFF&text=0x666666&slider=0x666666&track=0xFFFFFF&border=0x666666&loader=0x9FFFB8&loop=yes&autostart='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="290" height="30">';
}
add_shortcode('mp3','mp3player');


