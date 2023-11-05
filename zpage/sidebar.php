<aside id="sidebar">

<div class="sidebar">

	<div class="widget about">
		<h3>About</h3>
		<div>
			<div>本站长期承接广告，WordPress主题制作等付费任务。业务联系:<strong>zwwblog</strong>[at]<strong>gmail.com</strong></div>
			<?php zfunc_wp_cache( 'zfunc_zwwooooo_avatar', 'zwwooooo_wp_cache', get_avatar('zwwblog@gmail.com','36','','zwwooooo'), 0); ?>
		</div>
	</div>

	<div class="widget widget-rc">
		<h3>Recent Comments</h3>
		<ul>
			<?php zfunc_wp_cache( 'zfunc_rc_comments', 'zwwooooo_wp_cache', zfunc_rc_comments(5), 0); ?>
		</ul>

		<?php /*
		<script>
			(function ($, window, undefined) {
				$(function(){
					var home_url = "<?php echo home_url(); ?>";
					$.getJSON(
						home_url + "/wp-json/wp/v2/comments",
						{
							status: "approve",
							type: "comment"
						},
						function(rc_comments){
							console.log(rc_comments);
						}
					);
				});
			})(jQuery, window);
		</script>
		*/ ?>
	</div>

	<div class="widget widget-zads">
		<?php
		global $zpage_theme_options;
		$s_ad_img = $zpage_theme_options['sidebar_ad_area_img_ad'];
		$s_ad_l_text = $zpage_theme_options['sidebar_ad_area_long_text_ad'];
		$s_ad_l_text_home = $zpage_theme_options['sidebar_ad_area_long_text_ad_only_home'];
		
		if ($s_ad_img) { ?>
			<div class="zads-img"><?php echo $s_ad_img; ?></div>
		<?php } ?>

		<?php if ($s_ad_l_text || $s_ad_l_text_home) { ?>
			<div class="zads-text">
				<?php if ($s_ad_l_text) echo $s_ad_l_text; ?>
				<?php if (is_home()) echo $s_ad_l_text_home; ?>
			</div>
		<?php } ?>

	</div>

	<div class="widget widget-rup">
		<h3>Recently Updated Posts</h3>
		<ul>
			<?php zfunc_wp_cache( 'zfunc_recently_updated_posts', 'zwwooooo_wp_cache', zfunc_recently_updated_posts(5, 90), 0); ?>

			<?php /*
			<script>
				(function ($, window, undefined) {
					$(function(){
						var home_url = "<?php echo home_url(); ?>";
						$.getJSON(
							home_url + '/wp-json/wp/v2/posts',
							// {
							// 	filters: {
							// 		'post_type': ["post", 'archives'],
							// 		'post_status': "publish",
							// 		'orderby': 'modified',
							// 		'order': 'DESC',
							// 		'per_page': 99999
							// 	}
							// },
							{
								type: ['post','archives'],
								post_status: 'publish',
								orderby: 'modified',
								order: 'DESC',
								per_page: 999999
							},
							function(recently_updated_posts){
								console.log(recently_updated_posts);
								var rup_html = '';
								// var a=recently_updated_posts[0], today=new Date(), test=new Date('2015-12-15T21:26:20');
								// console.log( a.date_gmt+'///'+today+'///'+today.getTime()+'///'+test.getTime() );
								var num = 5, today=new Date(), days=90, j=0;;
								$.each( recently_updated_posts, function(i, post){
									var post_date_gmt = new Date(post.date_gmt);
									if ( today.getTime() - post_date_gmt.getTime() > 1000*60*60*24*days ) {
										j++;
										rup_html += '<li><a href="' + post.link + '" title="' + post.title.rendered + '">'
																+ zfunc_sub(post.title.rendered,36) + '</a><span class="updatetime"><br />&raquo; 修改时间: '
																+ post.modified + '</span></li>';
										if (j >= num) return false;
									}
								});
								// console.log(rup_html);
								$('.widget-rup ul').after('<ul>'+rup_html+'</ul>');
							}
						);

						var zfunc_sub=function(str,n){
							var r=/[^\x00-\xff]/g;
							if(str.replace(r,"mm").length<=n){return str;}
							var m=Math.floor(n/2);
							for(var i=m;i<str.length;i++){
								if(str.substr(0,i).replace(r,"mm").length>=n){
									return str.substr(0,i)+"...";
								}
							}
							return str;
						};

					});
				})(jQuery, window);
			</script>
			*/ ?>
		</ul>
	</div>

	<div class="widget">
		<h3>Blogroll</h3>
		<ul class="blogroll-1 cf">
		<?php
			/*
			592:   Blogroll
			600: Blogroll2
			499> 571: Home
			498 > 572: All
			570: page links
			581: long link name - Home
			582: long link name - All
			*/
			wp_list_bookmarks('title_li=&categorize=0&category=592&orderby=link_id');
			if (is_home()) wp_list_bookmarks('title_li=&categorize=0&category=571&orderby=link_id');
			wp_list_bookmarks('title_li=&categorize=0&category=572&orderby=link_id');
			if (is_home()) wp_list_bookmarks('title_li=&categorize=0&category=554&orderby=link_id');
		?>
		</ul>
		<ul class="blogroll-2">
			<?php
			if (is_home()) wp_list_bookmarks('title_li=&categorize=0&category=581&orderby=link_id');
			wp_list_bookmarks('title_li=&categorize=0&category=582&orderby=link_id');
			?>
		</ul>
	</div>

	<div class="widget">
		<h3>Most Views Posts</h3>
		<ul><?php zfunc_wp_cache( 'zfunc_most_views_posts', 'zwwooooo_wp_cache', zfunc_most_views_posts( 5, array('archives','post', 'zsay') ), 86400); ?></ul>
	</div>

	<?php if (is_single()) { ?>
		<div class="widget widget-mostactive">
			<h3>Most Active Friends</h3>
			<div><?php zfunc_wp_cache( 'zfunc_mostactive', 'zwwooooo_wp_cache', zfunc_mostactive(12), 0); ?></div>
		</div>
	<?php }	?>

	<div class="widget hot-tags">
		<h3>Hot Tags</h3>
		<div>
			<?php zfunc_wp_cache( 'zfunc_tag_cloud', 'zwwooooo_wp_cache', zfunc_tag_cloud(), 0); ?>
			<br /><a class="tc_view_more" href="<?php echo home_url('/tags'); ?>">View all tags &raquo;</a>
			</div>
	</div>

<?php //if ( !dynamic_sidebar('primary-widget-area') ) : ?>
<?php //endif; ?>

	<span id="respond-follow-start"></span>
</div>

</aside>
