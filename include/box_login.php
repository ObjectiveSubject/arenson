<?php 
global $login_redirect_url;
ob_start() ?>
	
	<div class="login_forms form_container clearfix <? echo $popup_method ?>"> 
	
		<div class="close_window_button"><a href="#" class="close_fancybox" rel="login_form"><span class="icon icon-ar_close"></span></a></div>
		
		<div id="ajax_signin" class="login_subbox">
				<h4 class="login_access">Login to Access Your Account</h4>
			<form action="<?php bloginfo('url'); ?>/wp-login.php" method="post" id="memberloginform" name="memberloginform" class="clearfix">				
				
				<label for="log" class="thecaption">
					Username<br />
				</label>
				<input type="text" value="" title="Username"  tabindex="1" class="member_email member_info clearMeFocus" id="log" name="log" />
				
				<br />
				
				<label for="pwd" class="thecaption">
					Password<br />
					<a class="lost-pwd" rel="lostpasswdform" href="#lostpasswdform" >Forgot your password?</a>
				</label>
				<input type="password"  tabindex="2" class="member_password member_info" id="pwd" name="pwd" />					
				
				<br />
				
				<label for="rememberme" class="rememberme thecaption">
					Remember me<br />
					<span class="explanation">Do not check if using a shared computer</span>
				</label>
				<input name="rememberme"  tabindex="3" id="rememberme" type="checkbox" checked="checked" value="forever" />
				
				<br /><br />
				
				<input type="hidden" name="redirect_to" id="login_redirect_url" value="<? echo $login_redirect_url ?>" />	
				<div class="login_buttons menu_horizontal">
					<ul>
						<li class="left_button register_button"><a href="<? echo get_bloginfo('url') ?>/newuser" class="aof_button" id="member_login_button" rel="">Register for an Account</a></li>
						<li class="right_button login_button"><input type="submit"  tabindex="4" value="Login" class="aof_button" /></li>
					</ul>		
					<div class="clearfix"></div>
				</div>		

			</form>

			<div id="lostpasswdform" class="action_alerts">
				<form method="post" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" id="lostpasswordform" name="lostpasswordform">
					<p class="clearfix">
						<label for="user_login">Please enter your username or e-mail, and we'll send you a link to reset your password.</label>
						<input type="text" tabindex="10" size="20" value="" class="member_info input" id="user_login" name="user_login">
					</p>
					<input type="hidden" value="" name="redirect_to">
					<p class="submit"><a href="#memberloginform" class="cancel-lost-pwd" rel="memberloginform">Cancel</a><?php do_action('login_form', 'resetpass'); ?><input type="submit" tabindex="100" value="Get New Password" class="aof_button gradient_blue" id="lostpass_submit" name="wp-submit"></p>
				</form>	
				<div id="lostpasswd_confirm" class="action_alerts">
					<p class="db_message">Thanks! We've just sent a link to your box. Please check your spam folder if you don't see it in the next 10 minutes.</p>
				</div>
			</div>
		</div>		
		
		
	</div>

	<? 
	$good_html = ob_get_clean();
?>