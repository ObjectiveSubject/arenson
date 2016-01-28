<?php
 
// ================================================
// Template for Division Overviews
// ================================================



get_header(); ?>

		<div id="primary" class="site-content single-division">
		
			<?php 
			$current_slug = the_slug();
			$current_tax= 'p_cat';
			$term = get_term_by( 'slug', $current_slug, $current_tax);
			$term_array = array('hide_empty' => 0);
			//var_dump(get_terms('p_cat', $term_array));
			
			while (have_posts()) : the_post(); ?>
			
			<header class="page-header with-slides">
				
				<?php if (get_field('hero_choice') == 'slides') :
								
					$args = array(
				 		'id' 					=> 'division_slides',
				 		'class' 			=> 'division_slides',
				 		'image_size' 	=> 'hero_slideshow',
				 		'full_bleed' 	=> true,
				 		'with_fade' 	=> true,
				 		'slides' => get_field('slides'),
				 	);
				 	
				 	echo get_hero_slides($args); ?>

				<?php else : ?>

					<div id="hero-image" class="centering_box">
						<?php echo wp_get_attachment_image(get_field('hero_image'), 'full'); ?>
					</div>

				<?php endif; ?>
			
			
				<div id="div-sub-nav" class="closed">
					<div class="centering_box">
					
						<?php 
						$division_slug = get_field('division');
						$product_post_type;
						switch ($division_slug) {
							case 'div-office-furnishings':
						    $product_post_type = 'office_furn_products';
						    $feat_idea = get_field('office_furn_feat_idea');
						    $idea_post_type = 'office_idea_overview';
						    $service_post_type = 'office_service';
						    break;
						
						  case 'div-architectural-products':
						    $product_post_type = 'arch_products';
						    $feat_idea = get_field('arch_prod_feat_idea');
						    $idea_post_type = 'arch_idea_overview';
						    $service_post_type = 'arch_service';
						    break;
						
						  case 'div-rental':
						    $product_post_type = 'furn_rental_products';
						    $feat_idea = get_field('furn_rental_idea');
						    $idea_post_type = 'rental_idea_overview';
						    $service_post_type = 'rental_service';
						    break;

						  case 'div-props':
						    $product_post_type = 'prop_products';
						    $feat_idea = get_field('prop_rental_feat_idea');
						    $idea_post_type = 'prop_idea_overview';
						    $service_post_type = 'prop_service';
						    break;

						  case 'div-outlet':
						    $product_post_type = 'outlet_products';
						    $feat_idea = get_field('outlet_feat_idea');
						    $idea_post_type = 'outlet_idea_overview';
						    $service_post_type = 'outlet_service';
						    break;
						
						  default:
						    break;			
						}
						?>

						<?php // Column 1 ------------------------------------- ?>
						<div class="div-related col1">
							<h5 class="title toggle-btn"><?php the_field('col1_title'); ?></h5>
							<p class="desc"><?php the_field('col1_desc'); ?></p>
							<div class="content">
							
								<?php if (get_field('col1_feat_item_image') || get_field('col1_feat_item_title')) : ?>
								
								<div class="featured-item featured-service">
									<?php if (get_field('col1_feat_item_image')) : $col1_image = get_field('col1_feat_item_image'); ?>
									<div class="feat-item-image">
										<a href="<? the_field('col1_feat_item_url'); ?>"><?php echo wp_get_attachment_image($col1_image, 'product_overviews'); ?></a>
									</div>
									<?php endif; ?>
									<?php if (get_field('col1_feat_item_title')) : ?>
									<div class="feat-item-title"><a href="<? the_field('col1_feat_item_url'); ?>"><?php the_field('col1_feat_item_title'); ?></a></div>
									<?php endif; ?>
									<?php if (get_field('col1_feat_item_desc')) : ?><div class="feat-item-desc"><?php the_field('col1_feat_item_desc'); ?></div><?php endif; ?>
								</div>
								
								<?php endif; ?>

								<?php if(get_field('col1_display')) {
									
									if ( in_array('services', get_field('col1_display'))) { ?>
										<ul class="services">
											<?php	$args = array( 'post_type'=> $service_post_type );
											$services = new WP_Query($args);
											while ($services->have_posts()) : $services->the_post(); ?>
												<li class="service"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumb', array('class'=>'feat-image')); echo ' '.get_the_title(); ?></a></li>
											<?php endwhile; wp_reset_query(); ?>
										</ul>
									<?php } ?>
									
									<?php if ( in_array('text', get_field('col1_display')) ) { ?>
										<div class="col-text"><?php the_field('col1_text'); ?></div>
									<?php } ?>
								
								<?php } ?>
							</div>
						</div>
						
						
						<?php // Column 2 ------------------------------------- ?>
						<div class="div-related col2">
							<h5 class="title toggle-btn"><?php the_field('col2_title'); ?></h5>
							<p class="desc"><?php the_field('col2_desc'); ?></p>
							<div class="content">
							
								<?php if (get_field('col2_feat_item_image') || get_field('col2_feat_item_title')) : ?>
								
								<div class="featured-item featured-idea">
									<?php if (get_field('col2_feat_item_image')) : $col2_image = get_field('col2_feat_item_image'); ?>
									<div class="feat-item-image">
										<a href="<? the_field('col2_feat_item_url'); ?>"><?php echo wp_get_attachment_image($col2_image, 'product_overviews'); ?></a>
									</div>
									<?php endif; ?>
									<div class="feat-item-title"><a href="<? the_field('col2_feat_item_url'); ?>"><?php the_field('col2_feat_item_title'); ?></a></div>
									<?php if (get_field('col2_feat_item_desc')) : ?><div class="feat-item-desc"><?php the_field('col2_feat_item_desc'); ?></div><?php endif; ?>
								</div>
								
								<?php endif; ?>

								<?php if (get_field('col2_display')) : ?>
									<?php if ( in_array('ideas', get_field('col2_display'))) { ?>
										<ul class="ideas">
										<?php $args = array( 'post_type' => $idea_post_type ); 
										$ideas = new WP_Query($args);	
										while ($ideas->have_posts()) : $ideas->the_post(); ?>									
											<li class="idea"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumb', array('class'=>'feat-image')); echo ' '.get_the_title(); ?></a></li>
										<?php endwhile; wp_reset_query(); ?>
										</ul>		
									<?php } if ( in_array('text', get_field('col2_display')) ) { ?>
										<div class="col-text">
										<?php the_field('col2_text'); ?>
										</div>
									<?php } ?>
								<?php endif; ?>
							</div>
						</div>


						<?php // Column 3 ------------------------------------- ?>
						<div class="div-related col3">
							<h5 class="title toggle-btn"><?php the_field('col3_title'); ?></h5>
							<p class="desc"><?php the_field('projects_desc'); ?></p>
							<div class="content">
							
								<?php if (get_field('col3_feat_item_image') || get_field('col3_feat_item_title')) : ?>
								
								<div class="featured-item featured-project">
									<?php if (get_field('col3_feat_item_image')) : $col3_image = get_field('col3_feat_item_image'); ?>
									<div class="feat-item-image">
										<a href="<? the_field('col3_feat_item_url'); ?>"><?php echo wp_get_attachment_image($col3_image, 'product_overviews'); ?></a>
									</div>
									<?php endif; ?>
									<div class="feat-item-title"><a href="<? the_field('col3_feat_item_url'); ?>"><?php the_field('col3_feat_item_title'); ?></a></div>
									<?php if (get_field('col3_feat_item_desc')) : ?><div class="feat-item-desc"><?php the_field('col3_feat_item_desc'); ?></div><?php endif; ?>
								</div>
								
								<?php endif; ?>
								
								<?php if ( get_field('col3_text') ) { ?>
									<div class="col-text">
									<?php the_field('col3_text'); ?>
									</div>
									
								<?php } ?>
							</div>
						</div>
						
						
						<?php // Column 4 --------------------------------------- ?>
						<div class="div-related col4">
							<h5 class="title toggle-btn"><?php the_field('col4_title'); ?></h5>
							<p class="desc"><?php the_field('videos_desc'); ?></p>
							<div class="content">
								<? if (get_field('video_links')) :
									$videos = explode('<br />', get_field('video_links'));
									foreach ($videos as $video) : ?>
								<div class="video"><? echo html_entity_decode($video); ?></div>
								<? endforeach; endif; ?>

								<?php if ( get_field('col4_text') ) { ?>
									<div class="col-text"><?php the_field('col4_text'); ?></div>									
								<?php } ?>

							</div>
						</div>


					</div>
					<a href="#" class="close-btn icon icon-ar_close"></a>
				</div><!-- #div-sub-nav -->
				
			</header><!-- .page-header -->
			
			<div id="content" class="single single-content centering_box" role="main">

				<div class="page-content">

					<div class="division-text"><?php the_content() ?></div>
	
					<?php	if($term) {
						$cur_term=$term->term_id;
						$mychildren = get_child_taxes($current_tax,$cur_term); ?>						
						
						<div class="terminal_collection_collector grid-form">
							<?php	
							$count = 1; $list_num = '';
							foreach($mychildren as $onechild) :
							if ($count % 3 == 0) { $list_num = 'third'; } 
							if ($count % 2 == 0) { $list_num .= ' even'; } 
					
							$img_id = tip_plugin_get_terms($onechild->term_taxonomy_id);
							$termlink = get_term_link( $onechild->slug, $current_tax ); ?>										
					
							<div class="tile one_product terminal_product_overview <?php echo $list_num; ?>"  rel="<?php echo $onechild->term_taxonomy_id ?>">
								<div class="item_image" rel="<?php echo $post->ID ?>"><a href="<?php echo $termlink ?>"><?php echo wp_get_attachment_image( $img_id, 'product_overviews' ); ?></a></div>
								<div class="post_desc prod_overview_hover" id="imgdesc<?php echo $onechild->term_taxonomy_id ?>" ></div>
								<div class="post_title"><a href="<?php echo $termlink ?>"><?php echo $onechild->name ?></a></div>
								<div class="clearfix"></div>
							</div>
					
							<?php	$count++; $list_num = ''; endforeach; ?> 
							<div class="clearfix"></div>	
						</div>										
					
					<?php } ?>
				
				</div><!-- .page-content -->
					
			</div><!-- #content -->
			
			<?php endwhile; ?>
		</div><!-- #primary .site-content -->



<?php get_footer(); d?>