<?php
//////// use wp_cache to cache data - by zww.me
function zfunc_wp_cache($key='', $group='default', $data='', $expire=0, $cache = true){
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
	wp_cache_delete('zfunc_recent_posts', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_most_views_posts', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_recently_updated_posts', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_most_comm_posts', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_tag_cloud', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_most_popular', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_most_popular_archives', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_zsay_posts_info_area', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_zsay_posts_home_mobile', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_zwwooooo_avatar', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_ztheme_posts_free', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_ztheme_posts_premium', 'zwwooooo_wp_cache');
}
add_action('save_post', 'clear_wp_cache_when_save_post'); // 新发表文章/修改文章时

function clear_wp_cache_comment_action() {
	wp_cache_delete('zfunc_rc_comments', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_most_comm_posts', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_mostactive', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_zsay_posts_info_area', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_zsay_posts_home_mobile', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_ztheme_posts_free', 'zwwooooo_wp_cache');
	wp_cache_delete('zfunc_ztheme_posts_premium', 'zwwooooo_wp_cache');
}
add_action('comment_post', 'clear_wp_cache_comment_action'); // 新评论发生时
add_action('edit_comment', 'clear_wp_cache_comment_action'); // 评论被编辑过
add_action('wp_set_comment_status', 'clear_wp_cache_comment_action'); // 改变评论状态时


/*
 * 小功能类函数 ==================== */

/*
////////utf-8 substr() for none mb_substr()
if ( !function_exists('mb_substr') ) {
	function mb_substr( $str, $start, $length, $encoding ) {
    return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}'.
    '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $length . '}).*#s', '$1', $str);
	}
}
*/

/*
utf-8 字符串截取函数 edit by zwwooooo
$sourcestr：字符串，默认空
$i：开始截取地方，默认0
$cutlength：截取长度（文字个数），默认150
$endstr：截取后的字符串末尾字符串，默认是 “...”
*/
function z_substr($sourcestr='',$i=0,$cutlength=150,$endstr='...')
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

//////// 文章末加版权或者其他，Feed也有
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

//////// Time Since Function by zwwooooo
function time_since_zww( $type='post', $older_date, $days=30, $NEED_ID='', $new=false ) {
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

//////// 分类/标签列表获取分类/标签id Function by zwwooooo
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

//////// 评论链接加上 nofollow
function add_nofollow_to_comments_popup_link(){
	return ' rel="nofollow" ';
}
add_filter('comments_popup_link_attributes', 'add_nofollow_to_comments_popup_link');

//////// 防止访客冒充博主发表评论 by zwwooooo
function z_user_check($incoming_comment) {
	global $user_ID;
	$isSpam = 0;
	if ( strtolower(trim($incoming_comment['comment_author'])) == 'zwwooooo' ) $isSpam = 1;
	if ( strtolower(trim($incoming_comment['comment_author'])) == 'zww' ) $isSpam = 1;
	if ( strtolower(trim($incoming_comment['comment_author'])) == 'zww.me' ) $isSpam = 1;
	if ( strtolower(trim($incoming_comment['comment_author_email'])) == 'zwwblog@gmail.com') $isSpam = 1;
	if ( strtolower(trim($incoming_comment['comment_author_email'])) == 'zwwooooo@gmail.com') $isSpam = 1;
	if (!$isSpam || intval($user_ID) > 0) { return $incoming_comment; } else { wp_die('请勿冒充博主发表评论!'); }
}
add_filter( 'preprocess_comment', 'z_user_check' );



//////// 最新评论函数
function zfunc_rc_comments($show_comments = 8, $my_email = '', $get_comments_num=100) {
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
					.convert_smilies(z_substr(strip_tags($rc_comment->comment_content),0,18))
					.'</a><span class="rc-info">by '.$rc_comment->comment_author.' '.get_comment_date('Y/m/d H:i',$rc_comment->comment_ID).'</span></li>';
				if ($i == $show_comments) break; //评论数量达到退出遍历
				$i++;
			}
		}
	}
	$output=($output == '') ? '<li>No data.</li>' : $output;
	return $output;
}

//////// recent posts
function zfunc_recent_posts($num=12, $post_type='post'){
	global $post;
	$tmp_post = $post;
	$recent_posts = get_posts( array(
		'post_type'   => $post_type,
		'numberposts' => $num,
		'orderby'     => 'ASC'
	) );
	foreach( $recent_posts as $post ) : setup_postdata($post);
		$output .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . z_substr(get_the_title(), 0, 18) . '</a></li>' . "\n";
	endforeach; $post = $tmp_post; setup_postdata($post);
	return $output;
}

