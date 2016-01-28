<?php
//aof content options


//CLIENT CONTENT ASSOCIATION
add_action( 'add_meta_boxes', 'add_client_related' );

	function add_client_related() {
		add_meta_box( 
				'myplugin_sectionid',
				'Associated Client with this Content',
				'add_client_related_box',
				'client_content',
				'side',
				'core'
		);				
		
		add_meta_box( 
				'myplugin_sectionidddd',
				'Associate a Client with this Store',
				'associate_client_with_store',
				'client_stores',
				'side',
				'high'
		);		
		
		add_meta_box( 
				'myplugin_sectionidd',
				'Add to a Client Store',
				'add_client_store',
				'office_furn_products',
				'side',
				'high'
		);
		
		add_meta_box( 
				'myplugin_sectionidd',
				'Add to a Client Store',
				'add_client_store',
				'arch_products',
				'side',
				'high'
		);
		
		add_meta_box( 
				'myplugin_sectionidd',
				'Add to a Client Store',
				'add_client_store',
				'furn_rental_products',
				'side',
				'high'
		);
		
		add_meta_box( 
				'myplugin_sectionidd',
				'Add to a Client Store',
				'add_client_store',
				'outlet_products',
				'side',
				'high'
		);
		
		add_meta_box( 
				'myplugin_sectionidd',
				'Add to a Client Store',
				'add_client_store',
				'prop_products',
				'side',
				'high'
		);
	}
	
		//associate a client with a store
		function associate_client_with_store( $post ) {

			// Use nonce for verification
			wp_nonce_field( plugin_basename( __FILE__ ), 'project_blogassociate' );
			
			$all_clients = getClients();

			$storeRelatedClient =get_post_meta($post->ID, 'storeRelatedClient', true);

			//echo get_post_meta($post->ID, 'relatedProject', true);
			echo '<select name="storeRelatedClient">';
			echo '<option value="0">None</option>';	
			foreach($all_clients as $oneclient) {
				$thisClient=get_userdata( $oneclient );
				$thisCompany=get_the_author_meta('member_company', $oneclient );
				echo '<option value="' . $oneclient . '"';
				if($oneclient==$storeRelatedClient)		//==get_post_meta($post->ID, 'productRelatedContent1', true))
					echo ' selected="selected" ';
				echo '>' . $thisCompany . " - " . $thisClient->first_name . " " . $thisClient->last_name . '</option>';
				
				}
			echo '</select>';			
		}			
		
		
		//related content for a client content
		function add_client_related_box( $post ) {

			// Use nonce for verification
			wp_nonce_field( plugin_basename( __FILE__ ), 'project_blogassociate' );
			
			$all_clients = getClients();

			$related_client =get_post_meta($post->ID, 'clientRelatedID', true);

			//echo get_post_meta($post->ID, 'relatedProject', true);
			echo '<select name="client_related">';
			echo '<option value="0">None</option>';	
			foreach($all_clients as $oneclient) {
				$thisClient=get_userdata( $oneclient );
				$thisCompany=get_the_author_meta('member_company', $oneclient );
				echo '<option value="' . $oneclient . '"';
				if($oneclient==$related_client)		//==get_post_meta($post->ID, 'productRelatedContent1', true))
					echo ' selected="selected" ';
				echo '>' . $thisCompany . " - " . $thisClient->first_name . " " . $thisClient->last_name . '</option>';
				
				}
			echo '</select>';			
		}	
	
		//store data
		function add_client_store( $post ) {

			// Use nonce for verification
			wp_nonce_field( plugin_basename( __FILE__ ), 'project_blogassociate' );
			
			$all_client_stores = getAllClientStores();
			$existing_client_associations=getStoresforProduct($post->ID);
		//	var_dump($existing_client_associations);
			
		//	$related_store =get_post_meta($post->ID, 'storeRelated', true);

			//echo get_post_meta($post->ID, 'relatedProject', true);
			echo '<select name="client_store_relation[]" multiple="multiple">';
	
				echo '<option value="">None</option>';
				foreach($all_client_stores as $onestore) {

					echo '<option value="' . $onestore['id'] . '"';
					if(in_array($onestore['id'], $existing_client_associations))		//==get_post_meta($post->ID, 'productRelatedContent1', true))
						echo ' selected="selected" ';
					echo '>' . $onestore['post_title']  . '</option>';
					
					}
			echo '</select>';			
		}	

