<?php

//////// 定义新文章类型 archives，用于老文章(Old-post)
add_action( 'init', 'zfunc_create_post_type' );
function zfunc_create_post_type() {
	$labels = array(
		'name' => 'archives',
		'singular_name' => 'archives',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New archives',
		'edit_item' => 'Edit archives',
		'new_item' => 'New archives',
		'all_items' => 'All archives',
		'view_item' => 'View archives',
		'search_items' => 'Search archives',
		'not_found' =>  'No archives found',
		'not_found_in_trash' => 'No archives found in Trash', 
		'parent_item_colon' => '',
		'menu_name' => 'archives'
	);
	// if (home_url()=='http://z.turn') {
	// 	$args = array(
	// 		'labels' => $labels,
	// 		'public' => true,
	// 		'publicly_queryable' => true,
	// 		'show_ui' => true, 
	// 		'show_in_menu' => true, 
	// 		'show_in_nav_menus' => false, 
	// 		'query_var' => true,
	// 		// 'rewrite' => true,
	// 		'rewrite' => array('slug' => 'archives', 'with_front' => false),
	// 		'capability_type' => 'post',
	// 		'has_archive' => true, 
	// 		'hierarchical' => false,
	// 		'menu_position' => 5,
	// 		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	// 		'taxonomies' => array('archives_category', 'archives_tag') // this is IMPORTANT
	// 	);
	// } else {
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'show_in_nav_menus' => false, 
			'query_var' => true,
			// 'rewrite' => false,
			'rewrite' => array('slug' => 'archives', 'with_front' => false),
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'taxonomies' => array('archives_category', 'archives_tag') // this is IMPORTANT
		);
	// }
	register_post_type( 'archives', $args);
	// flush_rewrite_rules();
}
//////// Add new taxonomy for post type "archives"
add_action( 'init', 'zfunc_create_taxonomies', 0 );
//create two taxonomies, archives_category and archives_tag for the post type "archives"
function zfunc_create_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
			'name' => _x( ' Old-Post 分类目录', 'taxonomy general name' ),
			'singular_name' => _x( ' Old-Post 分类目录', 'taxonomy singular name' ),
			'search_items' =>  __( '分类目录搜索' ),
			'all_items' => __( '全部 Old-Post 分类目录' ),
			'parent_item' => __( ' Old-Post 主分类目录' ),
			'parent_item_colon' => __( ' Old-Post 主分类目录:' ),
			'edit_item' => __( '编辑 Old-Post 分类目录' ),
			'update_item' => __( '更新 Old-Post 分类目录' ),
			'add_new_item' => __( '添加新 Old-Post 分类目录' ),
			'new_item_name' => __( '新 Old-Post 分类目录名称' ),
			'menu_name' => __( 'Old-Post 分类目录' ),
	);     
	register_taxonomy('archives_category', array('archives'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			// 'rewrite' => true
			'rewrite' => array( 'slug' => 'archives/category', 'with_front' => false )
	));

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
			'name' => _x( 'Old-Post 标签', 'taxonomy general name' ),
			'singular_name' => _x( 'Old-Post 标签', 'taxonomy singular name' ),
			'search_items' =>  __( '搜索 Old-Post 标签' ),
			'popular_items' => __( '热门 Old-Post 标签' ),
			'all_items' => __( '全部 Old-Post 标签' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( '编辑 Old-Post 标签' ),
			'update_item' => __( '更新 Old-Post 标签' ),
			'add_new_item' => __( '添加新 Old-Post 标签' ),
			'new_item_name' => __( '新 Old-Post 标签名称' ),
			'separate_items_with_commas' => __( '用英文逗号分割多个 Old-Post 标签' ),
			'add_or_remove_items' => __( '添加/删除 Old-Post 标签' ),
			'choose_from_most_used' => __( '从常用 Old-Post 标签选择' ),
			'menu_name' => __( 'Old-Post 标签' ),
	);
	register_taxonomy('archives_tag', 'archives', array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'archives/tag', 'with_front' => false )
	));
	// flush_rewrite_rules();
}

//////// Custom Post Type: zSay ----------------  */

add_action( 'init', 'zfunc_create_post_type_share' );
function zfunc_create_post_type_share() {
	$labels = array(
		'name' => 'zSay',
		'singular_name' => 'zSay',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New say',
		'edit_item' => 'Edit say',
		'new_item' => 'New say',
		'all_items' => 'All say',
		'view_item' => 'View say',
		'search_items' => 'Search say',
		'not_found' =>  'No share found',
		'not_found_in_trash' => 'No say found in Trash', 
		'parent_item_colon' => '',
		'menu_name' => 'zSay'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'show_in_nav_menus' => false, 
		'query_var' => true,
		// 'rewrite' => false,
		'rewrite' => array('slug' => 'zsay', 'with_front' => false),
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => 5,
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		// 'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
	);
	register_post_type( 'zsay', $args);
	// flush_rewrite_rules();
}


/* Flush rewrite rules for custom post types. */
add_action( 'after_switch_theme', 'bt_flush_rewrite_rules' );
/* Flush your rewrite rules */
function bt_flush_rewrite_rules() {
  flush_rewrite_rules();
}


////  链接重定向
add_filter('post_type_link', 'zfunc_post_type_z_link', 999, 3);
function zfunc_post_type_z_link( $post_link, $post=0, $leavename=false ){
	// if ( $post->post_type == 'zsay' ){
	// 	return home_url( '/' . $post->ID . '.zsay' );
	// } else {
	// 	return $post_link;
	// }

	global $wp_rewrite;
	if ( $post->post_type == 'zsay' ){
		$permalink = $wp_rewrite->get_extra_permastruct( $post->post_type );
		$permalink = str_replace( 'zsay/%zsay%', $post->ID . '.zsay', $permalink );
		$permalink = home_url()."/".user_trailingslashit( $permalink );
		return $permalink;
	} else {
		return $post_link;
	}

}

add_action( 'init', 'zfunc_rewrites_init_post_type_z' );
function zfunc_rewrites_init_post_type_z(){
	add_rewrite_rule( '([0-9]+).zsay?$', 'index.php?post_type=zsay&p=$matches[1]', 'top' );
	add_rewrite_rule( '([0-9]+).zsay?/comment-page-([0-9]+)?', 'index.php?post_type=zsay&p=$matches[1]&cpage=$matches[2]', 'top' );
	// flush_rewrite_rules(); // use in debug
}


//// 新文章类型加入总文章列表
add_filter('pre_get_posts', 'zfunc_request' );
function zfunc_request( $query ) {
	if ( $query->is_main_query() ){
		if ( is_home() )
			$query->set('post_type', array( 'post', 'archives' ));
		if ( is_feed() || is_date() || is_author() )
			$query->set('post_type', array( 'post', 'archives', 'zsay' ));
	}
	return $query;
}
