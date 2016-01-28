<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Arenson
 * @since Arenson 1.0
 */

get_header(); ?>

		<div id="primary" class="site-content single-project"> 
		
			<?php while ( have_posts() ) : the_post();

			// Slideshow or Hero Image --------------------------------------
			if (get_field('slides')) { $slides = get_field('slides'); } else { $slides = false; }
			$args = array(
					'id' => 'project-hero-slides',
					'class' => '',
					'image_size' => 'product_images',
					'full_bleed' => false,
					'with_fade' => false,
					'slides' => $slides
			);
			$hero_slides = get_hero_slides($args); ?>
			
			<header class="page-header <? echo ($hero_slides) ? 'with-slides' : 'no-slides'; ?>">
				
				<? echo ($hero_slides) ? $hero_slides : null; ?>
				
				<div class="centering_box">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<hr />
				</div>
			</header><!-- .entry-header -->
		
			<div id="content" class="single centering_box" role="main">

				<div class="entry-content"><? the_content(); ?></div> 
					
			</div><!-- #content -->
			
			<?php endwhile; // end of the loop. ?>
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>