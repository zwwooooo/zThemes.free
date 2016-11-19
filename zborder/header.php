<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width"/><!-- for mobile -->
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php global $zborder_theme_options; ?>
<div id="header">
	<div class="navi_and_search">
		<div class="navi_and_search_inner">
			<div id="navi">
				<ul class="navi_dt">
					<li><a class="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php _e('Home', 'zborder'); ?></a></li>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'zborder_wp_list_pages', 'container' => 'false', 'items_wrap' => '%3$s' ) ); ?>
				</ul>
				<ul class="navi_mobile">
					<li><?php _e('Menu', 'zborder') ?></li>
				</ul>
			</div>
			<div id="search">
				<?php get_search_form(); ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>

	<div class="title_and_rss">
		<div class="title_and_rss_inner">
			<?php
			$logo='';
			if($zborder_theme_options['logo_url']!='')
				$logo=' class="header_logo" style="background:url('.$zborder_theme_options['logo_url'].') no-repeat center center"';
			?>
			<h1 class="site_title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo $logo; ?> rel="home"><?php bloginfo('name'); ?></a>
			</h1>
			<h2 class="site_desc"><?php bloginfo('description');?></h2>
			<div id="rss">
				<?php
				global $zborder_theme_options;

				$rss_url = get_bloginfo('rss2_url');
				if ($zborder_theme_options['rss_url'] != '') $rss_url = esc_url( $zborder_theme_options['rss_url'] );

				$twitter_name = 'Follow me!';
				$twitter_icon = '';
				$twitter_url = '';
				if ($zborder_theme_options['twitter_url'] != '') $twitter_url = esc_url( $zborder_theme_options['twitter_url'] );
				if ($zborder_theme_options['twitter_custom_name'] != '') esc_attr( $twitter_name = $zborder_theme_options['twitter_custom_name'] );
				if ($zborder_theme_options['twitter_custom_icon'] != '') $twitter_icon = 'style="background:url(' . esc_url( $zborder_theme_options['twitter_custom_icon'] ) . ') no-repeat center center;"';
				if ($zborder_theme_options['twitter_custom_url'] != '') $twitter_url = esc_url( $zborder_theme_options['twitter_custom_url'] );

				$facebook_name = 'Facebook';
				$facebook_icon = '';
				$facebook_url = '';
				if ($zborder_theme_options['facebook_url'] != '') $facebook_url = esc_url( $zborder_theme_options['facebook_url'] );
				if ($zborder_theme_options['facebook_custom_name'] != '') $facebook_name = esc_attr( $zborder_theme_options['facebook_custom_name'] );
				if ($zborder_theme_options['facebook_custom_icon'] != '') $facebook_icon = 'style="background:url(' . esc_url( $zborder_theme_options['facebook_custom_icon'] ) . ') no-repeat center center;"';
				if ($zborder_theme_options['facebook_custom_url'] != '') $facebook_url = esc_url( $zborder_theme_options['facebook_custom_url'] );

				$googleplus_name = 'Google+';
				$googleplus_icon = '';
				$googleplus_url = '';
				if ($zborder_theme_options['googleplus_url'] != '') $googleplus_url = esc_url( $zborder_theme_options['googleplus_url'] );
				if ($zborder_theme_options['googleplus_custom_name'] != '') $googleplus_name = esc_attr( $zborder_theme_options['googleplus_custom_name'] );
				if ($zborder_theme_options['googleplus_custom_icon'] != '') $googleplus_icon = 'style="background:url(' . esc_url( $zborder_theme_options['googleplus_custom_icon'] ) . ') no-repeat center center;"';
				if ($zborder_theme_options['googleplus_custom_url'] != '') $googleplus_url = esc_url( $zborder_theme_options['googleplus_custom_url'] );
				?>

				<a class="feed" href="<?php echo $rss_url; ?>" rel="bookmark" title="<?php _e('RSS Feed', 'zborder'); ?>"><span><?php _e('RSS Feed', 'zborder'); ?></span></a>

				<?php if ($twitter_url != '') { ?>
					<a <?php echo $twitter_icon; ?> class="twitter" href="<?php echo $twitter_url; ?>" rel="author" title="<?php echo $twitter_name; ?>"><span><?php echo $twitter_name; ?></span></a>
				<?php } ?>

				<?php if ($facebook_url != '') { ?>
					<a <?php echo $facebook_icon; ?> class="facebook" href="<?php echo $facebook_url; ?>" rel="author" title="<?php echo $facebook_name; ?>"><span><?php echo $facebook_name; ?></span></a>
				<?php } ?>

				<?php if ($googleplus_url != '') { ?>
					<a <?php echo $googleplus_icon; ?> class="googleplus" href="<?php echo $googleplus_url; ?>" rel="publisher" title="<?php echo $googleplus_name; ?>"><span><?php echo $googleplus_name; ?></span></a>
				<?php } ?>

				<em class="rss_text">RSS</em>
			</div>
			<div class="clear"></div>
		</div>
	</div>

</div>

<div id="wrapper">
	<div class="wrapper_inner">
		<?php if ( get_header_image() != '' ) { ?>
			<div id="header_image">
				<a href="<?php if( $zborder_theme_options['header_image_url']!='' ) { echo esc_url( $zborder_theme_options['header_image_url'] ); } else { echo esc_url( home_url('/') ); } ?>"><img src="<?php header_image(); ?>" width="970" height="200" alt="" /></a>
			</div>
		<?php } ?>