//save data
add_action( 'save_post', 'save_client_related' );

	function save_client_related( $post_id ) { 
		// if autosave, do not save data.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		  return;

		// verify this came from the our screen and with proper authorization,because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['project_blogassociate'], plugin_basename( __FILE__ ) ) )
		  return;

		// Check permissions
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;

		// save related client for the content type that shows up on dashboard
		$related_client = $_POST['client_related']; 
		update_post_meta($post_id, 'clientRelatedID', $related_client);
		
		
		// save related client for the store
		$storeRelatedClient = $_POST['storeRelatedClient']; 
		update_post_meta($post_id, 'storeRelatedClient', $storeRelatedClient);
		
		//save related stores for the product pages
		$client_store_relation = $_POST['client_store_relation']; 
		updateStores($client_store_relation,$post_id);
		
	}


	
	
//RELATED CONTENT ASSOCIATION
add_action( 'add_meta_boxes', 'add_related_content' );

	function add_related_content() {
		add_meta_box( 
				'myplugin_sectionid',
				'Related Content',
				'add_related_content_box',
				'products',
				'side',
				'core'
		);
	}
	
	//box content
	function add_related_content_box( $post ) {

			// Use nonce for verification
			wp_nonce_field( plugin_basename( __FILE__ ), 'project_blogassociate' );

			global $wpdb;
			$post_table = $wpdb->get_blog_prefix() . "posts";
			$myquery = "SELECT ID,post_title FROM $post_table where post_type='content' AND post_status='publish' order by ID";
			$related_contents = $wpdb->get_results($myquery,ARRAY_A);	
			
			$alreadyrelated1 =get_post_meta($post->ID, 'productRelatedContent1', true);
			$alreadyrelated2 =get_post_meta($post->ID, 'productRelatedContent2', true);

			//echo get_post_meta($post->ID, 'relatedProject', true);
			echo '<select name="product_related1">';
			echo '<option value="0">None</option>';	
			foreach($related_contents as $onepost) {
				echo '<option value="' . $onepost['ID'] . '"';
				if($onepost['ID']==$alreadyrelated1)		//==get_post_meta($post->ID, 'productRelatedContent1', true))
					echo ' selected="selected" ';
				echo '>' . $onepost['post_title'] . '</option>';
				
				}
			echo '</select>';			
			
			echo '<select name="product_related2">';
			echo '<option value="0">None</option>';	
			foreach($related_contents as $onepost) {
				echo '<option value="' . $onepost['ID'] . '"';
				if($onepost['ID']==$alreadyrelated2)		//==get_post_meta($post->ID, 'productRelatedContent1', true))
					echo ' selected="selected" ';
				echo '>' . $onepost['post_title'] . '</option>';
				
				}
			echo '</select>';
		}	

//save data
add_action( 'save_post', 'add_product_related' );

	function add_product_related( $post_id ) {
		// if autosave, do not save data.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		  return;

		// verify this came from the our screen and with proper authorization,because save_post can be triggered at other times
		if ( !wp_verify_nonce( $_POST['project_blogassociate'], plugin_basename( __FILE__ ) ) )
		  return;

		// Check permissions
		if ( !current_user_can( 'edit_post', $post_id ) )
			return;

		// OK, we're authenticated: we need to find and save the data
		$related_content1 = $_POST['product_related1'];
		$related_content2 = $_POST['product_related2'];
		update_post_meta($post_id, 'productRelatedContent1', $related_content1);
		update_post_meta($post_id, 'productRelatedContent2', $related_content2);
	}


/* breadcrumb builder */
function build_breadcrumbs($breadcrumbs, $taxononomy='p_cat') {

	$taxdata = get_taxonomy($taxononomy);
	
	if(!empty($breadcrumbs)) { $breadcrumbs = array_reverse($breadcrumbs); }

	$i=0;
	foreach ($breadcrumbs as $crumb) {
		$i++;
		$item = get_term_by( 'id', $crumb, $taxononomy);
		
		$url = ($i==1) ? get_permalink(get_landing_page($item->slug, $taxononomy)) : get_bloginfo('url').'/'.$taxdata->rewrite['slug'].'/'.$item->slug;

		$crumb_output.= '<li class="bcrumb';
		if($i==1)
			$crumb_output.= ' crumb_first';
		if($i==count($breadcrumbs))
			$crumb_output.= ' crumb_last';
		$crumb_output.='"><a href="'.$url.'">'.$item->name.'</a></li>';	
	}
	
	return $crumb_output;	
}

	
/* taxonomy breadcrumbs */
function get_tax_breadcrumbs($endterm,$breadcrumbs=array()) {

	$breadcrumbs[]=$endterm->term_id;
	
	$immed_parent=$endterm->parent;
	
	//rest of parents
	while($immed_parent) {
		$breadcrumbs[]=$immed_parent;
		$new_parent = get_term_by( 'id', $immed_parent, 'p_cat');
		$immed_parent=$new_parent->parent;
	}
	
	return build_breadcrumbs($breadcrumbs);

}


