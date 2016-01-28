<?php
//aof codebase init

//some css stuff depending on page

// Apply filter
add_filter('body_class', 'yellowpages');

function yellowpages($classes) {
	global $yellowBackgroundPages;
	global $wp_query;
	$curPage=$wp_query->queried_object->ID;

	if(in_array($curPage,$yellowBackgroundPages))
		$classes[] = 'yellowpages';
	
	if(isProtected())
		$classes[] = 'yellowpages';
	
	return $classes;
}


//visual (eg slideshow) methods

function get_header_slideshow() {
	
	global $post;
	global $wp_query;

	$mymarker=get_current_marker();
	$post_type=is_post_type_single();
	
	if(!$wp_query->post->ID)
		return false;
	
	if(is_front_page()) {
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => $mymarker,
					'addclass'	=> 'aofslide',
					'showmeta' => true,
					'size' => 'hero_slideshow',
					'fullbleed' => true,				
					'onlyslideshows' => true,
					'orderby' 		=> 'menu_order',					
					'echo_me' => false
					);	
	
	
	}elseif($post_type=='market_overview') {
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => $post_type,
					'addclass'	=> 'aof_product',
					'showmeta' => true,
					'size' => 'hero_slideshow',
					'fullbleed' => true,				
					'onlyslideshows' => true,				
					'echo_me' => false
					);	
	
	}elseif($post_type=='products') {
		
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => $post_type,
					'addclass'	=> 'aof_product',
					'showmeta' => true,
					'size' => 'product_images',
				//	'fullbleed' => true,				
					'onlyslideshows' => true,				
					'echo_me' => false
					);	
	
	}elseif($post_type=='product_overviews') {
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => $post_type,
					'addclass'	=> 'aof_product',
					'showmeta' => true,
					'size' => 'hero_slideshow',
					'fullbleed' => true,				
					'onlyslideshows' => true,				
					'echo_me' => false
					);	
	
	}elseif($post_type) {
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => $post_type,
					'addclass'	=> 'aof_product',
					'showmeta' => true,
					'size' => 'product_images',
					//'fullbleed' => true,				
					'onlyslideshows' => true,				
					'echo_me' => false
					);	
	
	} elseif(is_single()) {
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => $mymarker,
					'addclass'	=> 'aofslide',
					'showmeta' => true,
					'size' => 'hero_slideshow',
					'fullbleed' => true,				
					'onlyslideshows' => true,				
					'echo_me' => false
					);
	}

	//var_dump($wp_query->query_vars);	
	
	if($slideshow_atts) {
		$the_show =  slideshow_gallery($slideshow_atts);
	}
	elseif(is_page()) {

		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');	
	}
	elseif(is_taxonomy('markets')||is_taxonomy('p_cat')) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ));	
		$term_taxonomy_id = $term->term_taxonomy_id;
		//var_dump($term);
	//	var_dump(get_tax_overview_img($term->term_taxonomy_id));
		$large_image_url[0] = get_tax_overview_img($term->term_taxonomy_id, 'full');

		//echo 'hey';get_tax_overview_img
	}	
	elseif(!is_tag()) {
	//	echo 'hey';
		$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
	}
	
	
	if(is_array($large_image_url)&&$large_image_url[0]==null)
		unset($large_image_url);
		
				
	$useSlideshow=true;

	ob_start(); ?>
		<div id="slideshow-container" class="<? if(($the_show->code==null)&&($large_image_url==null)) echo 'empty_slideshow' ?>">
		
			<? if ($the_show && $useSlideshow) { //echo 'hey'; ?>

				<div id="slideshow" class="slideshow menu_horizontal">					
						<? echo $the_show->code ?>
				</div>
								
			<? } ?>
			
		</div>
		<? $slideshow_output = ob_get_clean();
			 return $slideshow_output;
			 
} // get_header_slideshow()




function get_black_bar_intro($blackBarText=false) {
	global $post;
	global $wp_query;
	if(!$blackBarText)
		$blackBarText=get_field('metaContentBlackBar');
		
	if($blackBarText)
		return '<div>'.strip_tags($blackBarText).'</div>';
} 




function get_child_products($current_tax,$current_slug=false) {
	global $wp_query;
	$term_children = get_child_taxes($current_tax,$current_slug);	
	

	if($term_children) {
		ob_start();?>
		<div class="metaContentBlackBar">
			<div class="centering_box columnize_listing">
				<ul>
				<? 
				$count = 1; $list_num = '';
				foreach($term_children as $onechild) {
					if ($count % 3 == 0) { $list_num = 'third'; } 
					if ($count % 2 == 0) { $list_num .= ' even'; } ?>
				
					<li class="<?php echo $list_num; ?>"><a href="<? echo get_term_link( $onechild->slug, $current_tax ); ?>"><? echo $onechild->name ?></a></li>
				<? $list_num = ''; $count++; } ?>
				</ul>
				
				<div class="clearfix"></div>
			</div>
		</div>

		
	
		<? $children_output = ob_get_clean();
		}
		
		return $children_output;
	}
	
function get_child_products_raw($current_tax,$current_slug=false) {
	global $wp_query;
	$term_children = get_child_taxes($current_tax,$current_slug);	

	if($term_children) {
		ob_start(); ?>
		<? foreach($term_children as $onechild){
			//	var_dump($onechild);?>
				<li><a href="<? echo get_term_link( $onechild->slug, $current_tax ); ?>"><? echo $onechild->name ?></a></li>
			<? }
		$children_output = ob_get_clean();
	}
		
	return $children_output;
}	


function adhere_admin_bar($protCaption='page') {
	
		ob_start(); 
			//	var_dump($onechild);?>
		<div class="aof_adminbar">Hey administrator - you're browsing a protected <? echo $protCaption ?>! Note that if you make any changes to this <? echo $protCaption ?>, you're potentially changing somebody else's settings.</div>

	<?	$admin_bar = ob_get_clean();
	
		
	return $admin_bar;
}



function itemsShowOverviews($items,$binder_id=null) {

	$itemindex=0;
	
	if(is_array($items)) {
		
		foreach($items as $item) {
					
			$itemindex++;
			$args = array(
				'post_type' => 		'any',
				'p'	=>	 $item->product_id,
				'suppress_filters'	=>	true
			);			
			$myitem = get_posts( $args );
			global $post;
			foreach($myitem as $post) {
				
				setup_postdata($post);
				$itemcode=$binder_id . ":" . $item->id;
				
		
				ob_start(); 
				?>

				<li id="broad_item_overview<? echo $itemcode ?>" class="tile broad_item_overview <? echo ($itemindex % 2) ? 'odd' : 'even' ?>"  rel="<? echo $itemcode ?>">
					<div class="item_image" rel="<? echo $post->ID ?>"><a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a></div>
					<div class="post_title"><a href="<? the_permalink() ?>"><? the_title() ?></a></h3>				
				</li>
			
			
			<?	} 
		$item_overviews .= ob_get_clean();
		
	}

	}

	return $item_overviews;

}



?>