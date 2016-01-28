<?php


$associatedClient = get_post_meta($post->ID, 'storeRelatedClient', true);
checkStoreAccess($associatedClient); //naughty, you can't see other's stores!

$productsAssociated = getStoreProducts($post->ID);

//var_dump($productsAssociated);

get_header(); ?>

	<div id="primary" class="site-content single-client-store">
		<?php while ( have_posts() ) : the_post(); ?>

			<header class="page-header">
				<? echo get_subnavbar(); ?>
				<div class="centering_box">
					<h1 class="page-title"><?php the_title(); ?></h1>
					<hr />
				</div>
			</header><!-- .page-header -->

			<div id="content" class="page centering_box" role="main"> 								
				<div class="entry-content">
					<? the_content(); ?>
				</div>
				
				<div class="terminal_collection_collector grid-form">
					<?	$args = array(
							'post_type' => 		array('office_furn_products', 'arch_products', 'furn_rental_products', 'outlet_products', 'prop_products'),
							'post__in' => 		$productsAssociated,
							'showposts'	=>		-1
						);			
						$myposts = get_posts( $args );
						
						$count = 1; $list_num = '';
						foreach($myposts as $post) { setup_postdata($post);
						if ($count % 3 == 0) { $list_num = 'third'; } 
						if ($count % 2 == 0) { $list_num .= ' even'; }  ?>
	
								<div class="tile one_product terminal_product_overview <? echo $list_num; ?>"  rel="<? echo $post->ID ?>">
									<div class="item_image" rel="<? echo $post->ID ?>"><a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a></div>
									<div class="post_desc prod_overview_hover" id="imgdesc<? echo $post->ID ?>" ><!-- <p><a href="<? the_permalink() ?>"><? echo get_the_excerpt() ?></a></p> --></div>
									<div class="post_title"><a href="<? the_permalink() ?>"><? the_title(); ?></a></div>									
								</div>

						<? $list_num = ''; $count++; } ?>
					<div class="clearfix"></div>	
				</div><!-- .terminal_collection_collector -->

			</div><!-- #content -->

		<?php endwhile; // end of the loop. ?>
	</div><!-- #primary .site-content -->



<?php get_footer(); ?>