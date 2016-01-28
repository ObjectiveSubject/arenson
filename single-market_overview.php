<?php

get_header(); ?>

		<div id="primary" class="site-content single-market">
			
			<?
			// Slideshow or Hero Image --------------------------------------
			if (get_field('slides', $post->ID)) { 
				$slides = get_field('slides');
				if ($slides[0][slide_image] == null) { 
					$slides = false;
				} else { $slides = get_field('slides', $post->ID); }
			} else { 
				$slides = false; 
			}

			$args = array(
				'id' => 'market-hero-slides',
				'class' => '',
				'image_size' => 'hero_slideshow',
				'full_bleed' => true,
				'with_fade' => true,
				'slides' => $slides	
			);
			$hero_slides = get_hero_slides($args); ?>
			
			<header class="page-header <? echo ($hero_slides) ? 'with-slides' : 'no-slides'; ?>">
			
				<? echo get_subnavbar(); ?>

				<? if ($hero_slides) { 
					echo $hero_slides;
					if (!$slides[0][slide_large_text] && !$slides[0][slide_small_text]) { ?>
					<div class="overlay-text">
						<div class="centering_box">
							<h1 class="large-text"><?php the_title(); ?></h1>
						</div>
					</div> 
					<? } else { ?>
						<div class="centering_box">
							<h1 class="page-title"><?php the_title(); ?></h1>
							<hr />
						</div>
					<? } ?>
				<? } else { ?>
					<div class="centering_box">
						<h1 class="page-title"><?php the_title(); ?></h1>
						<hr />
					</div>	
				<? } ?>

			</header><!-- .entry-header -->
			
			
			
			
			<div id="content" class="single centering_box" role="main">
			
				<?php if ($post->post_content) : ?>
					<div class="entry-content"><?php echo $post->post_content; ?></div>
				<? endif; ?>

				<?
					$current_slug = the_slug();
					$current_tax= 'markets';
					$term = get_term_by( 'slug', $current_slug, $current_tax);
					
					if($term) {
						$cur_term=$term->term_id;
						$mychildren = get_child_taxes($current_tax,$cur_term); ?>
						
						<? //echo get_child_products($current_tax,$cur_term); ?>
						
						
						<div class=" terminal_collection_collector grid-form">
							<? 
							$count = 1; $list_num = '';
							foreach($mychildren as $onechild) {
							if ($count % 3 == 0) { $list_num = 'third'; } 
							if ($count % 2 == 0) { $list_num .= ' even'; } 
							
							$img_id = tip_plugin_get_terms($onechild->term_taxonomy_id);
							$termlink = get_term_link( $onechild->slug, $current_tax ); ?>										

								<div class="tile one_product terminal_product_overview <? echo $list_num; ?>"  rel="<? echo $onechild->term_taxonomy_id ?>">
									<div class="item_image" rel="<? echo $post->ID ?>"><a href="<? echo $termlink ?>"><? echo wp_get_attachment_image( $img_id, 'product_overviews' ); ?></a></div>
									<div class="post_desc prod_overview_hover" id="imgdesc<? echo $onechild->term_taxonomy_id ?>" >
										
									</div>
									<div class="post_title"><a href="<? echo $termlink ?>"><? echo $onechild->name ?></a></div>
									
									<div class="clearfix"></div>
								</div>
								
								<? $list_num = ''; $count++; } ?> 

							<div class="clearfix"></div>	
						</div>										
					
					<? } ?>					
					
			</div><!-- #content -->
		</div><!-- #primary .site-content -->



<?php get_footer(); ?>