//////// most views posts by zwwooooo
function zfunc_most_views_posts($num=12, $post_type='post'){
	global $post;
	$tmp_post = $post;
	$get_posts = new WP_Query;
	$today = getdate();
	$args = array(
		'post_type'   => $post_type,
		'meta_query' => array(
			array(
				'key' => 'views',
				// 'value' => 'yes',
			)
		),
		'date_query' => array(
			array(
				'column' => 'post_date_gmt',
				'before' => array(
						'year' => $today["year"],
						'month' => $today["mon"],
						'day' => $today["mday"],
					),
			),
			array(
				'column' => 'post_date_gmt',
				'after' => '2 month ago',
			)
		),
		'posts_per_page' => $num,
		'orderby'     => 'meta_value',
		'order'     => 'ASC'
	);
	$most_views_posts = $get_posts->query($args);
	foreach( $most_views_posts as $post ) : setup_postdata($post);
		$views = '';
		if(function_exists('custom_the_views')) $views = '<span class="updatetime"><br />&raquo; ' . custom_the_views($posd->ID, 0, ' 次阅读') . '</span>';
		$output .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . z_substr(get_the_title(), 0, 18) . '</a>' . $views . '</li>' . "\n";
	endforeach; $post = $tmp_post; setup_postdata($post);
	return $output;
}

//////// random posts
function zfunc_rand_posts($num=12, $post_type='post'){
	global $post;
	$tmp_post = $post;
	$rand_posts = get_posts( array(
		'post_type'   => $post_type,
		'numberposts' => $num,
		'orderby'     => 'rand'
	) );
	foreach( $rand_posts as $post ) : setup_postdata($post);
		$output .= '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . z_substr(get_the_title(), 0, 18) . '</a></li>' . "\n";
	endforeach; $post = $tmp_post; setup_postdata($post);
	return $output;
}

//////// 读者墙函数
function zfunc_mostactive($limit_num = 12) {
	global $wpdb;
	$time = '1 MONTH';
	$noneurl = 'http://zww.me/';
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

//////// 某段时间内热评文章
function zfunc_most_comm_posts($days=7, $nums=10, $post_type='post') { //$days参数限制时间值，单位为‘天’，默认是7天；$nums是要显示文章数量
	global $wpdb;
	$today = date("Y-m-d H:i:s"); //获取今天日期时间
	$daysago = date( "Y-m-d H:i:s", strtotime($today) - ($days * 24 * 60 * 60) );  //Today - $days
	$result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date
		FROM $wpdb->posts
		WHERE post_status = 'publish'
		AND post_type = '$post_type'
		AND post_date BETWEEN '$daysago' AND '$today'
		ORDER BY comment_count
		DESC LIMIT 0 , $nums");
	if( !empty($result) ) {
		foreach ($result as $topten) {
			$postid = $topten->ID;
			$title = $topten->post_title;
			$commentcount = $topten->comment_count;
			if ($commentcount != 0) {
				$output .= '<li><a href="'.get_permalink($postid).'" title="'.$title.'">'.z_substr($title,0,16).'</a><span class="updatetime"><br />'.$commentcount.' 条评论</li>';
			}
		}
	}
	$output = ($output == '') ? '<li>No data.</li>' : $output;
	return $output;
}

//////// Recently Updated Posts by zwwooooo
function zfunc_recently_updated_posts($num=10, $days=7) {

	$time_start = microtime(true);

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
			. z_substr($the_title_value,0,18) . '</a><span class="updatetime"><br />&raquo; 修改时间: '
			. get_the_modified_time('Y.m.d G:i') . '</span></li>';
		}
	endwhile;
	wp_reset_query();
	if ( false != $cache_expire ) wp_cache_set('recently_updated_posts', $output, 'zwwooooo_wp_cache', $cache_expire);
	$output = ($output == '') ? '<li>No data.</li>' : $output;

	$time_end = microtime(true);
	$time = $time_end - $time_start;

	return $output.'<i style="display:none">'.$time.'</i>';
}

//////// tag cloud
/**
 * Change tag cloud inline style to CSS classes.
 *
 * @param  string $tags
 * @return string
 */
