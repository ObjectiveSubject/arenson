<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Arenson
 * @since Arenson 1.0
 */

get_header(); ?>

		<div id="primary" class="site-content default-single"> 
		
			<header class="page-header">
				<? echo get_subnavbar(); ?>
				<div class="centering_box">	
					<h1 class="page-title lightweight"><?php the_title(); ?></h1>
				</div>
				<hr />
			</header><!-- .entry-header -->
		
			<div id="content" class="single centering_box" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'single' ); ?> 

			<?php endwhile; // end of the loop. ?>
			
<!--
			<div class="post-navigation">
				<? 	$prev_post = get_previous_post();
						$next_post = get_next_post(); ?>
				
				<div class="nav-previous"><a href="<? echo $prev_post->guid; ?>"><? echo $prev_post->post_title; ?></a></div>
				<div class="nav-next"><a href="<? echo $next_post->guid; ?>"><? echo $next_post->post_title; ?></a></div>
			</div>
-->
					
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>