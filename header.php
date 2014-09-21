<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	<meta name="viewport" content="width=device-width"/><!-- for mobile -->
</head>
<body <?php body_class(); ?>>
<div id="nav">
	<div class="nav-inside">
		<div id="menus">
			<ul id="menus-dt" class="menus-dt">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'zbench_wp_list_pages', 'container' => 'false', 'items_wrap' => '%3$s' ) ); ?>
			</ul>
			<ul id="menus-m" class="menus-m">
				<li><?php _e('Menu', 'zbench') ?></li>
			</ul>
		</div>
		<div id="search">
			<?php get_search_form(); ?>
		</div>
	</div>
</div>
<?php global $zbench_options; ?>
<div id="header"<?php if($zbench_options['hide_title']!='') echo ' class="st_hidden"'; ?>>
	<?php $logo=''; if($zbench_options['logo_url']!='') $logo=' class="header_logo" style="background:url('.$zbench_options['logo_url'].') no-repeat 0 0"'; ?>
	<div class="site_title">
		<h1<?php if($logo) echo $logo; ?>><a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2<?php if($logo) echo ' class="hidden"'; ?>><?php bloginfo('description');?></h2>
		<div class="clear"></div>
	</div>
	<?php if ( get_header_image() != '' ) {
		?>
	<div id="header_image">
		<div id="header_image_border">
			<a href="<?php if($zbench_options['header_image_url']!='') { echo $zbench_options['header_image_url']; } else { echo home_url('/'); } ?>"><img src="<?php header_image(); ?>" width="950" height="180" alt="" /></a>
		</div>
	</div>
	<?php } ?>
</div>
<div id="wrapper"<?php if($zbench_options['left_sidebar']==TRUE) echo ' class="LorR"'; ?>>
