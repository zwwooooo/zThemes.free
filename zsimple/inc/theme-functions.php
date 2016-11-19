<?php
// -----------------------------------------------
// Modify
// -----------------------------------------------

/**
 * Modify: Admin bar style
 */
add_action('get_header', 'remove_admin_bar_style');
add_action( 'wp_head', 'diy_admin_bar_style' );
function remove_admin_bar_style() {
		remove_action('wp_head', 'wp_admin_bar_header');
		remove_action('wp_head', '_admin_bar_bump_cb');
}
function diy_admin_bar_style() {
	echo '
	<style type="text/css">
		#wpadminbar{width:35px;min-width:0;background:transparent;opacity:0.85;}
		#wpadminbar:hover{width:100%;}
		#wp-toolbar ul > li{display:none;}
		#wp-toolbar li#wp-admin-bar-wp-logo{display:block;background-color:#49629e;border-radius:0 0 50%;}
		#wpadminbar:hover li#wp-admin-bar-wp-logo{background-color:#333;border-radius:0;}
		#wp-toolbar:hover ul > li{display:block;background-color:#333;}
		#wpadminbar .ab-top-secondary{float:left;}
	</style>';
}

// -----------------------------------------------
// Useful Functions, Custom Functions
// -----------------------------------------------

/**
 * use wp_cache to cache data - by zww.me
 */
function zoo_wp_cache($key='', $group='default', $data='', $expire=0, $cache = true){
	if ($cache) {
		$output = wp_cache_get($key, $group);
		if(false === $output){
			$output = $data;
			wp_cache_set($key, $data, $group, $expire);
		}
	} else {
		$output = $data;
	}
	echo $output;
}
//// 清空缓存
function clear_wp_cache_when_save_post() {
	wp_cache_delete('zoo_recent_posts', 'simple_wp_cache');
	wp_cache_delete('zoo_recently_updated_posts', 'simple_wp_cache');
	wp_cache_delete('zoo_most_popular', 'simple_wp_cache');
}
add_action('save_post', 'clear_wp_cache_when_save_post'); // 新发表文章/修改文章时

function clear_wp_cache_comment_action() {
	wp_cache_delete('zoo_rc_comments', 'simple_wp_cache');
	wp_cache_delete('zoo_mostactive', 'simple_wp_cache');
}
add_action('comment_post', 'clear_wp_cache_comment_action'); // 新评论发生时
add_action('edit_comment', 'clear_wp_cache_comment_action'); // 评论被编辑过
add_action('wp_set_comment_status', 'clear_wp_cache_comment_action'); // 改变评论状态时

/**
 * Custom Navi Function
 */
