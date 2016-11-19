	</div><!--#site-main-->

<?php
global $zsimple_theme_options;
if ( isset($zsimple_theme_options['page_loading']) && $zsimple_theme_options['page_loading'] ) {
?>
	<script>(function(b,a,c){b(function(){b(".progressbar i").css("width","90%");});})(jQuery,window);</script>
<?php } ?>

	<footer id="footer" class="footer">
		<div class="footer-copyright">
			<?php
			if ( isset($zsimple_theme_options['copyright']) && $zsimple_theme_options['copyright'] ) {
				echo $zsimple_theme_options['copyright'];
			} else {
			 echo 'Copyright &copy; ', date("Y"), ' ', get_bloginfo('name'), '.';
			} ?>

			<?php printf(__('由 %1$s 和 %2$s 驱动', 'zsimple'), '<a href="http://zww.me">zSimple</a>', '<a href="http://wordpress.org/">WordPress</a>'); ?>.
		</div>

		<span id="scroll" rel="nofollow"></span>

		<?php
		if ( isset($zsimple_theme_options['guess_comments']) && $zsimple_theme_options['guess_comments'] ) {
		?>
			<div id="guest_comments" class="guest_comments">
				<div class="guest_info">
					<?php
					$user = wp_get_current_user();
					if ($user->exists()) {
						echo '<span>您好, </span><strong>'. $user->user_login .', </strong><a id="guest_comments_click" href="#" class="'. $user->user_email .'" rel="nofollow"><span>点击这里可以查看</span>您最近的评论</a>';
					} else {
						if($_COOKIE["comment_author_" . COOKIEHASH]!=""){
							echo '<span>您好, </span><strong>' , $_COOKIE["comment_author_" . COOKIEHASH] , ', </strong><a id="guest_comments_click" href="#" class="'. $_COOKIE["comment_author_email_" . COOKIEHASH] .'" rel="nofollow"><span>点击这里可以查看</span>您最近的评论</a>';
						} else {
							echo 'Welcome!<span> o(∩_∩)o</span>';
						}
					} ?>
				</div>
				<div id="guest_comments_list"></div>
				<a href="#" id="gc_close" rel="nofollow">X</a>
			</div>
		<?php } ?>

		<span class="mobile-menu-list-cover"></span>
		<div class="mobile-menu-list tr-4s">
			<div class="search-form-mobile">
				<div class="search-form">
					<?php get_search_form(); ?>
				</div>
			</div>
			<ul>
				<?php wp_nav_menu( array( 'theme_location' => 'zsimple_primary', 'fallback_cb' => 'zsimple_wp_list_pages', 'container' => 'false', 'items_wrap' => '%3$s' ) ); ?>
			</ul>
			<span id="mml-close">X</span>
		</div>

	</footer>

</div><!--#container-->

<?php wp_footer(); ?>

<?php
if ( isset($zsimple_theme_options['page_loading']) && $zsimple_theme_options['page_loading'] ) {
?>
	<script>(function(d,e,f){d(function(){d(".progressbar i").css("width","95%");});})(jQuery,window);</script>
<?php } ?>

</body>
</html>