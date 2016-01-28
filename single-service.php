<?php 


get_header(); ?>

		<div id="primary" class="site-content single-service">

			<?php while ( have_posts() ) : the_post(); 

			// Slideshow or Hero Image --------------------------------------
			if (get_field('slides')) { 
				$slides = get_field('slides');
				//dump($slides);
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

				<div class="entry-content"><?php the_content(); ?> </div>
					
			</div><!-- #content -->
			
			<?php endwhile; // end of the loop. ?>
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>