function zoo_content_nav( $nav_id ) {
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

/**
 * utf-8 字符串截取函数 edit by zwwooooo
 * $sourcestr：字符串，默认空
 * $i：开始截取地方，默认0
 * $cutlength：截取长度（文字个数），默认150
 * $endstr：截取后的字符串末尾字符串，默认是 “...”
 */
function zoo_substr($sourcestr='',$i=0,$cutlength=150,$endstr='...')
{
	$str_length=strlen($sourcestr);//字符串的字节数
	$n=0;
	$returnstr='';
	while (($n<$cutlength) and ($i<=$str_length))
	{
		$temp_str=substr($sourcestr,$i,1);
		$ascnum=Ord($temp_str);//ascii码
		if ($ascnum>=224)
		{
			$returnstr=$returnstr.substr($sourcestr,$i,3);
			$i=$i+3;
			$n++;
		}elseif ($ascnum>=192)
		{
			$returnstr=$returnstr.substr($sourcestr,$i,2);
			$i=$i+2;
			$n++;
		}else
		{
			$returnstr=$returnstr.substr($sourcestr,$i,1);
			$i=$i+1;
			$n=$n+0.5;
		}
	}
	if($i<$str_length)$returnstr.=$endstr;
	return $returnstr;
}

/**
 * Time Since Function by zwwooooo
 */
function zoo_time_since( $type='post', $older_date, $days=30, $NEED_ID='', $new=false ) {
	$tf = $type == 'comment' ? 'get_comment_date' : 'get_post_time';
	$tformat = $type == 'comment' ? 'Y-m-d H:i' : ' jS, Y';
	$timediff = time() - $older_date;
	$output = '';
	if ($timediff <= 60*60*24*$days) { // Show Time Diff
		$output = ($type=='post' && $new==true && $timediff <= 60*60*24) ? '<span class="post-new">NEW!</span>' : human_time_diff($older_date,current_time('timestamp')).'前';
	} else { // Show Datetime
		$output = ($tf=='get_post_time') ? date('M',$older_date).$tf($tformat,$NEED_ID) : $tf($tformat,$NEED_ID);
	}
	return $output;
}

/**
 * 分类/标签列表获取分类/标签id Function by zwwooooo
 */
function zoo_single_term_id( $prefix = '', $display = true, $value='term_id' ) {
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

/**
 * 最新评论函数
 */
function zoo_rc_comments($show_comments = 8, $my_email = '', $get_comments_num=100) {
	if ($my_email=='') $my_email=get_bloginfo ('admin_email');
	if ($get_comments_num=='') $get_comments_num=100+$show_comments;
	$output='';
	$i = 1;
	$comments = get_comments('number='.$get_comments_num.'&status=approve&type=comment');
	if ( !empty($comments) ) {
		foreach ($comments as $rc_comment) {
			if ($rc_comment->comment_author_email != $my_email) {
				$output .= '<li>'.get_avatar_zlazyload($rc_comment->comment_author_email,32,'',$rc_comment->comment_author)
					.'<a rel="nofollow" href="'.get_comment_link( $rc_comment->comment_ID, array('type' => 'all')).'" title="'.strip_tags($rc_comment->comment_content).' on《'.get_the_title($rc_comment->comment_post_ID).'》">'
					.convert_smilies(zoo_substr(strip_tags($rc_comment->comment_content),0,20))
					.'</a><span class="rc-info">by '.$rc_comment->comment_author.' '.get_comment_date('Y/m/d H:i',$rc_comment->comment_ID).'</span></li>';
				if ($i == $show_comments) break; //评论数量达到退出遍历
				$i++;
			}
		}
	}
	$output=($output == '') ? '<li>No data.</li>' : $output;
	return $output;
}

/**
 * 读者墙函数
 */
function zoo_mostactive($limit_num = 12, $months = 1) {
	global $wpdb;
	$time = $months . ' MONTH';
	$noneurl = home_url();
	$my_email = "'" . get_bloginfo ('admin_email') . "'";
	$counts = $wpdb->get_results("
		SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email
		FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
		ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID)
		WHERE comment_date > date_sub( NOW(), INTERVAL $time )
		AND comment_author_email != $my_email
		AND post_password=''
		AND comment_approved='1'
		AND comment_type='') AS tempcmt	GROUP BY comment_author_email
		ORDER BY cnt DESC LIMIT $limit_num
	");
	if( !empty($counts) ) {
		foreach ($counts as $count) {
			$c_url = $count->comment_author_url;
			if (!$c_url) $c_url = $noneurl;
			$title_alt = $count->comment_author . ' ('. $count->cnt. ' comments)';
			$output .= '<a rel="external nofollow" href="'. $c_url . '" title="' .$title_alt
			// . 'comments)"><img src="http://im.zww.im/gravatar/cache/avatar/'.md5(strtolower($count->comment_author_email)).'" alt="" class="avatar" /></a></li>';
			. '">'.get_avatar($count->comment_author_email,$size='40',$default='',$title_alt).'</a>';
		}
	}
	$output=($output == '') ? 'No data.' : $output;
	return $output;
}

/**
 * recent posts
 */
function zoo_recent_posts($num=12, $post_type='post'){
	global $post;
	$tmp_post = $post;
	$recent_posts = get_posts( array(
		'post_type'   => $post_type,
		'numberposts' => $num,
		'orderby'     => 'ASC'
	) );
	foreach( $recent_posts as $post ) : setup_postdata($post);
		$output .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . zoo_substr(get_the_title(), 0, 18) . '</a></li>' . "\n";
	endforeach; $post = $tmp_post; setup_postdata($post);
	return $output;
}

/**
 * Recently Updated Posts by zwwooooo
 */
function zoo_recently_updated_posts($num=10, $days=7) {
	global $post;
	$output='';
	$arg = array(
		'post_type'      => array('post', 'archives'),
		'post_status'    => 'publish',
		'orderby'        => 'modified',
		'order'          => 'DESC',
		'posts_per_page' => -1,
		'no_found_rows'  => true
	);
	query_posts($arg);
	$i=0;
	while ( have_posts() && $i<$num ) : the_post();
		if (current_time('timestamp') - get_the_time('U') > 60*60*24*$days) {
			$i++;
			$the_title_value=get_the_title();
			$output .= '<li><a href="' . get_permalink() . '" title="' . $the_title_value.'">'
			. zoo_substr($the_title_value,0,18) . '</a><span class="updatetime"><br />&raquo; 修改时间: '
			. get_the_modified_time('Y.m.d G:i') . '</span></li>';
		}
	endwhile;
	wp_reset_query();
	if ( false != $cache_expire ) wp_cache_set('recently_updated_posts', $output, 'simple_wp_cache', $cache_expire);
	$output = ($output == '') ? '<li>No data.</li>' : $output;

	return $output;
}

/**
 * Related Posts
 */
function zoo_related_posts($post_num=5, $type_cat='category', $type_tag='post_tag') {
	global $post;
	$exclude_id = $post->ID;
	$i = 0;
	if ( $type_tag=='post_tag' ) {
		$posttags = get_the_tags();
		if ( $posttags ) {
			$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
			$args = array(
				'post_status' => 'publish',
				'tag__in' => explode(',', $tags), // 只選 tags 的文章.
				'post__not_in' => explode(',', $exclude_id), // 排除已出現過的文章.
				'ignore_sticky_posts' => 1,
				'orderby' => 'comment_date', // 依評論日期排序.
				'posts_per_page' => $post_num
			);
		}
	} else {
		$posttags = get_the_terms($post->ID, $type_tag);
		if ( $posttags ) {
			$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ',';
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => $type_tag,
						'field' => 'id',
						'terms' => explode(',', $tags)
					)
				),
				'post_status' => 'publish',
				'post__not_in' => explode(',', $exclude_id),
				'ignore_sticky_posts' => 1,
				'orderby' => 'comment_date',
				'posts_per_page' => $post_num
			);
		}
	}
	if ( $args ) {
		$rp_query = new WP_Query($args);
		while( $rp_query->have_posts() ) { $rp_query->the_post();
			$output .= '<li><a rel="bookmark" href="' . get_permalink() . '" title="' . get_the_title() . '">' . zoo_substr(get_the_title(),0,22) . '</a></li>';
			$exclude_id .= ',' . $post->ID;
			$i++;
		} wp_reset_postdata();
	}
	if ( $i < $post_num ) {
		if ( $type_cat=='category' ) {
			$cats = '';
			foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
			$args = array(
				'category__in' => explode(',', $cats), // 只選 category 的文章.
				'post__not_in' => explode(',', $exclude_id),
				'ignore_sticky_posts' => 1,
				'orderby' => 'comment_date',
				'posts_per_page' => $post_num - $i
			);
		} else {
			$postcats = get_the_terms($post->ID, $type_cat);
			$cats = ''; foreach ( $postcats as $cat ) $cats .= $cat->term_id . ',';
			$args = array(
				'tax_query' => array(
					array(
						'taxonomy' => $type_cat,
						'field' => 'id',
						'terms' => explode(',', $cats)
					)
				),
				'post_status' => 'publish',
				'post__not_in' => explode(',', $exclude_id),
				'ignore_sticky_posts' => 1,
				'orderby' => 'comment_date',
				'posts_per_page' => $post_num - $i
			);
		}
		if ( $args ) {
			$rp_query = new WP_Query($args);
			while( $rp_query->have_posts() ) { $rp_query->the_post();
				$output .= '<li><a rel="bookmark" href="' . get_permalink() . '" title="' . get_the_title() . '">' . zoo_substr(get_the_title(),0,22) . '</a></li>';
				$i++;
			} wp_reset_query();
		}
	}
	if ( $i == 0 ) {
		$output = '<li>没有相关文章</li>';
	}
	return $output;
}

