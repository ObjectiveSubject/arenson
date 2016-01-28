<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="ie lt-ie10 lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="ie lt-ie10 lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="ie lt-ie10 lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>         <html class="ie lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE]>         	 <html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if !IE]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<title><?php wp_title(); ?></title>
	
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
	<meta name="Description" content="<?php bloginfo('description'); ?>" />
	<meta name="robots" content="NOODP"> <!-- do not use Open Directory Project (http://www.dmoz.org/) for site description -->
	
	<link rel="shortcut icon" href="<? echo get_template_directory_uri(); ?>/img/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="<? echo get_template_directory_uri(); ?>/img/touch-icon-iphone.png">
	<link rel="apple-touch-icon" sizes="76x76" href="<? echo get_template_directory_uri(); ?>/img/touch-icon-ipad.png">
	<link rel="apple-touch-icon" sizes="120x120" href="<? echo get_template_directory_uri(); ?>/img/touch-icon-iphone-retina.png">
	<link rel="apple-touch-icon" sizes="152x152" href="<? echo get_template_directory_uri(); ?>/img/touch-icon-ipad-retina.png">	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<?php wp_head(); ?>
		
	<!-- Fonts -->
	<script type="text/javascript" src="http://fast.fonts.com/jsapi/1f9f0a9c-2a59-4857-84a7-3d2ae07f3244.js"></script>
	
</head>

<?php $current_division = get_current_division(); ?>
<?php if ($current_division !== 'global') { $divs = get_posts(array('post_type'=>'product_overviews', 'post__not_in'=>array(21144), 'orderby'=>'menu_order', 'order'=>'ASC')); } ?>

<body <?php body_class('division-'.$current_division); ?> data-division="<? echo $current_division; ?>">
<?php $loggedoutclass = member_logged_in() ? 'user_logged_in' : 'user_logged_out'; ?>
<div id="page" class="hfeed site <?php echo $loggedoutclass; ?>">

	<header id="masthead" class="site-header" role="banner">
	
		<div id="search" class="header-dropdown">
			<div class="centering_box">
				<form method="get" id="searchform" action="/" role="search">									
					<input type="text" class="field" name="s" id="s" value="Look up anything from Arenson">
					<input type="submit" class="submit" name="submit" id="searchsubmit" value="Search">
				</form>
				<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
			</div>
		</div>
		
		<div id="contact" class="header-dropdown">
			<div class="centering_box">
				<div class="contact-info">
					<? if ($current_division !== 'global') {
							$div_overview = get_posts(array('name'=>$current_division, 'post_type'=>'product_overviews'));
							$phone = get_field('phone_number', $div_overview[0]->ID );
							$email = get_field('division_email', $div_overview[0]->ID );
							$address = get_field('address', $div_overview[0]->ID );
					 } else {
						 $phone = '(646) 395-3563';
						 $email = 'info@aof.com';
					 } ?>
					<ul>
						<li class="phone">
							<h3>Get in touch<br /><?php echo $phone; ?></h3>
						</li>
						<li class="address">
							<h5><?php echo $address; ?></h5>
						</li>
						<li class="email">
							<h5><a href="mailto:<?php echo $email; ?>" target="_blank"><?php echo $email; ?> »</a></h5>
						</li>
						<li class="link"><h5><a href="/contact">See our full contact information »</a></h5></li>
					</ul>
				</div>
				<div class="contact-form">
					<?php gravity_form($id_or_title=2, $display_title=true, $display_description=false, $display_inactive=false, $field_values=null, $ajax=true ); ?>
				</div>
				
				<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
			</div>
		</div>
		
		<div id="navigation">
			<div class="centering_box">
				<div class="title-division">
					<h1 class="site-title"><a href="/" class="icon-ar_logo"><span class="hide-text">Arenson</span></a></h1>
					<? if ($divs) : ?>
					<ul class="site_divisions closed">
						<li class="division current-division">
							<span class="icon <?php echo get_division_icon_class($current_division); ?>"></span>
							<a href="<? echo '/p/'.$current_division; ?>" class="division-name">
								<?foreach ($divs as $div) { 
									if ($div->post_name === $current_division) { echo $div->post_title; break; } 
								} ?>
							</a>
							<a href="#" class="toggle">See Products</a>
						</li>
					</ul>
					<? endif; ?>
				</div>
				<a href="#" class="menu-toggle icon icon-ar-menu"></a>
				<a href="#contact" class="mobile_contact">Contact</a>
				<nav class="main-navigation">
	
					<?php wp_nav_menu( array( 'theme_location' => 'main-navigation' ) ); ?>
	
					<?php 
					if (is_user_logged_in()) :
					global $dontReload;
					global $current_user;
		      get_currentuserinfo();
					$data_action = (is_page($dontReload)) ? 'data-page_action="noreload"' : 'data-page_action="reload"';
					$favebinderHash=getFavoritesBinder(get_cur_user_id(),true);
					?>
					
					<div class="menu-utility-container user-only">
						<ul id="menu-utility" class="menu">
							<li class="menu-item favorites"><a id="ui_favorites" href="<? echo home_url('binder'); ?>?b=<? echo $favebinderHash; ?>"><span class="icon icon-ar_fav-closed"></span>My Favorites</a></li>
							<li class="menu-item binders"><a id="ui_binders" href="<? echo get_bloginfo('url'); ?>/dashboard#binder_intro"><span class="icon icon-ar_binder"></span>My Binders</a></li>
							<li class="menu-item register"><a class="" id="ui_myaccount" rel="ui_myaccount" href="<? echo get_bloginfo('url'); ?>/dashboard"><span class="icon icon-ar_account"></span><? echo $current_user->user_firstname; ?></a></li>
							<li class="menu-item login"><a class="ajax_ui" id="ui_logout" rel="ui_logout" <? echo $data_action; ?> href="#"><span class="icon icon-ar_logout"></span>Log out</a></li>
						</ul>
					</div>
	
					<?php else : ?>
	
					<div class="menu-utility-container non-user">
						<ul id="menu-utility" class="menu">
							<li class="menu-item favorites"><a href="/newuser?ac=cf"><span class="icon icon-ar_fav-closed"></span>Create Favorites</a></li>
							<li class="menu-item binders"><a href="/newuser?ac=cb"><span class="icon icon-ar_binder"></span>Create Binder</a></li>
							<li class="menu-item register"><a href="/newuser"><span class="icon icon-ar_account"></span>Register</a></li>
							<li class="menu-item login">
								<a href="#fb_login_form" class="fancy_popup login_button"><span class="icon icon-ar_logout"></span>Log In</a>
							</li>
						</ul>
					</div>
					
					<?php endif; ?>
									
	
				</nav>
			</div>
		</div><!-- #navigation -->
		
		<div id="product_map" class="closed">
			<div class="product_map_content centering_box">
				<section class="site_divisions">
					<header class="column_header">
						<h4 class="column_title">&nbsp;</h4>
					</header>
					<ul class="div_list">
						<?php 
						$count = 1;
						foreach($divs as $div) : ?>
						<li class="division <? echo ($current_division == $div->post_name) ? 'current_division' : ''; ?><? echo ($count%2 == 0) ? ' even':''; ?>">
							<span class="icon <?php echo get_division_icon_class($div->post_name); ?>"></span>
							<a href="<? echo $div->guid; ?>" class="division-name"><?php echo $div->post_title; ?></a>
						</li>
						<?php $count++; endforeach; ?>
					</ul>
				</section>
				
				
				<? if ($current_division !== 'global') :

				$term = get_term_by( 'slug', $current_division, 'p_cat' );			
				$child_terms_args = array(
					'hide_empty' => 0,
					'parent' => $term->term_id,
					'orderby'       =>  'term_order'	
				);
				
				$term_children = get_terms('p_cat', $child_terms_args ); ?>
				
				<section class="products <? echo $current_division . '-products' ?>">
					<header class="column_header">
						<h4 class="column_title">Products by Category</h4>
					</header>
					<div class="cat_table">	
					
						<? foreach($term_children as $child) : ?>
						<div class="cat_column <? echo 'cat-'.$child->slug; ?>">
							<header class="cat_header">
								<h6 class="cat_title"><a href="<? echo site_url().'/product_type/'.$child->slug; ?>"><? echo $child->name; ?>&nbsp;<span class="view_all">View All</span></a></h6>
							</header>
							<ul class="cat_list">
								<?
								$grandchild_terms_args = array(
									'hide_empty' => 0,
									'parent' => $child->term_id,
									'orderby'       =>  'term_order'	
								);
								
								$term_grandchildren = get_terms('p_cat', $grandchild_terms_args );
																
								$count = 1; $list_num = '';
								foreach($term_grandchildren as $grandchild) :
								if ($count % 3 == 0) {
									$list_num = 'third';
								} 
								if ($count % 2 == 0) {
									$list_num .= ' even';
								} ?>
								<li class="cat_term <? echo $list_num; ?>"><a href="<? echo site_url().'/product_type/'.$grandchild->slug; ?>"><? echo $grandchild->name; ?></a></li>
								<? $list_num = ''; $count++; endforeach; ?>
							</ul>
						</div><!-- .cat_column -->
						<? endforeach; ?>
						
					</div>
				</section>
				
				<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
				
				<? endif; ?>
				
				
			</div>
		</div><!-- #product_map -->
		
	</header><!-- #masthead -->

	<div id="main" class="site-body">