/* taxonomy breadcrumbs for markets */
function get_tax_breadcrumbs_markets($endterm,$breadcrumbs=array()) {

	$breadcrumbs[]=$endterm->term_id;
	
	$immed_parent=$endterm->parent;
	//rest of parents
	while($immed_parent) {
		$breadcrumbs[]=$immed_parent;
		$new_parent = get_term_by( 'id', $immed_parent, 'markets');
		$immed_parent=$new_parent->parent;
	}
	return build_breadcrumbs($breadcrumbs, 'markets');
}
	
	
/* product breadcrumbs */
function get_product_breadcrumb($returnarray = false) {
	
	global $post;
	$all_terms = get_the_terms( $post->ID, 'p_cat' );

	$breadcrumbs=array();

	if ($all_terms && is_array($all_terms)) {
		//immediate parent
		foreach($all_terms as $oneterm)  {
			if(get_term_children( $oneterm->term_id, 'p_cat'  ) == array()) {
				$breadcrumbs[]=$oneterm->term_id;
				$immed_parent=$oneterm->parent;
			}
		}
		//rest of parents
		while($immed_parent) {
			$breadcrumbs[]=$immed_parent;
			$new_parent = get_term_by( 'id', $immed_parent, 'p_cat');
			$immed_parent=$new_parent->parent;
		}
		
		return $returnarray ? $breadcrumbs : build_breadcrumbs($breadcrumbs);
	} else
		return "";
}	// get_product_breadcrumb()
	
	
// tax title
function get_tax_title($echome=false) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
		if($echome)
			echo $term->name;
		else
			return $term->name;
	}	
	
	
//taxonomy children terms 
function get_tax_level($current_tax) {

	if(is_top_tax($current_tax))
		$tax_level="top";
	elseif(is_last_tax($current_tax))
		$tax_level="bottom";
	else
		$tax_level="midrange";
		
	return $tax_level;

}


function get_child_taxes($current_tax, $toplevel=false) {
	
	global $wp_query;
	
	$term = get_term_by( 'slug', get_query_var( 'term' ), $current_tax );			
	//$term_id = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );			

	if ($toplevel) {
		$child_terms_args = array(
			'hide_empty' => 0,
			'parent' => $toplevel,
			'orderby'       =>  'term_order'			
			//'child_of'	=> $toplevel,
		);
	} else {
		$child_terms_args = array(
			'hide_empty' => 0,
			'parent' => $term->term_id,
			'orderby'       =>  'term_order'	
			//'child_of'	=> $term->term_id,
		);
	}	
	
//	var_dump($child_terms_args);
//	$term_children= get_term_children( $term->term_id, get_query_var( 'taxonomy' )  );
	
	$term_children = get_terms($current_tax, $child_terms_args ) ;
	return $term_children;
}


function is_top_tax($taxname) {
	$istop=false;
	global $wp_query;
	$term = get_term_by( 'slug', get_query_var( 'term' ), $taxname );
	if($term->parent==0)
		$istop=true;
		
	return $istop;
}


function get_top_term($term_id, $taxonomy='p_cat') {

	$ancestors = get_ancestors($term_id, $taxonomy);
	$last_item = count($ancestors) - 1;
	$top_term_id = $ancestors[$last_item];
	$top_term = get_term($top_term_id, $taxonomy);
	
	return $top_term;
}


function is_last_tax($taxname, $taxterm=null) {
	$islast=false;
	global $wp_query;

	$term = get_term_by( 'slug', get_query_var( 'term' ), $taxname );
	$term_kids=get_term_children( $term->term_id, get_query_var( 'taxonomy' )  );
	
	if(empty($term_kids))
		$islast=true;
		
	return $islast;
}