/**
 * Most Popular
 */
function zoo_most_popular($post_num = 5, $post_type='post'){
	global $post, $wpdb;
	$post_type = "'" . $post_type . "'";
	$exclude_id = $post->ID;
	$myposts = $wpdb->get_results("
		SELECT ID, post_title FROM $wpdb->posts
		WHERE ID != $exclude_id
		AND post_status = 'publish'
		AND post_type = $post_type
		ORDER BY comment_count
		DESC LIMIT $post_num
	"); // get_results() since 0.71 /wp-includes/wp-db.php 
	if ($myposts) {
		foreach($myposts as $mypost) {
			echo '<li><a  rel="bookmark" href="', get_permalink($mypost->ID), '" title="', $mypost->post_title,'">', zoo_substr($mypost->post_title,0,18), '</a></li>';
		}
	}
	return $output;
}

/* Archives list v2014 by zwwooooo | http://zww.me */
function zoo_archives_list($post_type='post') {
	if( !$output = get_option('zww_db_cache_archives_list') ){
		$output = '<div id="archives"><p><a id="al_expand_collapse" href="#">全部展开/收缩</a> <em>(注: 点击月份可以展开)</em></p>';
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => -1, //全部 posts
			'ignore_sticky_posts' => 1 //忽略 sticky posts

		);
		$the_query = new WP_Query( $args );
		$posts_rebuild = array();
		$year = $mon = 0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$post_year = get_the_time('Y');
			$post_mon = get_the_time('m');
			$post_day = get_the_time('d');
			if ($year != $post_year) $year = $post_year;
			if ($mon != $post_mon) $mon = $post_mon;
			$posts_rebuild[$year][$mon][] = '<li>'. get_the_time('d日: ') .'<a href="'. get_permalink() .'">'. get_the_title() .'</a> <em>('. get_comments_number('0', '1', '%') .')</em></li>';
		endwhile;
		wp_reset_postdata();

		foreach ($posts_rebuild as $key_y => $y) {
			$output .= '<h3 class="al_year">'. $key_y .' 年</h3><ul class="al_mon_list">'; //输出年份
			foreach ($y as $key_m => $m) {
				$posts = ''; $i = 0;
				foreach ($m as $p) {
					++$i;
					$posts .= $p;
				}
				$output .= '<li><span class="al_mon">'. $key_m .' 月 <em> ( '. $i .' 篇文章 )</em></span><ul class="al_post_list">'; //输出月份
				$output .= $posts; //输出 posts
				$output .= '</ul></li>';
			}
			$output .= '</ul>';
		}

		$output .= '</div>';
		update_option('zww_db_cache_archives_list', $output);
	}
	echo $output;
}
function clear_db_cache_archives_list() {
	update_option('zww_db_cache_archives_list', ''); // 清空 zww_archives_list
}
add_action('save_post', 'clear_db_cache_archives_list'); // 新发表文章/修改文章时