add_filter( 'wp_tag_cloud', 'zfunc_unstyled_tag_cloud' );
function zfunc_unstyled_tag_cloud( $tags )
{
	$tags =	preg_replace(
		"~ class='tag-link-(\d+)'~",
		'',
		$tags
	);
	return preg_replace(
		"~ style='font-size: ((\d+)|(\d+)\.(\d+))px;'~",
		' class="tag-cloud-size-\2\3"',
		$tags
	);
}
function zfunc_tag_cloud(){
	$output = '';
	$output = wp_tag_cloud( array(
		// 'taxonomy'  => array('post_tag', 'archives_tag'),
		'taxonomy'  => array('post_tag'),
		'echo'      => 0,
		'unit'      => 'px',
		'smallest'  => 12,
		'largest'   => 24,
		'number'    => 15,
		'separator' => ' '
	) );
	$output .= wp_tag_cloud( array(
		'taxonomy'  => array('archives_tag'),
		'echo'      => 0,
		'unit'      => 'px',
		'smallest'  => 12,
		'largest'   => 24,
		'number'    => 24,
		'separator' => ' '
	) );
	return $output;
}

////////Related Posts
function zfunc_related_posts($post_num=5, $type_cat='category', $type_tag='post_tag') {
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
			$output .= '<li><a rel="bookmark" href="' . get_permalink() . '" title="' . get_the_title() . '">' . z_substr(get_the_title(),0,22) . '</a></li>';
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
				$output .= '<li><a rel="bookmark" href="' . get_permalink() . '" title="' . get_the_title() . '">' . z_substr(get_the_title(),0,22) . '</a></li>';
				$i++;
			} wp_reset_query();
		}
	}
	if ( $i == 0 ) {
		$output = '<li>没有相关文章</li>';
	}
	return $output;
}

//////// Most Popular 热评文章 - 全部文章
function zfunc_most_popular($post_num = 5, $post_type='post'){
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
			echo '<li><a  rel="bookmark" href="', get_permalink($mypost->ID), '" title="', $mypost->post_title,'">', z_substr($mypost->post_title,0,18), '</a></li>';
		}
	}
	return $output;
}

//////// zfunc_WP_Query
function zfunc_WP_Query($args='', $structure='') {
	global $post;
	$output = '';
	if ( $the_query = new WP_Query( $args ) ){
		ob_start();
		$i=0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			if ( $structure === 'zsay-info-area' ){ // get zSay posts, return $output.
				++$i;
				$active = ($i==1) ? ' active' : '';
				$c = rand(1,3);
				if ( $c==1 ) {
					$style = ' class="orange' .$active. '"';
				} elseif ( $c==2 ) {
					$style = ' class="blue' .$active. '"';
				} elseif ( $c==3 ) {
					$style = ' class="green' .$active. '"';
				} else {
					$style = '';
				}

				// $content = apply_filters('the_content', $post->post_content);
				// preg_match('<p>(.*)<\/p>/i', $content, $matches);
				// $content = $matches[0];
				$content = get_first_p($post);
				$more = ($content[1]>1) ? ' ... <a class="zsay-more" href="' .get_permalink(). '" rel="nofollow">more</a>' : '';
				?>
				<li<?php echo $style; ?>>
					<p style="min-height:32px;"><?php echo wp_trim_words( $content[0], 80, null ) . $more; ?> <span class="zsay-info">(<?php echo get_comments_number('0', '1', '%'); ?> comment / <?php the_time('Y.m.d'); ?>)</span></p>
					<p class="zsay-meta">『<a class="zsay-title" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>』 in <a class="all-zsay" href="/zsay" rel="nofollow">zSay</a></p>
				</li>
			<?php } elseif ( $structure === 'zsay-home-mobile' ){ // get zSay posts, return $output.
				$content = get_first_p($post);
				$more = ($content[1]>1) ? ' ... <a class="zsay-more" href="' .get_permalink(). '" rel="nofollow">more</a>' : '';
				?>
				<li>
					<a class="zsay-title" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
					<span class="zsay-info"><?php echo get_comments_number('0', '1', '%'); ?> comment / <?php the_time('Y.m.d'); ?></span>
				</li>
			<?php } elseif ( $structure === 'zthemes' ) { // zThemes ?>
					<li>
						<?php post_thumbnail(0,0); ?>
						<h2><a href="<?php the_permalink(); ?>"><?php echo z_substr($post->post_title, 0, 22); ?></a></h2>
					</li>
			<?php } else {
				echo 'Please select style.';
			}
		endwhile;
		wp_reset_postdata();// Reset Post Data
		$output = ob_get_clean();
	}
	if ( $structure === 'zsay-info-area' ){
		if ( empty($output) ) $output = '<li>欢迎光临本博！</li>';
		return '<ul>' .$output. '</ul><div class="info-arrow"><span id="info-arrow-left" class="info-arrow-left none-list"></span><span id="info-arrow-right" class="info-arrow-right"></span></div>';
	} elseif ( $structure === 'zsay-home-mobile' ){
		if ( empty($output) ) $output = '<li>None zSay Post！</li>';
		return '<ul>' .$output. '</ul>';
	} else {
		return $output;
	}
}