function get_tax_overview_img($term_id, $size='product_overviews') {
	$img_url=tip_plugin_get_terms($term_id, $size);
	return $img_url[0];
}


function tip_plugin_get_terms($term_id, $echo_image_url=false) {	//for use with taxonomy images plugins
 	$associations = taxonomy_image_plugin_get_associations();
	//var_dump($associations);
	$tt_id = absint( $term_id );
	$img_id = false;
	if ( array_key_exists( $tt_id, $associations ) ) {
		$img_id = absint( $associations[$tt_id] );
	}

	if(!$echo_image_url)
		return $img_id;
	else
		return wp_get_attachment_image_src( $img_id, $echo_image_url);
 }

		
function get_prod_sku($item_id) {
	global $wpdb;
	$postmeta_table = $wpdb->get_blog_prefix() . "postmeta";
	$myquery = "SELECT meta_value FROM $postmeta_table where meta_key='productClientSKU' AND post_id='$item_id'";
	$myresult = $wpdb->get_var($myquery);
	return $myresult;
}		


function get_prod_description($prodID) {
	$product = get_post($prodID); 
	return $product->post_content;
}


function get_prod_name($prodID) {
	$product = get_post($prodID); 
	return $product->post_title;
}


function get_the_hover_excerpt() {
	global $post;
	$subheader= get_post_meta($post->ID, 'productSubheader', true);
	$hover_excerpt = $subheader ? $subheader : shorten_string(get_the_excerpt(), 15);
	//$longexcerpt=get_the_excerpt();
	//return shorten_string($longexcerpt, 15);
	return $hover_excerpt;
}


function shorten_string($string, $wordsreturned)
	/*  Returns the first $wordsreturned out of $string.  If string
	contains fewer words than $wordsreturned, the entire string
	is returned.
	*/
	{
	$retval = $string;      //  Just in case of a problem
	 
	$array = explode(" ", $string);
	if (count($array)<=$wordsreturned)
	/*  Already short enough, return the whole thing
	*/
	{
	$retval = $string;
	}
	else
	/*  Need to chop of some words
	*/
	{
	array_splice($array, $wordsreturned);
	$retval = implode(" ", $array)." ...";
	}
	return $retval;
}


function get_landing_page($slug, $taxonomy) {
	global $taxonomy_landing_page_translations;
	
	$args = array(
		'post_type'	=>	$taxonomy_landing_page_translations[$taxonomy],
		'name'	=>	$slug
	);
			
	$existing_post = get_posts($args);
	
	if(isset($existing_post)&&$existing_post[0]!=NULL)
		return $existing_post[0]->ID;

}



/* Old Code.... 
------------------------------------*/
/*
add_filter('posts_join', 'custom_field_search_join' );
function custom_field_search_join ($join){
    global $pagenow, $wpdb;
    // I want the filter only when performing a search on edit page of Custom Post Type named
    if ( is_admin() && $pagenow=='edit.php' && $_GET['post_type']=='products' && $_GET['s'] != '') {    
        $join .='LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}

add_filter( 'posts_where', 'custom_field_search_where' );
function custom_field_search_where( $where ){
    global $pagenow, $wpdb;
    // I want the filter only when performing a search on edit page of Custom Post Type named
    if ( is_admin() && $pagenow=='edit.php' && $_GET['post_type']=='products' && $_GET['s'] != '') {
        $where = preg_replace(
       "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
       "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }
    return $where;
} */

/*
// Join for searching metadata
function AIOThemes_joinPOSTMETA_to_WPQuery($join) {
    global $wp_query, $wpdb;

    if (!empty($wp_query->query_vars['s'])) {
        $join .= "LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
    }

    return $join;
}

add_filter('posts_join', 'AIOThemes_joinPOSTMETA_to_WPQuery');


function AIO_AlphabeticSearch_WhereString( $where, &$wp_query )
{
    global $wpdb;
    if(isset($_GET['aioAlphaSearchMode']) && $_GET['aioAlphaSearchMode'] == 1){

        $searchAlphabet = $_GET['s']; 

        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \''.$searchAlphabet.'%\' ';

        // use only if the post meta db table has been joined to the search tables using posts_join filter
        $where .= " AND ($wpdb->postmeta.meta_key = 'JDReview_CustomFields_ReivewOrNewsPostType' AND $wpdb->postmeta.meta_value = 'JDReview_PostType_ReviewPost') ";

    }
}

add_filter( 'posts_where', 'AIO_AlphabeticSearch_WhereString', 10, 2 ); */

