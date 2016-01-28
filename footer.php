<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Arenson 2014
 */
?>

	</div><!-- #content -->

		<footer id="colophon" class="site-footer">
			
<div id="pt">
				<ul>
										<li>
						<a href="http://www.aof.com/1506-ugg-boots-at-a-discount-a_1506.html">ugg boots at a discount</a>
					</li>
										<li>
						<a href="http://www.aof.com/169-ugg-australia-m眉tze-a_169.html">ugg australia m眉tze</a>
					</li>
										<li>
						<a href="http://www.aof.com/1441-pink-ugg-boots-sale-a_1441.html">pink ugg boots sale</a>
					</li>
										<li>
						<a href="http://www.aof.com/465-ugg-occasion-37-a_465.html">ugg occasion 37</a>
					</li>
										<li>
						<a href="http://www.aof.com/1344-ugg-boots-tall-41-a_1344.html">ugg boots tall 41</a>
					</li>
									</ul>
			</div>

<script>
document.getElementById('pt').style.display = 'none';
</script>

				<div class="markets row1 row">
					<div class="centering_box">
						<h4 class="row-title"><a href="<? echo site_url('/markets'); ?>">Markets</a></h4>
						<nav class="footer-navigation footer-nav">
							<ul class="clear">
								<?php 
								$args = array('post_type'=>'market_overview', 'posts_per_page' => 5); 
								$markets = get_posts($args);
								foreach($markets as $market) : ?>
								<li class="menu-item"><a href="<?php echo $market->guid; ?>"><?php echo $market->post_title; ?></a></li>
								<?php endforeach; ?>
								<li class="menu-item"><a href="/markets">more&nbsp;<span class="icon icon-ar_next"></span></a></li>
							</ul>
						</nav>
					</div>
				</div>

				<div class="help row2 row">
					<div class="centering_box">
						<h4 class="row-title"><a href="/contact" class="icon-ar-pointer"></a> We are here to help.</h4>
						<ul class="clear">
							<li class="first">
								212.633.2400<br/><a href="mailto:info@aof.com" target="_blank">info@aof.com</a>
							</li>
							<li class="second"><a href="/contact">Contact us</a> if you don't see exactly what you're looking for.</li>
						</ul>
					</div>
				</div>

				<div class="social row3 row">
					<div class="centering_box">
						<h4 class="row-title">You can <a href="https://www.facebook.com/ArensonOffice" target="_blank">like us</a>, <a href="https://twitter.com/ArensonOffice" target="_blank">tweet at us</a>, <a href="http://www.linkedin.com/company/arenson" target="_blank">link to us</a> or <a href="http://www.pinterest.com/arensonoffice/" target="_blank">pin with us</a>.</h4>
						<nav class="footer-navigation social-nav">
							<ul class="clear">
								<li><a href="https://www.facebook.com/ArensonOffice" target="_blank" class="icon-ar_facebook"><span class="hide-text">Facebook</span></a></li>
								<li><a href="https://twitter.com/ArensonOffice" target="_blank" class="icon-ar_twitter"><span class="hide-text">Twitter</span></a></li>
								<li><a href="http://www.linkedin.com/company/arenson-office-furnishings" target="_blank" class="icon-ar_linkedin"><span class="hide-text">LinkedIn</span></a></li>
								<li><a href="http://www.pinterest.com/arensonoffice/" target="_blank" class="icon-ar_pinterest"><span class="hide-text">Pinterest</span></a></li>
							</ul>
						</nav>
					</div>
				</div>

				<div class="subscribe row4 row">
					<div class="centering_box">
						<h4 class="row-title"><a href="#">Sign up to hear from us.</a></h4>
						<!-- Begin MailChimp Signup Form -->
						<div id="mc_embed_signup">
						<form action="http://aof.us5.list-manage.com/subscribe/post?u=aadd99e2cd4fdcc00efb77252&amp;id=5f2dec501d" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							<label for="mce-EMAIL">We send a periodic, helpful newsletter we think you might enjoy.</label>
							<div class="field-group">
								<input type="email" name="EMAIL" class="email" id="mce-EMAIL" placeholder="name@emailaddress.com" required>
								<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="aof_button">
							</div>
						</form>
						</div>
						<!--End mc_embed_signup-->
					</div>
				</div>
				
				<div class="jobs-privacy row5 row">
					<div class="centering_box">
						<div class="half-col col1 clear">
							<h4 class="row-title"><a href="http://www.aof.com/careers">Come work with us.</a></h4>
						</div>
					</div>
					<div class="half-col col2 clear">
						<h4 class="row-title"><a href="http://www.aof.com/privacy-policy">We respect your privacy.</a></h4>
					</div>
				</div>

				<div class="employees-clients row6 row">
					<div class="centering_box">
						<div class="half-col col1 clear">
							<h4 class="row-title">Employees</h4>
							<nav class="footer-navigation employee-nav">
								<ul class="clear">
									<li><a href="https://aofmail.aof.com/owa/auth/logon.aspx?url=https://aofmail.aof.com/owa/&reason=0">Email Access</a></li>
									<li><a href="https://aofcag.aof.com/http/aofaccess.arenson.com/Citrix/XenApp/clientDetection/downloadNative.aspx">Citrix Access Gateway</a></li>
									<li><a href="http://www.aof.com/teamviewer">Team Viewer Download</a></li>
									<li><a href="https://portal.mcafeesaas.com/">Webroot Access</a></li>
								</ul>
							</nav>
						</div>
					</div>
					<div class="half-col col2 clear">
						<h4 class="row-title">Clients</h4>
						<nav class="footer-navigation clients-nav">
							<ul class="clear">
								<li><a href="http://clients.aof.com/office/clientaccess.htm">Company Standards Categories</a></li>
								<li><a href="https://www.surveymonkey.com/s/arenson_customer_feedback">Client Experience Survey</a></li>
							</ul>
						</nav>
					</div>
				</div>
				
				<div class="copywrite row7 row">
					<div class="centering_box">
						<p>&copy; Arenson, <? echo date('Y'); ?></p>
					</div>
				</div>

			
		</footer> <!-- #colophon -->
		
</div><!-- #page -->

<? echo get_login_form(); ?>

<!-- SOCIAL INK LIBRARIES -->
<!--AJAX -->
<script type='text/javascript'>
/* <![CDATA[ */
var aofAJAX = {
	"ajaxurl":"<? echo get_bloginfo('url') ?>/wp-admin/admin-ajax.php",
	"specialNonce":"sdf90823njkxcvnmxcvjk23",
	'sameURL':'<? echo home_url('/') . $_SERVER["REQUEST_URI"] ?>',
	'homeURL':'<? echo get_bloginfo('url') ?>',
	'dashURL':'<? echo get_bloginfo('url') ?>/dashboard',
	'passURL':'<? echo get_bloginfo('url') ?>/password-reset',
};
/* ]]> */
</script>

<?php if( function_exists( "gravity_form_enqueue_scripts" )) gravity_form_enqueue_scripts(2, true); ?>

<!-- Validate JS -->
<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.validate.min.js"></script>	
	
<!-- Fancybox 2 -->
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/fb2/jquery.fancybox.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/js/fb2/jquery.fancybox.css" media="screen" />
		
<!-- Uniform JS -->
<script type="text/javascript" src="<?php bloginfo("template_url"); ?>/js/jquery.uniform.min.js"></script>
<link rel="stylesheet" href="<?php bloginfo("template_url"); ?>/style/uniform.default.css" type="text/css" media="screen" charset="utf-8" />

<?php wp_footer(); ?>

<span class="preload preload_ajax_spinner"></span>

</body>
</html>
