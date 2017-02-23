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
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo ZOO_THEME_URI; ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<?php
	global $zsimple_theme_options;
	if ( isset($zsimple_theme_options['custom_style']) && $zsimple_theme_options['custom_style'] ) {
		echo "<style>\n" . $zsimple_theme_options['custom_style'] . "\n</style>\n";
	}
	?>
</head>
<?php
$body_classes = '';
if ( isset($zsimple_theme_options['chong_jiong']) && $zsimple_theme_options['chong_jiong'] ) {
	$body_classes .= ' jiong';
}
if ( isset($zsimple_theme_options['disable_before_title_tag']) && $zsimple_theme_options['disable_before_title_tag'] ) {
	$body_classes .= ' dbtt';
}

if ( is_user_logged_in() && isset($zsimple_theme_options['custom_admin_tools']) && $zsimple_theme_options['custom_admin_tools'] ) {
	$body_classes .= ' custom-admin-bar';
}
?>
<body <?php body_class($body_classes); ?>>

<div id="container" class="site">

	<header id="site-header" class="site-header">
		<div class="wrapper header-main cf">

			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<?php if ( isset($zsimple_theme_options['logo']) && $zsimple_theme_options['logo'] ) { ?>
					<img src="<?php echo $zsimple_theme_options['logo']; ?>" alt="<?php bloginfo('name'); ?>">
				<?php } else { ?>
					<?php bloginfo('name'); ?>
				<?php } ?>
				</a>
			</h1>

			<div class="search-form">
				<?php get_search_form(); ?>
			</div>
			
			<nav id="site-navi" class="site-navi cf">
				<ul class="site-navi-ul-pc">
					<?php wp_nav_menu( array( 'theme_location' => 'zsimple_primary', 'fallback_cb' => 'zsimple_wp_list_pages', 'container' => 'false', 'items_wrap' => '%3$s' ) ); ?>
				</ul>

				<div id="rss">
					<?php
					$social1_name = 'Twitter';
					$social1_link = '#';
					if ( isset($zsimple_theme_options['social1_name']) && $zsimple_theme_options['social1_name'] ) {
						$social1_name = $zsimple_theme_options['social1_name'];
						$social1_link = $zsimple_theme_options['social1_link'];
					}
					$social2_name = 'Google+';
					$social2_link = '#';
					if ( isset($zsimple_theme_options['social2_name']) && $zsimple_theme_options['social2_name'] ) {
						$social2_name = $zsimple_theme_options['social2_name'];
						$social2_link = $zsimple_theme_options['social2_link'];
					}
					$rss_name = 'RSS';
					$rss_link = get_bloginfo('rss2_url');
					if ( isset($zsimple_theme_options['rss_name']) && $zsimple_theme_options['rss_name'] ) {
						$rss_name = $zsimple_theme_options['rss_name'];
						$rss_link = $zsimple_theme_options['rss_link'];
					}
					?>
					<?php if ($social1_name != -1) { ?>
						<a class="twitter tr-4s" href="<?php echo $social1_link; ?>" title="<?php echo $social1_name; ?>"><?php echo $social1_name; ?></a>
					<?php } ?>
					<?php if ($social2_name != -1) { ?>
						<a class="googleplus tr-4s" href="<?php echo $social2_link; ?>" title="<?php echo $social2_name; ?>" rel="publisher"><?php echo $social2_name; ?></a>
					<?php } ?>
					<?php if ($rss_name != -1) { ?>
						<a class="feed tr-4s" href="<?php echo $rss_link; ?>" title="<?php echo $rss_name; ?>"><?php echo $rss_name; ?></a>
					<?php } ?>
				</div>
			</nav>
			<span id="site-navi-mobile"></span>

		</div>

		<span class="progressbar"><i class="s600"></i></span>

		<?php
		if (isset($zsimple_theme_options['announcement']) && $zsimple_theme_options['announcement'] ) {
		?>
			<div class="announcement"><strong>[公告]</strong> <?php echo $zsimple_theme_options['announcement']; ?></div>
		<?php } ?>

	</header>

	<div id="site-main" class="wrapper site-main cols">

<?php
if ( isset($zsimple_theme_options['page_loading']) && $zsimple_theme_options['page_loading'] ) {
?>
	<script>(function(b,a,c){b(function(){b(".progressbar i").css("width","20%");});})(jQuery,window);</script>
<?php } ?>