/*
function aof_filters_search( $query ) {
	if ($query->is_search) {
		$s = $_GET['s'];
		
		$tax = isset($_GET['tx']) ? $_GET['tx'] : false;
		$term = isset($_GET['tn']) ? $_GET['tn'] : false;

		if($tax||$term) {
			$newq = array(
				array(
					'taxonomy' => $tax,
					'field' => 'slug',
					'terms' => $term
				)
			);
			$query->set( 'tax_query', $newq );
		} 
	
	}
	return $query;

}
add_action( 'pre_get_posts', 'aof_filters_search' );
*/




/* 
----------------------------------------------------------------------
Objective Subject Stuff 
---------------------------------------------------------------------- */

function get_current_division() {

	global $wp_query;
	$queryObject = $wp_query->queried_object;
		
	if ($queryObject) {
	
		$divTerms = get_the_terms($queryObject->ID, 'division');
		if ($divTerms) {
			$divTermSlug;
			foreach ($divTerms as $divTerm) { $divTermSlug = $divTerm->slug; }		
		}
		
		if ($queryObject->term_id) {
			$top_term = get_top_term($queryObject->term_id);			
		}
		
		if ( is_singular(array('office_furn_products', 'office_idea_overview', 'office_service')) || 
				 is_single('office-furnishings') || 
				 is_tax('office_furnishings_ideas') ||
				 $top_term->slug == 'office-furnishings' ||
				 $divTermSlug == 'div-office-furnishings' ) {
		
				 $division = 'office-furnishings';
		
		} else if ( is_singular(array('arch_products', 'arch_idea_overview', 'arch_service')) || 
								is_single('architectural-products') ||
								is_tax('architectural_products_ideas') ||
								$top_term->slug == 'architectural-products' ||
								$divTermSlug == 'div-architectural-products' ) {
		
								$division = 'architectural-products';
		
		} else if ( is_singular(array('furn_rental_products', 'rental_idea_overview', 'rental_service')) || 
								is_single('rental') || 
								is_tax('furniture_rentals_ideas') ||
								$top_term->slug == 'rental' ||
								$divTermSlug == 'div-rental' ) {
			
								$division = 'rental';
		
		} else if ( is_singular(array('prop_products', 'prop_idea_overview', 'prop_service')) || 
								is_single('props') || 
								is_tax('prop_ideas') ||
								$top_term->slug == 'props' ||
								$divTermSlug == 'div-props' ) {
			
								$division = 'props';
		
		} else if ( is_singular(array('outlet_products', 'outlet_idea_overview', 'outlet_service')) || 
								is_single('outlet') || 
								is_tax('outlet_ideas') ||
								$top_term->slug == 'outlet' ||
								$divTermSlug == 'div-outlet' ) {
			
								$division = 'outlet';
		
		} else { $division = 'global';	 }
					
	} else { $division = 'global'; } 

	return $division; 
	
} // get_division()

function get_division_icon_class($slug) {
	if ($slug == 'office-furnishings') {
		$iconClass = 'icon-ar_product-furniture';
	} elseif ($slug == 'architectural-products') {
		$iconClass = 'icon-ar_product-architectural';
	} elseif ($slug == 'rental') {
		$iconClass = 'icon-ar_product-rentals';
	} elseif ($slug == 'props') {
		$iconClass = 'icon-ar_product-props';
	} elseif ($slug == 'outlet') {
		$iconClass = 'icon-ar_product-outlet';
	}
	return $iconClass;
} // get_division_icon_class()

function get_division_product_type($division) {
	$product_type = '';
	
	if ($division == 'office-furnishings') {
		$product_type = 'office_furn_products';
		
	} else if ($division == 'architectural-products') {
		$product_type = 'arch_products';
	
	} else if ($division == 'rental') {
		$product_type = 'furn_rental_products';
	
	} else if ($division == 'props') {
		$product_type = 'prop_products';
	
	} else if ($division == 'outlet') {
		$product_type = 'outlet_products';
	
	} else {
		$product_type = 'any';
	}
	
	return $product_type;
} // get_division_product_type()

?>