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

		<div id="primary" class="site-content default-page">
			<?php while ( have_posts() ) : the_post(); ?>

				<header class="page-header centering_box">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<hr />
				</header><!-- .page-header -->

				<div id="content" class="page centering_box" role="main"> 								
					<div class="entry-content">
						<? the_content(); ?>
					</div>
				</div><!-- #content -->

			<?php endwhile; // end of the loop. ?>
		</div><!-- #primary .site-content -->

<?php get_footer(); ?> 