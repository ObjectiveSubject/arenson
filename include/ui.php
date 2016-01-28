<?php
//aof codebase init


//@ menu bar for logging in/out breadcrumbs etc
function get_subnavbar() {
	// wp_reset_query();
	// var_dump(is_post_type_archive('products'));
	$username_pages=array('binder','dashboard');
	ob_start(); ?>		
		<div class="breadcrumbs menu_horizontal">
			<ul>
				<?
					$product_post_types = array(
						'office_furn_products',
						'arch_products',
						'furn_rental_products',
						'outlet_products',
						'prop_products'
					);
					$service_post_types = array(
						'office_service',
						'outlet_service',
						'rental_service',
						'prop_service',
						'arch_service'
					);
					$idea_post_types = array(
						'arch_idea_overview',
						'prop_idea_overview',
						'office_idea_overview',
						'rental_idea_overview',
						'outlet_idea_overview'
					);  
				
					if(is_page($username_pages))
						echo '<li>Logged in as '.get_cur_username().'</li>';											
				
					elseif(is_single() && in_array(get_post_type(), $product_post_types))
						echo get_product_breadcrumb();
						
					elseif(is_single() && in_array(get_post_type(), $service_post_types))
						echo '<li class="bcrumb">Service</li>';	
					
					elseif(is_single() && in_array(get_post_type(), $idea_post_types))
						echo '<li class="bcrumb">Idea</li>';					
						
					elseif(is_single() && get_post_type() == 'post')
						echo '<li class="bcrumb"><a href="/news">' . 'News' . '</a></li>';					
						
					elseif(is_tax('p_cat'))
						echo get_tax_breadcrumbs(get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ));	
					
					elseif(get_post_type()=='product_overviews') {					
						$current_slug = the_slug();
						$current_tax= 'p_cat';
						$term = get_term_by( 'slug', $current_slug, $current_tax);		
						if($term)				
							echo get_tax_breadcrumbs($term);
						else
							echo '<li>' . get_the_title() . '</li>';
					}					
					
					elseif(is_tax('markets'))
						echo get_tax_breadcrumbs_markets(get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ));					
					
					elseif(get_post_type()=='market_overview') {					
						echo '<li class="bcrumb"><a href="/markets">' . 'Markets' . '</a></li>';						
					}
					
					elseif(is_tax('p_tag'))
						echo '<li>' . get_tax_title() . '</li>';
						
					elseif(is_404())
						echo '<li>Page not Found</li>';
						
					elseif(is_tag())
						echo '<li>' . single_tag_title( '', false ) . '</li>';
					
					else
						echo '<li>' . get_the_title() . '</li>';
						//echo '<ul><li>' . get_the_title() . '</li></ul>'; ?>
			</ul>
		</div>

<? $subnav = ob_get_clean(); return $subnav;

} // get_subnavbar()




//@ bar for binder functions
function get_productbar() {

		global $post;
		$prod_id=$post->ID;

		if(member_logged_in()) {
			$user_id=get_cur_user_id();
			$faveID=isFavoriteItem($prod_id,$user_id);
			
			$downloadLink=get_post_meta($prod_id,'productImagesDownloadLink',true);
			$downloadLink=$downloadLink ? wp_get_attachment_url( $downloadLink) : false;	

		}
		ob_start(); ?>
		<div class="productbar">
			<div class="menu_horizontal">
				<ul>
					<? if(member_logged_in()) { ?>
				
					<li class="favoritescontainer" rel="<? echo $prod_id ?>">
					<? if ($faveID) { ?>
						<a class="binder_favorite_added fonticon_section" id="binder_removefavorite" rel="<? echo $faveID ?>" href=""><span class="icon icon-ar_fav-closed"></span> Favorite</a>
					<? } else { ?>
						<a class="binder_notfavorited fonticon_section" id="binder_addfavorites" rel="<? echo $prod_id ?>" href=""><span class="icon icon-ar_fav-open"></span> Add to Favorites</a>
					<? } ?>
					</li>
					<li><a class="ajax_binder fancy_popup" id="binder_add" rel="" href="#fb_binder_add"><span class="icon icon-ar_add-binder"></span> Add to Binder</a></li>
					<li><a class="ajax_binder fancy_popup" id="binder_req_quote" rel="" href="#fb_binder_add"><span class="icon icon-ar_quote"></span> Request a Quote</a></li>
					<li><a target="_blank" id="product_download_pdf" href="<? echo get_permalink() ?>?dx=<? echo $prod_id ?>&tx=s" class=""><span class="icon icon-ar_dwnld-binder"></span> Download PDF</a></li>
					<? if($downloadLink) { ?><li><a class="download_link" id="product_download_images" href="<? echo $downloadLink ?>">Download Product Images</a></li> <? } ?>
				
				<? } else { ?>
				
					<li class="favoritescontainer" rel="<? echo $prod_id ?>">
						<a class="binder_notfavorited notlive" id="binder_addfavorites" rel="<? echo $faveID ?>" href="<? echo get_bloginfo('url') ?>/newuser?msg=fave&pd=<? echo $prod_id?>"><span class="icon icon-ar_fav-open"></span> Add to Favorites</a>
					</li>
					<li><a class="" id="binder_add" rel="" href="<? echo get_bloginfo('url') ?>/newuser?msg=add&pd=<? echo $prod_id?>"><span class="icon icon-ar_add-binder"></span> Add to Binder</a></li>
					<li><a class="" id="binder_req_quote" rel="" href="<? echo get_bloginfo('url') ?>/newuser?msg=req_quote&pd=<? echo $prod_id?>"><span class="icon icon-ar_quote"></span> Request a Quote</a></li>
					<li><a target="_blank" id="product_download_pdf" href="<? echo get_permalink() ?>?dx=<? echo $prod_id ?>&tx=s" class=""><span class="icon icon-ar_dwnld-binder"></span> Download PDF</a></li>		
				
				
				<? } ?>
				</ul>				

			</div>

			<div class="clearfix"></div>
		</div>


	<?
		$subnav = ob_get_clean();
	
	return $subnav;
}

