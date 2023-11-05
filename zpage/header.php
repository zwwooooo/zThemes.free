<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php //language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php //language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php //language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php /*
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	*/ ?>
	<!--[if lt IE 9]>
	<script src="<?php echo ZOO_THEME_URI; ?>/js/html5.js"></script>
	<![endif]-->

	<?php
	//comment page seo
	if( is_singular() ) {
		if( function_exists('get_query_var') ) {
			$cpage = intval(get_query_var('cpage'));
			$commentPage = intval(get_query_var('comment-page'));
		}
		if( !empty($cpage) || !empty($commentPage) ) {
			echo '<meta name="robots" content="noindex, nofollow" />';
			echo "\n";
		}
	}
	?>
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="container" class="site">

	<header id="site-header" class="site-header">
		<div class="wrapper header-main cf">

			<div class="header-left">
				<h1 class="site-title">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a>
				</h1>
				<div class="site-desc"><?php bloginfo('description'); ?></div>
			</div>

			<div class="header-right">
				<nav id="site-navi" class="site-navi cf">
					<ul class="site-navi-ul-pc">
						<?php wp_nav_menu( array( 'theme_location' => 'zpage_primary', 'fallback_cb' => 'zpage_wp_list_pages', 'container' => 'false', 'items_wrap' => '%3$s' ) ); ?>
					</ul>
					<span id="site-navi-mobile"></span>
				</nav>
				<div id="info-area" class="info-area cf">
					<?php
					$args = array(
						'post_type' => 'zsay',
						'posts_per_page' => 3
					);
					zfunc_wp_cache( 'zfunc_zsay_posts_info_area', 'zwwooooo_wp_cache', zfunc_WP_Query($args, 'zsay-info-area') );
					?>
				</div>
			</div>

			<div id="search">
				<?php get_search_form(); ?>
			</div>
			
			<div id="rss">
				<a class="feedburner" href="http://feeds2.feedburner.com/zwwooooo" title="FeedBurner">RSS1</a>
				<a class="feed" href="http://feed.zww.me" title="RSS Feed">RSS2</a>
				<a class="twitter" href="https://twitter.com/zwwooooo" title="Follow me!">Twitter</a>
				<a class="googleplus" href="https://plus.google.com/111156613658126773405" title="Circle me!" rel="publisher">Google+</a>
			</div>

		</div>

	</header>

	<div id="site-main" class="wrapper site-main cf">
