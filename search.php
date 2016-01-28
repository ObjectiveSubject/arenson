<?php get_header(); ?>

		<div id="primary" class="site-content">

			<header class="page-header centering_box">
				<h1 class="page-title"><?php printf( __( '<span class="search_query_title">Search Results for: </span>%s', 'arenson' ), get_search_query() ); ?></h1>
				<hr />
			</header>

			<div id="content" class="centering_box" role="main">

			<?php if ( have_posts() ) : ?>

				<div class="search_filter">
					<? if(count($results_terms)>0) {	?>
						<ul>
						<?	foreach($results_terms as $ter) {	?>				
							<li class="<? echo $ter->taxonomy ?>"><a href="<?php echo str_replace( '%7E', '~', $_SERVER['PHP_SELF']); ?>?s=<? echo get_search_query() ?>&tx=<? echo $ter->taxonomy ?>&tn=<?echo $ter->slug ?>"><? echo $ter->name ?></a></li>							
						<? } ?>
						</ul>
					<? } ?>
				
				</div>
				
				<div class="searchresults grid-form">

					<?php $count = 1; $list_num = ''; ?>
					<?php while ( have_posts() ) : the_post();
						if ($count % 3 == 0) { $list_num = 'third'; } 
						if ($count % 2 == 0) { $list_num .= ' even'; }
					
						$item = false;
						$feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , 'product_overviews');
						$has_feat = ($feat_img != null);
						$feat_img_src = ($feat_img != null) ? reset($feat_img) : get_bloginfo('template_url') . '/images/search_default.jpg';
						$post_terms = get_product_breadcrumb(true);
						if(!empty($post_terms)) {
								$post_terms = array_reverse($post_terms);	
								$item = get_term_by( 'id', reset($post_terms), 'p_cat');
							}
						?>
						
						<div class="tile result one_product terminal_product_overview <? if(!$has_feat) echo 'no_image' ?> <? echo $list_num; ?>">
							<div class="item_image">
								<a title="See more about <? the_title() ?>" href="<? echo get_permalink() ?>"><img src="<? echo $feat_img_src ?>" alt="<? the_title() ?>"  alt="Click to see more about <? the_title() ?>" /></a>							
							</div>
							<div class="post_title">
								<a title="See more about <? the_title() ?>" href="<? echo get_permalink() ?>"><? the_title() ?></a>
							</div>
							<? if($item) { ?>
								<div class="product_division division_<? echo $item->slug; ?>"><span class="icon"></span> <? echo $item->name; ?></div>
							<? } ?>
						</div>
						
						
					<?php $list_num = ''; $count++; endwhile; ?>
					
					<div class="clearfix"></div>

					<?php arenson_content_nav( 'nav-below' ); ?>

					<?php else : ?>
						
						<div class="entry-content">
							<h3>Sorry, but nothing was found.</h3>
							<?php get_search_form(); ?>
						</div>

					<?php endif; ?>
					
				</div>

			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>