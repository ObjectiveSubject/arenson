<?php
/**
 * Template Name: Home
 *
 * @package Arenson
 * @since Arenson 1.0.3
 */

get_header(); ?>

		<div id="primary" class="site-content">
			<div id="content" role="main">
			
			
				<?php 
				$args = array('pagename'=>'home');
				$homepage = new WP_Query($args);
				while ($homepage->have_posts()) : $homepage->the_post(); ?>

			
				<article <?php post_class(); ?>>
					<div class="hero centering_box">						
						<ul class="slides">
												
							<?php while(have_rows('divisions')) : the_row();
							$division = get_sub_field('division_link'); ?>					
							
							<li class="slide" style="background-image: url(<?php the_sub_field('division_image'); ?>)">
								<div class="info">
									<a href="<?php echo $division->guid; ?>" class="icon" data-icon="&#x<?php the_sub_field('division_icon'); ?>;"></a>
									<h3 class="slide-title lightweight"><a href="<?php echo $division->guid; ?>"><?php the_sub_field('division_title'); ?></a></h3>
									<div class="slide-text">
										<?php the_sub_field('division_text'); ?>
									</div>
								</div>
							</li>
							
							<?php endwhile; ?>
		
						</ul>
					</div> <!-- .hero -->
					
					<div class="features centering_box">
						<ul class="clear">

							<?php 
							$count;							
							while(have_rows('home_features')) : the_row();
							$count++;
							$feat_link_type = get_sub_field('feat_link_to');
							if ($feat_link_type === 'collection') {
								$feat_link = get_term_link(get_sub_field('collection_link'));
							} elseif ($feat_link_type === 'post_page') {
								$feat_link = get_sub_field('post_page_link');
							}
							?>
							
							<li class="feature feature-<?php echo $count; ?>">
								<div class="img">
									<a href="<?php echo $feat_link; ?>"><?php echo wp_get_attachment_image(get_sub_field('feat_image'), 'full'); ?></a>
								</div>
								<div class="text">
									<h3 class="feature-title"><a href="<?php echo $feat_link; ?>"><?php the_sub_field('feat_title'); ?></a></h3>
									<?php the_sub_field('feat_content'); ?>
								</div>
							</li>
							
							<?php endwhile; ?>							
		
						</ul>
					</div> <!-- .features -->
					
				</article>


			<?php endwhile; ?>
			
			
			</div><!-- #content -->
		</div><!-- #primary .site-content -->	

		

<?php get_footer(); ?>

