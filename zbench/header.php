<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="nav">
	<div id="menus">
		<ul><li<?php if (is_home() || is_front_page()) echo ' class="current_page_item"'; ?>><a href="<?php echo home_url('/'); ?>"><?php _e('Home', 'zbench'); ?></a></li></ul>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'zbench_wp_list_pages', 'container' => 'false', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>' ) ); ?>
	</div>
	<div id="search">
		<?php get_search_form(); ?>
	</div>
</div>
<?php global $zbench_options; ?>
<div id="wrapper"<?php if($zbench_options['left_sidebar']==TRUE) echo ' class="LorR"'; ?>>
	<div id="header"><?php $logo=''; if($zbench_options['logo_url']!='') $logo=' class="header_logo" style="background:url('.$zbench_options['logo_url'].') no-repeat 0 0"'; ?>
		<h1<?php if($zbench_options['hide_title']!='') echo ' class="hidden"'; ?>><a href="<?php echo home_url('/'); ?>"<?php if($logo) echo $logo; ?>><?php bloginfo('name'); ?></a></h1>
		<h2<?php if($logo || $zbench_options['hide_title']!='') echo ' class="hidden"'; ?>><?php bloginfo('description');?></h2>
		<div class="clear"></div>
		<?php if ( get_header_image() != '' ) {
			?>
		<div id="header_image">
			<div id="header_image_border">
				<a href="<?php if($zbench_options['header_image_url']!='') { echo $zbench_options['header_image_url']; } else { echo home_url('/'); } ?>"><img src="<?php header_image(); ?>" width="950" height="180" alt="" /></a>
			</div>
		</div>
		<?php } ?>
	</div>