// -----------------------------------------------
// Content
// -----------------------------------------------

/**
 * 文章末加版权或者其他，Feed也有
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function insertFootNote($content) {
	global $post;
	if(is_single() || is_feed()) {
		$wzlj = get_permalink($post->ID);
		$content.= '<p class="announce">';
		$content.= '<span><strong>声明:</strong></span> 除非注明，<a href="http://zww.me/">ZWWoOoOo</a>文章均为原创，转载请以链接形式标明本文地址';
		$content.= '<br />本文地址: <a href="' . $wzlj . '">' . $wzlj . '</a>';
		$content.= '</p>';
	}
	return $content;
}
add_filter ('the_content', 'insertFootNote');


// -----------------------------------------------
// Comment
// -----------------------------------------------

/**
 * 评论链接加上 nofollow
 */
function add_nofollow_to_comments_popup_link(){
	return ' rel="nofollow" ';
}
add_filter('comments_popup_link_attributes', 'add_nofollow_to_comments_popup_link');

/**
 * 判断单页是否有sidebar和comment
 */
function zoo_have_sidebar_and_comment() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) && !is_page('announcement') ) return true;
	return false;
}

/**
 * Custom smilies path
 */
function custom_smilies_src($src, $img){
    return ZOO_THEME_URI.'/smilies/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 12, 2); // 優先級10(默認), 變量2個($src 和 $img)

/**
 * 获取表情按钮: WP表情/自定义表情路径
 */
function zoo_smiley_button($custom=false, $before='', $after=''){
	if ($custom==true)
		$smiley_url=ZOO_THEME_URI.'/smilies';
	else
		$smiley_url=site_url().'/wp-includes/images/smilies';
	echo $before;
	?>
		<a href="javascript:zoo_grin(':?:')"><img src="<?php echo $smiley_url; ?>/icon_question.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':razz:')"><img src="<?php echo $smiley_url; ?>/icon_razz.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':sad:')"><img src="<?php echo $smiley_url; ?>/icon_sad.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':evil:')"><img src="<?php echo $smiley_url; ?>/icon_evil.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':!:')"><img src="<?php echo $smiley_url; ?>/icon_exclaim.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':smile:')"><img src="<?php echo $smiley_url; ?>/icon_smile.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':oops:')"><img src="<?php echo $smiley_url; ?>/icon_redface.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':grin:')"><img src="<?php echo $smiley_url; ?>/icon_biggrin.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':eek:')"><img src="<?php echo $smiley_url; ?>/icon_surprised.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':shock:')"><img src="<?php echo $smiley_url; ?>/icon_eek.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':???:')"><img src="<?php echo $smiley_url; ?>/icon_confused.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':cool:')"><img src="<?php echo $smiley_url; ?>/icon_cool.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':lol:')"><img src="<?php echo $smiley_url; ?>/icon_lol.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':mad:')"><img src="<?php echo $smiley_url; ?>/icon_mad.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':twisted:')"><img src="<?php echo $smiley_url; ?>/icon_twisted.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':roll:')"><img src="<?php echo $smiley_url; ?>/icon_rolleyes.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':wink:')"><img src="<?php echo $smiley_url; ?>/icon_wink.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':idea:')"><img src="<?php echo $smiley_url; ?>/icon_idea.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':arrow:')"><img src="<?php echo $smiley_url; ?>/icon_arrow.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':neutral:')"><img src="<?php echo $smiley_url; ?>/icon_neutral.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':cry:')"><img src="<?php echo $smiley_url; ?>/icon_cry.gif" alt="" /></a>
		<a href="javascript:zoo_grin(':mrgreen:')"><img src="<?php echo $smiley_url; ?>/icon_mrgreen.gif" alt="" /></a>
<?php
	echo $after;
}

/**
 * Ajax_data_zoo_smiley_button
 */
function Ajax_data_zoo_smiley_button(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_data_zoo_smiley_button'  ){
		nocache_headers();	//(FIX for IE)
		
		zoo_smiley_button(true, '<br />');

		die();
	}
}
add_action('init', 'Ajax_data_zoo_smiley_button');

