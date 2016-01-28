<?php
if(isset($_GET["action"])&&$_GET["action"]=='rp') {
	$passRequest=sanitize_user_inputs($_GET["rp"]);
	$reset_key=sanitize_user_inputs($_GET["key"]);
	$user_login=sanitize_user_inputs($_GET["login"]);

}

else {
	wp_redirect(get_bloginfo('url'));
	exit;				
		}


get_header(); ?>

		<div id="primary" class="site-content page-password-reset">
			
			<header class="page-header yellow">
				<div class="centering_box">
					<h1 class="page-title">Reset your Password</h1>
				</div>
			</header><!-- .page-header -->
			
			<div id="content" class="page centering_box" role="main"> 
				
				<div class="entry-content">
					<? the_content() ?>
					
					<div class="reset_member_pass">
						<h3>Enter a new Password</h3>
	
							<h6>Looks like you arrived safely from the email we sent.  Please enter your new desired password below and we'll get you reset in no time.</h6>
							
							<form method="post" action="<? echo get_bloginfo('url') ?>/wp-login.php?action=resetpass&amp;key=<? echo $reset_key ?>&amp;login=<? echo $user_login ?>" id="newMemberPassCreate" name="resetpassform">
								<input type="hidden" value="<? echo $user_login ?>" id="user_login">
								<input type="hidden" value="<? echo $reset_key ?>" id="reset_key">
								<p class="description indicator-hint"><strong>Hint:</strong> The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>
								<p>
									<label for="pass1">New password</label>
									<input type="password" value="" size="20" class="member_info input" id="pass1" name="pass1">
								</p>
								<p>
									<label for="pass2">Confirm new password</label>
									<input type="password" value="" size="20" class="member_info input" id="pass2" name="pass2">
								</p>
								<p class="submit"><input type="submit" tabindex="100" value="Reset Password" class="aof_button" id="resetpass_submit" name="wp-submit"></p>
							</form>
							<div id="passReset_confirm" class="fb_results">
								<p class="db_message"></p>
							</div>	
	
					</div>	
				</div>

			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?> 