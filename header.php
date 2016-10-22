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
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo ZOO_THEME_URI; ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php global $zsimple_theme_options; ?>

<div id="container" class="site">

	<header id="site-header" class="site-header">
		<div class="wrapper header-main cf">

			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a>
			</h1>

			<div class="search-form">
				<?php get_search_form(); ?>
			</div>
			
			<nav id="site-navi" class="site-navi cf">
				<ul class="site-navi-ul-pc">
					<?php wp_nav_menu( array( 'theme_location' => 'zsimple_primary', 'fallback_cb' => 'zsimple_wp_list_pages', 'container' => 'false', 'items_wrap' => '%3$s' ) ); ?>
				</ul>

				<div id="rss">
					<a class="twitter tr-4s" href="https://twitter.com/zwwooooo" title="Follow me!">Twitter</a>
					<a class="googleplus tr-4s" href="https://plus.google.com/111156613658126773405" title="Circle me!" rel="publisher">Google+</a>
					<a class="feed tr-4s" href="http://feed.zww.me" title="RSS Feed">RSS</a>
				</div>
			</nav>
			<span id="site-navi-mobile"></span>

		</div>

		<span class="progressbar"><i></i></span>
	</header>

	<div id="site-main" class="wrapper site-main cols">

	<script>(function(b,a,c){b(function(){b(".progressbar i").css("width","20%");});})(jQuery,window);</script>
