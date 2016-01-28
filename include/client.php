<?php
/*
CLIENT AND STORE FUNCTIONS
SOCIAL INK
*/



// STORE FUNCS


function get_client_store($user_id) {

	global $wpdb;
	$postmeta_t = $wpdb->get_blog_prefix() . "postmeta";	
	
	$myquery = "SELECT post_id FROM $postmeta_t where meta_key='storeRelatedClient' AND meta_value LIKE '%$user_id%'";
	$myresult = $wpdb->get_results($myquery, ARRAY_A);
	
	if($myresult&&is_array($myresult)) {
		foreach($myresult as $one_store) {
			$store_array[]=$one_store['post_id'];
			return $store_array;	
		}
	} else
		return false;
		
}


function getStoresforProduct($prod_id) {

	$productAssociatedStores=get_post_meta($prod_id, 'productAssociatedStores', true);
	
	if($productAssociatedStores)
		$productAssociatedStores=explode(";",$productAssociatedStores);
	else
		$productAssociatedStores=array();
		
	return $productAssociatedStores;

}
	
	
	
function updateStores($store_ids, $prod_id) {
	
	if(is_array($store_ids)){				
		$store_ids=implode(';', $store_ids);				
		update_post_meta($prod_id, 'productAssociatedStores', $store_ids);	
		}
}

	

function getStoreProducts($store_id) {
	global $wpdb;
	$postmeta_t = $wpdb->get_blog_prefix() . "postmeta";	
	
	$myquery = "SELECT post_id FROM $postmeta_t where meta_key='productAssociatedStores' AND meta_value LIKE '%$store_id%'";
	
	$storeProducts = $wpdb->get_results($myquery, ARRAY_A);

	if($storeProducts) {
		foreach($storeProducts as $oneProd)
			$storeProductsFormatted[]=$oneProd['post_id'];

	} else
		$storeProductsFormatted=array();
		
	
	return $storeProductsFormatted;
}
	
	
function getAllClientStores() {

	global $wpdb;
	$posts = $wpdb->get_blog_prefix() . "posts";	
	$myquery = "SELECT id, post_title FROM $posts where post_type='client_stores' AND post_status='publish'";
	$myresult = $wpdb->get_results($myquery,ARRAY_A);

	$formatted_posts=array();

	if($myresult) {
		return $myresult;
		
	}else
		return false;	
}




//CLIENT FUNCTIONS

function getClients() {

	global $wpdb;
	$usermetas = $wpdb->get_blog_prefix() . "usermeta";	
	$myquery = "SELECT user_id FROM $usermetas where meta_key='aofIsClient' AND meta_value='true'";
	$myresult = $wpdb->get_results($myquery,ARRAY_A);
	$formatted_ids=array();

	if($myresult) {
	
	foreach($myresult as $result)
		$formatted_ids[]=$result['user_id'];
	
		return $formatted_ids;
		
	}else
		return false;	

}

function getClientPages($user_id) {
	$contentAssociatedbyUser =  intval(get_the_author_meta('member_relatedContent', $user_id ));
	$otherContent=array(
						'post_type' => 	'client_content',
						'meta_key'	=>	'clientRelatedID',
						'meta_value'=>	$user_id,
						'showposts'	=>	 -1,
					);			
	$client_content_pages = get_posts( $otherContent );
	foreach($client_content_pages as $onepage)
		$contentIDs[]=$onepage->ID;

	if(is_array($contentIDs))
		if(!in_array($contentAssociatedbyUser, $contentIDs))
			$contentIDs[]=$contentAssociatedbyUser;
	
	return $contentIDs;
	
}

function getClientMetadata($user_id) {
	global $client_fields;
	$client_fields[]='member_company';
	$clientMetadata=new stdClass();
	foreach($client_fields as $onefield) {
		if(get_the_author_meta($onefield, $user_id ))
			$clientMetadata->$onefield=get_the_author_meta($onefield, $user_id );
	}
	return $clientMetadata;
}



function isClient($user_id) {
	$isClient = get_the_author_meta('aofIsClient', $user_id ) ? true: false;
	return $isClient;
}



//CLIENT DASHBOARD
function getClientDash($user_id) {

	$clientPages=getClientPages($user_id);
	$clientMetadata = getClientMetadata($user_id);
	
	ob_start(); ?>
	<div class="clientDashboard">
		<div class="centering_box">
			<h3>Custom Related Content Area</h3>
			<? 
				if(is_array($clientPages)) {
					$otherContent=array(
							'post_type' => 	'client_content',
							'post__in'=>	$clientPages,
							'showposts'	=>	 -1,
						);			
					$client_content_pages = get_posts( $otherContent );
					global $post;
					foreach($client_content_pages as $post) {
					setup_postdata($post);
					?>
						<div class="clientrelated_page" id="page<? echo $post->ID ?>">
							<? the_content(); ?>
						</div>
					
				<?	}
				
				}
				
				$clientStores=get_client_store($user_id);
			?>
			
			<? if($clientStores) {
				foreach($clientStores as $one_store) { ?>
					<h3><a href="<? echo get_permalink($one_store) ?>">View <? echo $clientMetadata->member_company ?> Company Store &#171;</a></h3>
			<? }
				}?>
			
			
			<div class="dashcol leftcol">
			<? if(count((array)$clientMetadata)!=0) { ?>
				<h4>Tech Tools:</h4>
				<ul>
					<? if($clientMetadata->aofClientAssetManagerTool) { ?>
						<li><a href="<? echo $clientMetadata->aofClientAssetManagerTool ?>">Asset Manager Tool</a></li>
					<? }  if($clientMetadata->aofClientFacilitiesManagerTool) { ?>
					<li><a href="<? echo $clientMetadata->aofClientFacilitiesManagerTool ?>">Facilities Manager Tool</a></li>
					<? }  if($clientMetadata->aofClientFurnitureManagerTool) { ?>
					<li><a href="<? echo $clientMetadata->aofClientFurnitureManagerTool ?>">Furniture Standards Tool</a></li>
					<? }  if($clientMetadata->aofClientWarehouseManagerTool) { ?>
					<li><a href="<? echo $clientMetadata->aofClientWarehouseManagerTool ?>">Warehouse Manager Tool</a></li>
					<? } ?>
				</ul>
			<? } ?>
			</div>			
			
			<div class="dashcol rightcol">
				<h4>Contact Arenson</h4>
				<ul>
					<li>212 - 633 - 2400</li>
					<li>info@aof.com</li>
					<li><a href="<? echo home_url('contact') ?>">See full contact information</a></li>
				</ul>
			</div>
				
			<div class="clearfix"></div>
		</div>	
	</div>
			
	
	
	<?$dash=ob_get_clean();
	
	return $dash;

}

?>