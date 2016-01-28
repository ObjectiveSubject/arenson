<?php
/**
 * Template Name: News
 *
 * This is the template that displays the most recent posts as news items
 *
 * @package Arenson
 * @since Arenson 1.0.7
 */

get_header(); ?>

		<div id="primary" class="site-content news-page">
			<div id="content" class="news" role="main">

				<div class="centering_box">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</div>
		

				<div class="metaContentBlackBar">
					<div class="centering_box columnize_listing">
							<ul id="cat-list">
								<?php 
								$args = array(
									'orderby' => 'count',
									'order' => 'ASC',
									'hide_empty' => 1,
									'use_desc_for_title' => 0
								);
								$cats = get_categories($args);
								//dump($cats);
								$count = 1; $list_num = '';
								foreach ($cats as $cat) :
								if ($count % 3 == 0) { $list_num = 'third'; } 
								if ($count % 2 == 0) { $list_num .= ' even'; }  ?>
								
									<li class="category <? echo $list_num; ?>"><a href="/category/<? echo $cat->slug; ?>"><? echo $cat->name; ?></a></li>
								<? $list_num = ''; $count++; endforeach; ?> 
							</ul>
					<div class="clearfix"></div>
					</div>
				</div>
			
				
				<div class="centering_box news_posts">
					<?php
						query_posts( array( 
							'post_type' => 'post', 
							'paged' => get_query_var('paged'),
						));
					?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content' ); ?>

					<?php endwhile; // end of the loop. ?>
				
					<?php arenson_content_nav('news-navigation'); ?>
					
				</div>

			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>