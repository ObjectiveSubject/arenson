<?php
/**
 * This is the template that displays the Services items
 *
 * @package Arenson
 * @since Arenson 1.0.9
 */

get_header(); ?>
		<!-- Using the page-projects.php template -->
		<div id="primary" class="site-content centering_box">
			<div id="content" role="main">
			<!-- Using the page-projects.php template -->
				<h1 class="page-title" ><?php the_title(); ?></h1>

				<?php
					query_posts( array( 
						'post_type' => 'projects', 
						'paged' => get_query_var('paged'),
					));
				?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content' ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>