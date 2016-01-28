<?php

	get_header();

 ?>

		<div id="primary" class="site-content">
		
			<header class="page-header">
				<div class="centering_box">
					<h1 class="page-title"><span class="search_query_title">Product Tag: </span><? get_tax_title(true) ?></h1>
				</div>
			</header>	

		<div id="content" class="taxlevel_<?echo $tax_level ?> product_tax" role="main">
						
		<?	global $query_string;
			query_posts( $query_string . '&posts_per_page=-1' ); 	?>
				
				<div class="centering_box terminal_collection_collector grid-form">
					<?	if (have_posts()) : 
					
							$count = 1; $list_num = '';
							while (have_posts()) : the_post();
							if ($count % 3 == 0) { $list_num = 'third'; } 
							if ($count % 2 == 0) { $list_num .= ' even'; } ?> 

								<div class="tile one_product terminal_product_overview <? echo $list_num; ?>"  rel="<? echo $post->ID ?>">
									<div class="item_image" rel="<? echo $post->ID ?>">
										<a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a>
										<div class="post_desc prod_overview_hover" id="imgdesc<? echo $post->ID ?>" >
											<p class="excerpt"><a href="<? the_permalink() ?>"><? echo get_the_hover_excerpt() ?></a></p>
											
											<? if(member_logged_in()) {
													global $post;
													$prod_id = $post->ID;
													$user_id = get_cur_user_id();
													$faveID = isFavoriteItem($prod_id,$user_id); ?>
												<p>	
													<? if($faveID) { ?>
														<a class="binder_favorite_added fonticon_section" id="binder_removefavorite" rel="<? echo $faveID ?>" href="">Favorite</a>
													<? } else { ?>
														<a class="binder_notfavorited fonticon_section" id="binder_addfavorites" rel="<? echo $prod_id ?>" href=""></a>
													<? } ?>
												</p>
											<? } ?>
										</div>									
									</div>
									<div class="post_title"><a href="<? the_permalink() ?>"><? the_title(); ?></a></div>
								</div>

							
				<?php $count++; $list_num = ''; endwhile; endif; ?>
					<div class="clearfix"></div>	
				</div>

				
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php// get_sidebar(); ?>
<?php get_footer(); ?>