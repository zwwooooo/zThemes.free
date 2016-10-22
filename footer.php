	</div><!--#site-main-->

	<script>(function(b,a,c){b(function(){b(".progressbar i").css("width","90%");});})(jQuery,window);</script>

	<footer id="footer" class="footer">
		<div class="footer-copyright">
			<?php _e('Copyright', 'zsimple'); ?> &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>.
			<?php printf(__('Powered by %1$s and %2$s', 'zsimple'), '<a href="http://zww.me">zSimple</a>', '<a href="http://wordpress.org/">WordPress</a>'); ?>.
		</div>

		<span id="scroll" rel="nofollow"></span>

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

<script>(function(d,e,f){d(function(){d(".progressbar i").css("width","95%");});})(jQuery,window);</script>

</body>
</html>