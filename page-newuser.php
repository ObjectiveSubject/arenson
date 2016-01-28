<?php
if(member_logged_in()) {
	wp_redirect(get_bloginfo('url')); 
	exit;		
}

get_header();

$prelim_msg = 'We specialize in helping organizations of all sizes fulfill their project needs.';
$create_binder_msg = 'Create unlimited Project Binders to keep your products and information organized by registering for an account.';
$create_fave_msg =	'Start keeping track of your favorite Arenson products by registering for an account.';

$binder_access_msg = 'You are trying to access a protected binder.  Please log in and we\'ll send you on your way!';
$fave = 			'Before you can add products to your Favorites, please register for an account.';
$add = 				'Before you can add an item to a binder, you need to log into your account.';
$req_quote =		'Before you can Request a Quote, you need to login to your account.';


if(isset($_GET["binder_refer"])) {
	$prelim_msg = $binder_access_msg;
	$login_redirect_url = home_url('binder') . '?b=' . sanitize_user_inputs($_GET["binder_refer"]);
	}
	
elseif(isset($_GET["msg"])) {
	$msg = sanitize_user_inputs($_GET["msg"]);
	$redir = sanitize_user_inputs($_GET["pd"]);
	$prelim_msg = $$msg;
	$login_redirect_url = ($redir!="") ? get_permalink($redir) : $_SERVER['HTTP_REFERER'];
	}

elseif(isset($_GET["ac"])) 
	$prelim_msg =($_GET["ac"]=='cb') ? $create_binder_msg : $create_fave_msg;
	
if(!$login_redirect_url)	
	$login_redirect_url = $_SERVER['HTTP_REFERER'];

 ?>

		<div id="primary" class="site-content page-newuser page-login">
		
			<header class="page-header yellow">
				<div class="centering_box">
					<h1 class="page-title">Get Started</h1>
				</div>
			</header><!-- .page-header -->
			

			<div id="content class" class="page centering_box" role="main">
			
				<div class="login_column login_column_fatleft" id="login_column_createacct">
					<div id="aof_createaccount" class="login_subbox">
						<h4 class="column-title">Register for your own Arenson Account</h4>
						<? if($prelim_msg) { ?>
							<div class="prelim_msg">
								<h6><? echo $prelim_msg ?></h6>
							</div>
						<? } ?>
					
						<form action="<?php bloginfo('siteurl'); ?>" method="post" id="aof_createaccount_form" name="aof_createaccount_form" >				
						
							<div class="acct_inputs clearfix">
								<label for="member_username" class="thecaption"><span class="required_field_marker">*</span>Username</label>
								<input type="text" value="" title="Please enter a valid username" class="required member_name member_info" id="member_username" name="member_username" />			
								<label id="username_taken_label">Sorry, that username is taken, please choose another.</label>
								<br />
								
								<label for="pwd" class="thecaption"><span class="required_field_marker">*</span>Password</br><span class="explanation">7 characters or more, a mix of numbers and letters.</span></label>
								<td class="thefield"><input type="password" class="member_password member_info" id="member_password" name="member_password" />								
								<br />
								
								<label for="pwd2" class="thecaption"><span class="required_field_marker">*</span>Confirm Password</br></label>
								<input type="password" class="member_password member_info" id="member_password_confirm" name="member_password_confirm" />				
								<br />
								
								<label for="member_email" class="thecaption"><span class="required_field_marker">*</span>Email</label>
								<input type="text" value="" title="Please enter a valid email" class="email required member_email member_info" id="member_email" name="member_email" />
								<label id="email_taken_label"  class="explanation">There is already an account registered with that email.</label>
								<br />				
								
								<label for="member_firstname" class="thecaption"><span class="required_field_marker">*</span>First Name</label>
								<input type="text" value="" title="Please Enter a First Name" class="clearMeFocus required member_info" id="member_firstname" name="member_firstname" />
								<br />				
								
								<label for="member_lastname" class="thecaption"><span class="required_field_marker">*</span>Last Name</label>
								<input type="text" value="" title="Please Enter a Last Name" class="clearMeFocus required member_info" id="member_lastname" name="member_lastname" />
								<br />				
								
								<label for="member_company" class="thecaption"><span class="required_field_marker">*</span>Company</label>
								<input type="text" value="" title="Please enter a Company" class="required clearMeFocus required member_info" id="member_company" name="member_company" />
								<br />								
								
								<label for="member_phone" class="thecaption">Phone</label>
								<input type="text" value="" title="Phone" class="clearMeFocus required member_info" id="member_phone" name="member_phone" />
								<br />
							


								<? global $userReg_AddressFields;
									foreach($userReg_AddressFields as $field_caption => $field_code) { ?>
										<label for="<? echo $field_code ?>" class="thecaption"><? echo $field_caption ?></label>
										<input type="text" value="" title="<? echo $field_caption ?>" class="clearMeFocus member_info" id="<? echo $field_code ?>" name="<? echo $field_code ?>" />
										<br />
								<? } ?>
								
								<label for="member_iAMA" class="thecaption"><span class="required_field_marker">*</span>I am A(n)</label>
								<? global $member_iAMA; ?>
								
								<select name="member_iAMA" id="member_iAMA" class="required aof_select">
									<option value="newb">Choose An Option</option>
									<? foreach($member_iAMA as $oneIAMA) { ?>
										<option value="<? echo $oneIAMA?>"><? echo $oneIAMA ?></option>
									<? } ?>						
								</select>
								<br />				

								
								<label for="member_newsletterconfirm" class="thecaption" onclick="">Subscribe to our newsletter?</br></label>
								<input type="checkbox" class="member_info" id="member_newsletterconfirm" name="member_newsletterconfirm" checked="checked"/>				
								<br />
								
								<label for="spam_quiz" class="thecaption">
									To prevent SPAM, please type the characters shown below:<br/>
									<img src="<?php echo get_template_directory_uri(); ?>/images/spamimage.png" alt="spamimage" width="150" height="41" />
								</label>
								<input type="text" value="" class="member_info" id="spam_quiz" name="spam_quiz" />				
								<br />
								
							</div>
							
							<div id="newmember_confirm" class="action_alerts">
								<div class="db_message">					
									<h3>Sorry</h3> 
									<p>We found some validation errors. Please scroll up and fix the appropriate fields.</p>
									
								</div>
							</div>						
							
							<input type="hidden" name="email" value="" id="user_email"/>
							<input type="hidden" name="message" value="" id="user_message"/>

							<input type="submit" value="Create Account" id="signup_user" class="aof_button gradient_blue round_module" />
							<input type="hidden" name="redirect_to" id="login_redirect_url" value="<? echo $login_redirect_url ?>" />
							<input type="hidden" value="true" name="new_member" />		

						</form>

					</div><!-- #aof_createaccount -->
				</div><!-- #login_column_createacct -->

				
				<div class="login_column login_column_right" id="login_column_login">
					<h4 class="column-title">Already a Member?</h4>
					
					<div id="aof_login_standalone" class="sidebar_style">	
						<h6 class="newuserlogin <? if($prelim_msg) { echo $prelim_msg; } ?>">Login now</h6>
						<? include('include/aof_box_login.php');
							echo $good_html;?>
							
						<div id="fb_loading" class="fb_loading fb_temporaries action_alerts"></div>
						<div id="fb_results" class="fb_results fb_temporaries action_alerts"><h3></h3><p class="db_message"></p></div>
						
					</div>
				
				</div><!-- #login_column_login -->
				
				<div class="clearfix"></div>
				
			</div><!-- #content -->
		</div><!-- #primary .site-content -->


<?php get_footer(); ?> 