/**
 * for Ajax: guest_comments
 */
function guest_comments(){
	if( isset($_GET['action'])&& $_GET['action'] == 'guest_comments'  ){
		nocache_headers();	//(FIX for IE)
		
		$gc_userEmail = isset($_GET['gc_userEmail']) ? $_GET['gc_userEmail'] : null;
		?>
		
		<ul>
			<?php
			$announcement = '';
			// $comments = get_comments("status=approve&number=10&author_email=$gc_userEmail");
			$arg = array(
				'status' => 'approve',
				'number' => 12,
				'post_tyle' => array('post','archives'),
				'author_email' => $gc_userEmail
			);
			$comments = get_comments($arg);
			$home_url=home_url();
			if ( !empty($comments) ) {
				foreach ($comments as $comment) {
					$comment_link=get_comment_link( $comment->comment_ID, array('type' => 'all'));
					$announcement .= '<li><span>' . get_comment_date('Y/m/d H:i',$comment->comment_ID) . '</span> <a rel="nofollow" href="'. $comment_link .'" title="on《'. get_the_title($comment->comment_post_ID) .'》">'. convert_smilies(strip_tags($comment->comment_content)) . '</a></li>';
				}
			}
			if ( empty($announcement) ) $announcement = '<li class="reply">我发现您还没评论过 ^_^</li>';
			echo $announcement;
			?>
		</ul>
		
		<?php
		die();
	}
}
add_action('init', 'guest_comments');

/**
 * Ajax评论翻页内容函数
 */
