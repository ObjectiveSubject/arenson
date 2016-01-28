<?php

	get_header();

	$current_tax=get_query_var( 'taxonomy' );
	$max_items_before_scrolling = 5;

	$mychildren = get_child_taxes($current_tax);

	$tax_level = get_tax_level($current_tax);
	$endterm = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

	$current_division = get_current_division();	
?>

	<div id="primary" class="site-content">
		
		<header class="page-header">
		
			<? echo get_subnavbar(); ?>
			
			<div class="centering_box">
				<h1 class="page-title"><? get_tax_title(true) ?></h1>
			</div>
			
			<? //echo get_child_products($current_tax); ?>

		</header>	

		<div id="content" class="taxlevel_<? echo $tax_level ?> product_tax" role="main">			
			
			<?php if($tax_level=='top') { //top level taxonomy so we want the hero images, slideshows, etc.?>
			
			<div class="centering_box grid-form">
	
				<? $term_children = get_child_taxes($current_tax);
				
				if ($term_children && is_array($term_children)) {
					
					$count = 1; $list_num = '';
					foreach ($term_children as $one_child) {
						if ($count % 3 == 0) { $list_num = 'third'; } 
						if ($count % 2 == 0) { $list_num .= ' even'; } ?>
					
						<div class="tile one_tax terminal_product_overview <? echo $list_num; ?>" rel="<? echo $one_child->term_id ?>">
							<div class="item_image" rel="<? echo $one_child->term_id ?>"><a href="<? echo get_term_link( $one_child->slug, $current_tax ); ?>"><img src="<? echo get_tax_overview_img($one_child->term_taxonomy_id) ?>" alt="<? echo $one_child->name ?>" /></a></div>
							<div class="post_title"><a href="<? echo get_term_link( $one_child->slug, $current_tax ) ?>"><? echo $one_child->name ?></a></div>
							<div class="post_desc prod_overview_hover" id="imgdesc<? echo $one_child->term_id ?>" ></div>
						</div>								
					<? $count++; $list_num = ''; }
				} ?>
				
			</div>
			
			<? } elseif ($tax_level=='bottom') {
		
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				//var_dump($term->slug);
				//terminal tax, so overview is different	?>
				
				<div class="centering_box terminal_collection_collector grid-form">
					<?	$args = array(
							'post_type' => 		get_division_product_type($current_division),
							'orderby'   => 'menu_order',
							'order' => 		'ASC',
							'suppress_filters' => false,
							$current_tax	=>	 $term->slug,
							'showposts'	=>		-1
						);			

						$myposts = get_posts( $args );
					
						$count = 1; $list_num = '';
						foreach($myposts as $post) {
							if ($count % 3 == 0) { $list_num = 'third'; } 
							if ($count % 2 == 0) { $list_num .= ' even'; } 
								
							setup_postdata($post); ?>

							<div class="tile one_product terminal_product_overview <? echo $list_num; ?>"  rel="<? echo $post->ID ?>">
								<div class="item_image" rel="<? echo $post->ID ?>">
									<a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a>
									<div class="post_desc prod_overview_hover" id="imgdesc<? echo $post->ID ?>" >																	
										<p>
										<? if (member_logged_in()) {
											global $post;
											$prod_id=$post->ID;
											$user_id=get_cur_user_id();
											$faveID=isFavoriteItem($prod_id,$user_id);		?>
										
											<? if ($faveID) { ?>
											<a class="binder_favorite_added fonticon_section" id="binder_removefavorite" rel="<? echo $faveID ?>" href="">Favorite</a>
											<? } else { ?>
											<a class="binder_notfavorited fonticon_section" id="binder_addfavorites" rel="<? echo $prod_id ?>" href=""></a>
											<? } ?>												
										
										<? } else { ?>
											<a class="binder_notfavorited fonticon_section notlive" id="binder_addfavorites" rel="<? echo $prod_id ?>" href="<? echo get_bloginfo('url') ?>/userlogin?msg=fave"></a>
										<? } ?>
										</p>
									</div>
								</div>
								<div class="post_title"><a href="<? the_permalink() ?>"><? the_title(); ?></a></div>
							</div>

						<? $count++; $list_num = ''; } ?>
					<div class="clearfix"></div>	

				</div>
				


			<? } else { //is midrange, so lets show the slideshow collections, etc.				

				foreach($mychildren as $onechild) {				
						
					$args = array(
							'post_type' => 		get_division_product_type($current_division),
							'orderby'   => 'menu_order',
							'order' => 		'ASC',
							'suppress_filters' => false,
							$current_tax	=>	$onechild->slug,
							'showposts'	=>	-1
						);			
							
				$collection_items = get_posts( $args );
				$binder_class = (count($collection_items)>$max_items_before_scrolling) ? 'binder_scrolling' : 'binder_nonscrolling'; 
				$binder_item_class = 'binder_items_' . count($collection_items);
				$collection_items_class = (count($collection_items)>$max_items_before_scrolling) ? 'scrollbinder' : 'centering_box_items';			
				$collection_id = 'collection_items'.$onechild->slug; ?>
	
					<div class="collection_frame <? echo $binder_class ?> <? echo $binder_item_class ?>">
					
						<div class="collection_header centering_box">
							<h2 class="collection_name"><a href="<? echo get_term_link( $onechild->slug, $current_tax ); ?>"><? echo $onechild->name ?></a></h2>&nbsp;
							<span class="viewmore"><a href="<? echo get_term_link( $onechild->slug, $current_tax ); ?>"><strong>View All</strong></a></span>
						</div>
							
							<div class="collection_items binder_items <? echo $collection_items_class ?>" id="<? echo $collection_id ?>">

								<ul class="slides slide-form">
								<? 
									$count = 1; $list_num = '';
									foreach($collection_items as $post) :

									if ($count % 3 == 0) { $list_num = 'third'; } 
									if ($count % 2 == 0) { $list_num .= ' even'; } 
									
									setup_postdata($post); ?>
									
									<li id="broad_item_overview<? echo $itemcode ?>" class="tile product_overview terminal_product_overview broad_item_overview <? echo $list_num; ?>"  rel="<? echo $itemcode ?>">
										<div class="item_image" rel="<? echo $post->ID ?>">
											<?$thumb_id = get_post_thumbnail_id();
												$thumb_url = wp_get_attachment_url($thumb_id); ?>
											<a href="<? the_permalink(); ?>">
												<img width="320" height="320" class="attachment-product_overviews" alt="<? echo trim(strip_tags( get_post_meta($thumb_id, '_wp_attachment_image_alt', true) )); ?>" data-lazy="<? echo $thumb_url; ?>" />
											</a>
											<div class="post_desc prod_overview_hover" id="imgdesc<? echo $post->ID ?>" >
												<p>	
													<?php 
														if (member_logged_in()) {
														global $post;
														$prod_id=$post->ID;
														$user_id=get_cur_user_id();
														$faveID=isFavoriteItem($prod_id,$user_id); ?>
													
														<? if($faveID) { ?>
															<a class="binder_favorite_added fonticon_section" id="binder_removefavorite" rel="<? echo $faveID ?>" href="">Favorite</a>
														<? }else { ?>
															<a class="binder_notfavorited fonticon_section" id="binder_addfavorites" rel="<? echo $prod_id ?>" href=""></a>
														<? } ?>
															
													<? } else { ?>
														<a class="binder_notfavorited fonticon_section notlive" id="binder_addfavorites" rel="<? echo $prod_id ?>" href="<? echo get_bloginfo('url') ?>/userlogin?msg=fave"></a>													
													<? } ?>
												</p>
											</div><!-- post_desc -->
										</div><!-- item_image -->
								
										<div class="post_title"><a href="<? the_permalink() ?>"><? the_title(); ?></a></div>		
									</li>
					
								<? $list_num = ''; $count++; endforeach; ?>					
								</ul>

								<div class="clearfix"></div>
							</div>
							
							<div class="item_navigators menu_horizontal" id="item_navigator_<? echo $collection_id ?>">
								<div class="clearfix"></div>
							</div>						
								
						<div class="clearfix"></div>
					</div>
			<? } ?>
		<? } ?>	

		</div><!-- #content -->
		
	</div><!-- #primary .site-content -->

<?php get_footer(); ?>