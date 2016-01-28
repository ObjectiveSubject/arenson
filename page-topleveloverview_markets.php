<?php
/*
Template Name: Top level Markets
*/
?>
 
<?php get_header(); ?>

		<div id="primary" class="site-content overviewpage">
			
			<header class="page-header centering_box">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<? echo get_black_bar_intro(get_the_content()); ?>
			</header><!-- .entry-header -->


			<div id="content" class="page centering_box" role="main"> 

				<div class="page-content">
					<div class="grid-form">
						<?	
						global $toplevel_overviews;
						$current_tax = $toplevel_overviews[the_slug()];
		
						$args = array(
							'post_type' => 	$current_tax,
							'suppress_filters' => false,
							'showposts'	=>		-1
						);			
	
						$myposts = get_posts( $args );
	
						$count = 1; $list_num = '';
						foreach($myposts as $post) {
							if ($count % 3 == 0) { $list_num = 'third'; } 
							if ($count % 2 == 0) { $list_num .= ' even'; } 
								
							setup_postdata($post); ?>
							
							<div class="tile toplevel_item <? echo $list_num; ?>">
								<div class="item_image" rel="<? echo $one_child->term_id; ?>"><a href="<? the_permalink(); ?>"><? the_post_thumbnail('full'); ?></a></div>
								<div class="post_desc prod_overview_hover" id="imgdesc<? echo $one_child->term_id; ?>" >
									<p><a href="<? the_permalink(); ?>"></a></p>
								</div>
								<h2 class="post_title"><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h2>
								
							</div>
	
							<? $list_num = ''; $count++; } ?>
						
						<div class="clearfix"></div>
					</div><!-- .entry-content -->
				</div>

			</div><!-- #content -->
		</div><!-- #primary .site-content -->


<?php get_footer(); ?> 