function AjaxCommentsPage(){
	if( isset($_GET['action'])&& $_GET['action'] == 'AjaxCommentsPage'  ){
		global $post,$wp_query,$wp_rewrite;
		$postid = isset($_GET['post']) ? $_GET['post'] : null;
		$pageid = isset($_GET['page']) ? $_GET['page'] : null;
		$callback = isset($_GET['callback']) ? $_GET['callback'] : 'mytheme_comment';
		if(!$postid || !$pageid){
			fail(__('Error post id or comment page id.'));
		}
		// get comments
		$comments = get_comments('status=approve&post_id='.$postid);
		$post = get_post($postid);
		if(!$comments){
			fail(__('Error! can\'t find the comments'));
		}
		if( 'desc' != get_option('comment_order') ){
			$comments = array_reverse($comments);
		}
		$topnew = '';
		if ( $postid==25111 ) $topnew = '&reverse_top_level=true';
		// set as singular (is_single || is_page || is_attachment)
		$wp_query->is_singular = true;
		// response 注意修改callback为你自己的，没有就去掉callback
		if ($pageid > 1) {
			wp_list_comments('type=all&callback=mytheme_comment_top3&per_page=3&page=1&max_depth=-1', $comments);
			echo '<li class="comment_top3">......</li>';
		}
		wp_list_comments('callback=' . $callback . '&type=all&page=' . $pageid . '&per_page=' . get_option('comments_per_page') . $topnew, $comments);
		echo '<!--zww-AJAX-COMMENT-PAGE-->';
		// echo '<span class="pages">ZWW</span>';
		$args=array( 'prev_text'=>'&laquo;', 'next_text'=>'&raquo;', 'total'=> get_comment_pages_count($comments, get_option('comments_per_page')), 'current'=>$pageid );
		paginate_comments_links($args);
		die;
	}
}
add_action('init', 'AjaxCommentsPage');

/**
 * LazyLoad for avatar
 */
function get_avatar_zlazyload($comment_author_email,$size='50',$default='',$alt='') {
	$avatar = get_avatar($comment_author_email,$size='50',$default,$alt);
	$avatar = str_replace(' src=', ' zlazyload=', $avatar);
	$avatar = str_replace('<img', '<img class="avatar zlazyload" src="'.ZOO_THEME_URI.'/img/zlazyload.gif"', $avatar);
	return $avatar;
}

/**
 * Mini Pagenavi v1.0 by Willin Kan. Edit by zwwooooo
 */
if ( !function_exists('pagenavi') ) {
	function pagenavi( $p = 1 ) { // 取当前页前后各 $p-1 页
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


/**
 * wp_list_comments() callback
 */
function mytheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
//主评论计数器初始化 begin - by zwwooooo
	global $commentcount,$page;
	if(!$commentcount) { //初始化楼层计数器
		#$page = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args ); //获取当前评论列表页码
		$page = ( get_query_var('cpage') ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args ); //获取当前评论列表页码
		$cpp=get_option('comments_per_page'); //获取每页评论显示数量
		$commentcount = $cpp * ($page - 1);
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
					<?php //主评论楼层号 - by zwwooooo
					if(!$comment->comment_parent) {
						echo '<div class="floor">';
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
						echo '</div>';
					}
					?>
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
					<span class="comment-meta commentmetadata"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?> <a rel="nofollow" href="<?php echo get_permalink($comment->comment_post_ID).($page > 1 ? '/comment-page-'.$page : '' ).'#comment-'.$comment->comment_ID; //esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">#</a><?php edit_comment_link(__('(Edit)'),'  ',''); ?></span>
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
				<?php //主评论楼层号 - by zwwooooo
				if(!$comment->comment_parent) {
					echo '<div class="floor">';
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
					echo '</div>';
				}
				?>
			</div>
<?php
		break;
	}
}

/**
 * wp_list_comments() callback: for top3
 */
function mytheme_comment_top3($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
//主评论计数器初始化 begin - by zwwooooo
	global $commentcount_top,$page;
	if(!$commentcount_top) { //初始化楼层计数器
		#$page = ( !empty($in_comment_loop) ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args ); //获取当前评论列表页码
		$page = ( get_query_var('cpage') ) ? get_query_var('cpage') : get_page_of_comment( $comment->comment_ID, $args ); //获取当前评论列表页码
		$cpp=get_option('comments_per_page'); //获取每页评论显示数量
		$commentcount_top = $cpp * ($page - 1);
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
						<?php //主评论楼层号 - by zwwooooo
						if(!$comment->comment_parent) {
							echo '<div class="floor">';
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
							echo '</div>';
						}
						?>
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
					<span class="comment-meta commentmetadata"><?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()); ?> <a rel="nofollow" href="<?php echo get_permalink($comment->comment_post_ID).($page > 1 ? '/comment-page-'.$page : '' ).'#comment-'.$comment->comment_ID; //esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">#</a><?php edit_comment_link(__('(Edit)'),'  ',''); ?></span>
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