//// 获取文章第一段
function get_first_p($post){
	//如果是使用 WLW 这些工具写文章，可能使用<p>和</p>进行分段
	if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,'<p><a><strong><span>')),$matches)){ 
		return array( $matches[1], count($matches) );
	} else {
		//如果直接在 WordPress 写日志，使用换行符（\n）来分段   
		$post_content = explode("\n",trim(strip_tags($post->post_content, '<a><strong><span>'))); 
		return array( $post_content ['0'], count($post_content) );
	}
}


//////// Archives list by zwwooooo | http://zww.me
/*function zww_archives_list() {
	if( !$output = get_option('zww_db_cache_archives_list') ){
		$output = '<div id="archives"><p><a id="al_expand_collapse" href="#">全部展开/收缩</a> <em>(注: 点击月份可以展开)</em></p>';
		$the_query = new WP_Query( array( 'post_type' => array('archives', 'post', 'zsay'), 'posts_per_page' => -1 ) );
		$year=0; $mon=0; $i=0; $j=0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$year_tmp = get_the_time('Y');
			$mon_tmp = get_the_time('m');
			$y=$year; $m=$mon;
			if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
			if ($year != $year_tmp && $year > 0) $output .= '</ul>';
			if ($year != $year_tmp) {
				$year = $year_tmp;
				$output .= '<h3 class="al_year">'. $year .' 年</h3><ul class="al_mon_list">'; //输出年份
			}
			if ($mon != $mon_tmp) {
				$mon = $mon_tmp;
				$output .= '<li><span class="al_mon">'. $mon .' 月</span><ul class="al_post_list">'; //输出月份
			}
			$output .= '<li>'. get_the_time('d日: ') .'<a href="'. get_permalink() .'">'. get_the_title() .'</a> <em>('. get_comments_number('0', '1', '%') .')</em></li>'; //输出文章日期和标题
		endwhile;
		wp_reset_postdata();
		$output .= '</ul></li></ul></div>';
		update_option('zww_db_cache_archives_list', $output);
	}
	echo $output;
}
function clear_db_cache_archives_list() {
	update_option('zww_db_cache_archives_list', ''); // 清空 zww_archives_list
}
add_action('save_post', 'clear_db_cache_archives_list'); // 新发表文章/修改文章时*/
/* Archives list v2014 by zwwooooo | http://zww.me */
function zww_archives_list() {
	if( !$output = get_option('zww_db_cache_archives_list') ){
		$output = '<div id="archives"><p><a id="al_expand_collapse" href="#">全部展开/收缩</a> <em>(注: 点击月份可以展开)</em></p>';
		$args = array(
			'post_type' => array('archives', 'post', 'zsay'),
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


//////// 后台回复评论支持 @xxx 等
function zborder_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_script( 'zborder-theme-options', ZOO_THEME_URI . '/js/admin_reply.js', array('jquery'), 'by-zwwooooo', false );
}
// add_action( 'admin_print_styles', 'zborder_admin_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'zborder_admin_enqueue_scripts' );

//////// 在archive list页面获取 userdata
function get_userdata_in_author_archive() {
	if (is_author()) { //work in wp2.8+
		return (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
	}
	return false;
}

//////// 判断单页是否有sidebar和comment
function zfunc_have_sidebar_and_comment() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) && !is_page('announcement') ) return true;
	return false;
}


