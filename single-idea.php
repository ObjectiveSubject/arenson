<?php 


get_header(); ?>

		<div id="primary" class="site-content single-idea">
		
			<?php while ( have_posts() ) : the_post();
			
			// Slideshow or Hero Image --------------------------------------
			if (get_field('slides')) { 
				$slides = get_field('slides');
				if ($slides[0][slide_image] == null) { $slides = false;
				} else { $slides = get_field('slides'); }
			} else { 
				$slides = false; 
			}

			$args = array(
				'id' => 'idea-hero-slides',
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
					<hr/>
				<? endif; ?>
				
				<? 	$current_division = get_current_division();
						$current_idea = str_replace('-', '_', $current_division.'_ideas');
						$current_idea_slug = $post->post_name.'-'.$current_division; ?>
				
				<div class="terminal_collection_collector grid-form">
					<?	$args = array(
							'post_type' => 		'any',
							'orderby'   => 'menu_order',
							'order' => 		'ASC',
							'suppress_filters' => false,
							$current_idea	=>	 $current_idea_slug,
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

						<? $list_num = ''; $count++; } ?>
				</div> 
					
			</div><!-- #content -->
			<?php endwhile; // end of the loop. ?>
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>