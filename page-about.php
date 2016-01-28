<?php
/**
 * The template for displaying all pages.
 * 
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Arenson 
 * @since Arenson 1.0
 */
 
get_header(); ?>

		<div id="primary" class="site-content">
			<?php while ( have_posts() ) : the_post(); ?>
		
			<header class="page-header with-slides">

				<?php // Slideshow or hero image ----------------------------------
				
				if (get_field('hero_choice') == 'slides') : 

					$args = array(
				 		'id' 					=> 'about_slides',
				 		'class' 			=> 'about_slides',
				 		'image_size' 	=> 'hero_slideshow',
				 		'full_bleed' 	=> true,
				 		'with_fade' 	=> true,
				 		'slides' => get_field('slides'),
				 	);
				 	
				 	echo get_hero_slides($args);

				else : ?>

					<div id="hero-image" class="centering_box">
						<?php echo wp_get_attachment_image(get_field('hero_image'), 'full'); ?>
					</div>

				<?php endif; ?>

				<?php // Blackbar Links --------------------------------------
				if (have_rows('blackbar_links')) : ?>
				<div class="blackbar-links">
					<ul class="centering_box">
						<?php while (have_rows('blackbar_links')) : the_row(); ?>
						<li><a href="<?php the_sub_field('blackbar_link_url'); ?>"><?php the_sub_field('blackbar_link_name'); ?></a></li>
						<?php endwhile; ?>
					</ul>
				</div>
				<?php endif; ?>

			</header><!-- .entry-header -->				

		
			<div id="content" class="page centering_box" role="main"> 
								
				<div class="page-content">
						<?php the_content(); ?>
				</div>

			</div><!-- #content -->
			
			
			<?php endwhile; // end of the loop. ?>
		</div><!-- #primary .site-content -->

<?php get_footer(); ?> 