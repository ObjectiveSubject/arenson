<?php

	get_header();

 ?>

		<div id="primary" class="site-content">
		
		<div id="content" class="taxlevel_<?echo $tax_level ?> product_tax" role="main">
			
			<div class="centering_box taxonomy_header_results">
				<h3>News results for:</h3>
				<h1><? echo single_tag_title( '', false )  ?></h1>
			</div>
			
		<?	global $query_string;
			query_posts( $query_string . '&posts_per_page=-1' ); 	?>
				
				<div class="centering_box terminal_collection_collector">
					<?	if (have_posts()) : 
					
							$count = 1; $list_num = '';
							while (have_posts()) : the_post();
							if ($count % 3 == 0) { $list_num = 'third'; } 
							if ($count % 2 == 0) { $list_num .= ' even'; } ?>

								<div class="one_product tag_overview terminal_product_overview <? echo $list_num; ?>"  rel="<? echo $post->ID ?>">
									
									<div class="item_image" rel="<? echo $post->ID ?>"><a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a></div>
									<div class="post_desc prod_overview_hover" id="imgdesc<? echo $post->ID ?>" >
										
									</div>
									<div class="post_title "><a class="" href="<? the_permalink() ?>"><? the_title(); ?></a></div>
								</div>

							
				<?php $list_num = ''; $count++; endwhile; endif; ?>
					<div class="clearfix"></div>	
				</div>

				
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php// get_sidebar(); ?>
<?php get_footer(); ?>