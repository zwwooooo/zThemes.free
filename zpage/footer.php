		<span class="pages-effect"><em></em></span>
	</div><!--#site-main-->

	<footer id="footer" class="wrapper footer">
		<div class="footer-copyright">
			Copyright 2009-<?php echo date('Y') ?> ZWWoOoOo,
			<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/" rel="nofollow">Creative Commons</a>,
			<a href="http://www.alexa.com/data/details/main?url=http://zww.me" rel="nofollow">alexa</a>,
			<a href="http://zww.me/sitemap.xml">Sitemap-Google</a>.
			<?php printf(__('%1$s powered by %2$s', 'zpage'), '<a href="http://zww.me" title="zPage Theme">zPage Theme</a>', '<a href="http://wordpress.org/">WordPress</a>'); ?>
			<br />Hosted on one of the these VPS:
			<a href="http://ramhost.us" rel="nofollow">RAM Host</a>
			or <a href="http://www.kvm.la" rel="nofollow">kvm.la</a>
			or <a href="http://my.hengtian.org/cart.php?gid=64" rel="nofollow">衡天主机</a>.
			<?php
			/* <!-- &nbsp;<?php echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds. --> */
			?>
		</div>

		<a href="#site-header" id="scroll" rel="nofollow">Back to Top</a>

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

	</footer>

</div><!--#container-->

<?php wp_footer(); ?>
</body>
</html>