//////// 自定义表情路径 by willin
function custom_smilies_src($src, $img){
    return ZOO_THEME_URI.'/smilies/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 12, 2); // 優先級10(默認), 變量2個($src 和 $img)

//////// 获取表情按钮: WP表情/自定义表情路径
function zfunc_smiley_button($custom=false, $before='', $after=''){
	if ($custom==true)
		$smiley_url=ZOO_THEME_URI.'/smilies';
	else
		$smiley_url=site_url().'/wp-includes/images/smilies';
	echo $before;
	?>
		<a href="javascript:zdo_grin(':?:')"><img src="<?php echo $smiley_url; ?>/icon_question.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':razz:')"><img src="<?php echo $smiley_url; ?>/icon_razz.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':sad:')"><img src="<?php echo $smiley_url; ?>/icon_sad.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':evil:')"><img src="<?php echo $smiley_url; ?>/icon_evil.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':!:')"><img src="<?php echo $smiley_url; ?>/icon_exclaim.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':smile:')"><img src="<?php echo $smiley_url; ?>/icon_smile.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':oops:')"><img src="<?php echo $smiley_url; ?>/icon_redface.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':grin:')"><img src="<?php echo $smiley_url; ?>/icon_biggrin.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':eek:')"><img src="<?php echo $smiley_url; ?>/icon_surprised.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':shock:')"><img src="<?php echo $smiley_url; ?>/icon_eek.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':???:')"><img src="<?php echo $smiley_url; ?>/icon_confused.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':cool:')"><img src="<?php echo $smiley_url; ?>/icon_cool.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':lol:')"><img src="<?php echo $smiley_url; ?>/icon_lol.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':mad:')"><img src="<?php echo $smiley_url; ?>/icon_mad.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':twisted:')"><img src="<?php echo $smiley_url; ?>/icon_twisted.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':roll:')"><img src="<?php echo $smiley_url; ?>/icon_rolleyes.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':wink:')"><img src="<?php echo $smiley_url; ?>/icon_wink.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':idea:')"><img src="<?php echo $smiley_url; ?>/icon_idea.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':arrow:')"><img src="<?php echo $smiley_url; ?>/icon_arrow.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':neutral:')"><img src="<?php echo $smiley_url; ?>/icon_neutral.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':cry:')"><img src="<?php echo $smiley_url; ?>/icon_cry.gif" alt="" /></a>
		<a href="javascript:zdo_grin(':mrgreen:')"><img src="<?php echo $smiley_url; ?>/icon_mrgreen.gif" alt="" /></a>
<?php
	echo $after;
}


/* 
 * AJAX ======================================================= */

//////// Ajax_data_zfunc_smiley_button
function Ajax_data_zfunc_smiley_button(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_data_zfunc_smiley_button'  ){
		nocache_headers();	//(FIX for IE)
		
		zfunc_smiley_button(true, '<br />');

		die();
	}
}
add_action('init', 'Ajax_data_zfunc_smiley_button');

//////// Ajax_data_get_comment
function Ajax_data_get_comment(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_data_get_comment'  ){
		nocache_headers();	//(FIX for IE)

		$commentID = isset($_GET['commentID']) ? $_GET['commentID'] : null;
		if ($commentID)
			echo comment_text($commentID);
		else
			echo 'null';

		die();
	}
}
add_action('init', 'Ajax_data_get_comment');

//////// Ajax_data_zsay_posts_home_mobile
function Ajax_data_zsay_posts_home_mobile(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_data_zsay_posts_home_mobile'  ){
		nocache_headers();	//(FIX for IE) ?>

		<article class="post post-zsay-rc">
			<h2 class="title"><a href="/zsay" rel="bookmark">Recent 『zSay』 Posts</a></h2>
			<div class="entry">
				<?php
				$args = array(
					'post_type' => 'zsay',
					'posts_per_page' => 3
				);
				zfunc_wp_cache( 'zfunc_zsay_posts_home_mobile', 'zwwooooo_wp_cache', zfunc_WP_Query($args, 'zsay-home-mobile') );
				// echo zfunc_WP_Query($args, 'zsay-home-mobile');
				?>
				<a class="more-link" href="/zsay" rel="nofollow">All zSay</a>
			</div>
		</article>

		<?php die();
	}
}
add_action('init', 'Ajax_data_zsay_posts_home_mobile');

//////// Ajax_data_1
function Ajax_data_1(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_data_1'  ){
		nocache_headers();	//(FIX for IE) ?>
		
		<?php ////[3]文章开头/尾部广告 ?>
		<p class="entry-top-img"><a href="http://my.hengtian.org/cart.php?gid=78" title="衡天主机 香港机房 美国价格 亚洲速度" rel="nofollow" target="_blank"><img src="http://im.zww.im/images/hengtian.org.png" alt="衡天主机 香港机房 美国价格 亚洲速度" /></a></p>
		<!--zwwooooo-AJAX-Data-->

		<?php die();
	}
}
add_action('init', 'Ajax_data_1');

//////// for Ajax: guest_comments
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

