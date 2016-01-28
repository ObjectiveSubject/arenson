<?php

if(member_logged_in()) {
	wp_redirect(get_bloginfo('url')); 
	exit;		
}

get_header();

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
	
	}
	
	$login_redirect_url = ($redir!="") ? get_permalink($redir) : $_SERVER['HTTP_REFERER'];
 ?>

		<div id="primary" class="site-content page-login">
		
			<header class="page-header yellow">
				<div class="centering_box">
					<h1 class="page-title">Welcome</h1>
				</div>
			</header><!-- .page-header -->
					
			<div id="content class" class="page centering_box" role="main">
			
				
				<div class="login_column login_column_fatleft" id="login_column_createacct">
					
					<h4>Not Yet a Member?<br>Not a Problem!</h4>
					
					<p>Getting your own Arenson account provides you with a number of useful benefits.</p>
						<ul>
							<li class="icon_list" id="icon_list_unlimited"><span class="icon icon-ar_binder"></span> Create unlimited Project Binders to neatly organize products and information</li>
							<li class="icon_list" id="icon_list_favorites"><span class="icon icon-ar_fav-open"></span>Love a specific product? Bookmark it with our Favorites feature</li>
							<li class="icon_list" id="icon_list_customquote"><span class="icon icon-ar_quote-custom"></span>Request customized quotes for your project directly from the Arenson team</li>
						</ul>
						
					<div class="get_started">
						<a href="/newuser" class="aof_button" id="button_getstarted">Get Started!</a>
					</div>
				
				</div>			
			
			
			
				<div class="login_column login_column_right" id="login_column_login">
				
					<h4>Login to Access<br />Your Account</h4>
				
					<div id="aof_login_standalone" class="sidebar_style">	
					
						<? include('include/aof_box_login.php');
							echo $good_html;?>
							
						<div id="fb_loading" class="fb_loading fb_temporaries action_alerts"></div>
						<div id="fb_results" class="fb_results fb_temporaries action_alerts"><h3></h3><p class="db_message"></p></div>							
						
					</div>
		
				</div>

				
				<div class="clearfix"></div>
				
			</div>
			
		</div><!-- #primary .site-content -->


<?php get_footer(); ?> 