//@ bar for sharing functions
function get_productshare() {
	global $post;
	ob_start(); ?>
	<div class="sharebar">

		<a class="expand_email_title" id="product_shareEmail" rel="<? echo $prod_id ?>" href=""><span class="icon icon-ar_email"></span> Send via Email</a></li>

		<div id="single_sharebox">
			<form class="product_email_form clearfix" rel="<? echo $post->ID ?>">
				<input type="text" class="clearMeFocus required email" id="product_email_destination" value="Enter email" title="Enter email" rel=">" />
				<input type="submit" value="Send" class="aof_button" />
				
			</form>				
			<p class="share_response"></p>
		</div>
	</div>


<?
	$subnav = ob_get_clean();
	return $subnav;
}


//Social Sharing
function get_socialshare() {
	global $post;
	ob_start(); ?>
	
	<div class="social-share">
	
		<div class="elements">
			<div class="fb-share-button" data-href="<?php urlencode(get_permalink($post->ID)); ?>" data-type="button_count"></div>
						
			<!-- LinkedIn -->
			<script src="//platform.linkedin.com/in.js" type="text/javascript">
			  lang: en_US
			</script>
			<script type="IN/Share" data-counter="right"></script>
			
			<!-- Pinterest -->
			<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" class="pinterest-share-button"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>
		
			<!-- Twitter -->
			<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-url="<?php urlencode(get_permalink($post->ID)); ?>" data-text="<?php echo get_the_title($post->ID).' @ArensonOffice'; ?>">Tweet</a>
						
		</div>

		<div class="scripts">
			<!-- Facebook -->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<!-- Twitter -->
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

			<!-- Pinterest -->
			<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
		</div>
	</div>	
	
<?php 
	$social = ob_get_clean();
	return $social;
}


function get_breadcrumbs($mytax='p_cat') {

	$myterm=get_the_terms( $post->ID, $mytax );
	$breadcrumbs=array();

	foreach($myterm as $oneterm) {
		if($oneterm->parent==0)
			$breadcrumbs[$oneterm->name]=get_term_link($oneterm->name, $mytax );
	}							
			
//	var_dump($breadcrumbs);


}

	
	
function get_login_form() {
	global $popupBlockPages;
	global $wp_query;
	$curPage=$wp_query->queried_object->ID;
	
	if(!in_array($curPage, $popupBlockPages)) {
		ob_start(); ?>
		<div class="fancybox_container">
			<div id="fb_login_form" class="fb_popup_container">
				<div id="login_form" class="fb_popup_default">
					<? include('box_login.php');
						echo $good_html;?>
				</div>	

				<div id="fb_loading" class="fb_loading fb_temporaries action_alerts"></div>
				<div id="fb_results" class="fb_results fb_temporaries action_alerts"><h3></h3><p class="db_message"></p></div>
			</div>
		</div>
			
	<?	$login_output = ob_get_clean();
	}
		
	return $login_output;
}
	
	
function get_binder_add_form() {
		global $post;
		$prod_id=$post->ID;
		$binderadd_button = 'Add Item';
		$binderadd_title = 'Add item to your Binder';
		ob_start(); ?>
		<div id="binder_add_form" class="fb_popup_default">
			<? include('box_binder.php');
				echo $good_html;?>
		</div>
		
		<div id="fb_loading" class="fb_loading fb_temporaries action_alerts"></div>
		<div id="fb_results" class="fb_results fb_temporaries action_alerts"><h3></h3><p class="db_message"></p></div>
	
	<?	$login_output = ob_get_clean();
	
		
	return $login_output;
}	
	
function get_product_request_form() {
		global $post;
		$prod_id=$post->ID;
		$binderadd_button = 'Request a Quote';
		$binderadd_title = 'Request a Quote';
		ob_start(); ?>
		<div id="product_request_form" class="fb_popup_default">
			<? include('box_binder.php');
				echo $good_html;?>
		</div>
		
		<div id="fb_loading" class="fb_loading fb_temporaries action_alerts"></div>
		<div id="fb_results" class="fb_results fb_temporaries action_alerts"><h3></h3><p class="db_message"></p></div>
	
	<?	$login_output = ob_get_clean();
	
		
	return $login_output;
}






?>