//////// Ajax_data_ztheme
function Ajax_data_ztheme(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_data_ztheme'  ){
		nocache_headers();	//(FIX for IE) ?>
		
		<div class="zthemes" style="border:none;">
			<div class="zthemes_t" style="border:none;"><span>ZWWoOoOo原创/合作免费主题（10+1）</span></div>
			<?php
			zfunc_get_posts( array(
				'post_type' => array('archives', 'post'),
				'include'   => '24037,24652,24668,24761,24846,25131,25156,25163,25391,25435,25504,25823,26017'
			), 2 );
			?>
		</div>
		<!--zwwooooo-AJAX-Data-->
		<div class="zthemes" style="border:none;">
			<div class="zthemes_t" style="border:none;"><span>ZWWoOoOo原创付费主题（5+1）[停售]</span></div>
			<?php
			zfunc_get_posts( array(
				'post_type' => array('archives', 'post'),
				'include'   => '25138,25142,25160,25183,25393,25509'
			), 2 );
			?>
		</div>
		
		<?php
		die();
	}
}
add_action('init', 'Ajax_data_ztheme');

//////// Ajax评论翻页内容函数
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

//// for Mobile
//////// Ajax_rmdirs
function Ajax_mobile_menu(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_mobile_menu'  ){
		nocache_headers();	//(FIX for IE)
		?>

		<div id="mobile-menu-list">
			<div class="mobile-menu-list">
				<h4>New Categories</h4>
				<ul>
					<?php
					$variable1 = wp_list_categories( array(
						'echo'  => 0,
						'taxonomy'  => 'category',
						'title_li'   => '',
						'depth'      => 2,
						'show_count' => 1
					) );
					echo $variable1 = preg_replace('~\((\d+)\)(?=\s*+<)~', '<span>($1)</span>', $variable1);
					?>
				</ul>
			</div>
			<div class="mobile-menu-list">
				<h4>Pages</h4>
				<ul>
					<li><a href="/themes">Themes</a></li>
					<li><a href="/archives">Archives</a></li>
					<li><a href="/tags">All Tags</a></li>
					<li><a href="/my-work">My Work</a></li>
					<li><a href="/about-me">About Me</a></li>
					<li><a href="/links">Links</a></li>
					<li><a href="/ja2">JA2 1.13</a></li>
					<li><a href="/announcement"><strong>公告栏</strong></a></li>
				</ul>
			</div>
			<div class="mobile-menu-list">
				<h4>Old Categories</h4>
				<ul>
					<?php
					$variable2 = wp_list_categories( array(
						'echo'  => 0,
						'taxonomy'  => 'archives_category',
						'title_li'   => '',
						'depth'      => 2,
						'show_count' => 1
					) );
					echo $variable2 = preg_replace('~\((\d+)\)(?=\s*+<)~', '<span>($1)</span>', $variable2);
					?>
				</ul>
			</div>
			<div class="clear"></div>
			<a href="#" id="mml-close">X</a>
		</div>

		<?php
		die();
	}
}
add_action('init', 'Ajax_mobile_menu');

/*
//////// Ajax_rmdirs
function Ajax_rmdirs(){
	if( isset($_GET['action'])&& $_GET['action'] == 'Ajax_rmdirs'  ){
		nocache_headers();	//(FIX for IE)

		if(home_url()=='http://zww.me') {
			// #$dir = split('/themes/',ZOO_THEME_URI); // < PHP7
			// $dir = explode('/themes/',ZOO_THEME_URI);
			// $dir = ABSPATH . 'wp-content/themes/' . $dir[1] . '/rss_cache';
			$dir = '/var/www/zww/nginx_proxy_cache/zww.me';
			zfunc_rmdirs($dir);
		}

		die();
	}
}
add_action('init', 'Ajax_rmdirs');

/////////php删除指定目录下的的文件-用PHP怎么删除某目录下指定的一个文件？
function zfunc_rmdirs($dir){
		//error_reporting(0);    函数会返回一个状态,我用error_reporting(0)屏蔽掉输出
		//rmdir函数会返回一个状态,我用@屏蔽掉输出
	$dir_arr = scandir($dir);
	foreach ($dir_arr as $key=>$val){
		if ($val == '.' || $val == '..') {
			//...
		}	else {
			if (is_dir($dir.'/'.$val)){
				if (@rmdir($dir.'/'.$val) == 'true'){ //去掉@您看看  
					//...
				} else {
					rmdirs($dir.'/'.$val);
				}
			} else {
				unlink($dir.'/'.$val);
			}
		}
	}
}
*/
