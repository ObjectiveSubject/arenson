<? 
//	global $post;
//	$hellothere = get_the_excerpt();
	


	

/*

// Create a list of all the term's parents
$parent = $term->parent;
while ($parent) {
$parents[] = $parent;

$parent = $new_parent->parent;
}
if(!empty($parents)) {
$parents = array_reverse($parents);
	} */
	
//	createAOF_PDF($post->post_content) ?>

<?php get_header(); ?>
	
		<div id="primary" class="site-content single-product">

			<header class="page-header with-slides">
			
				<?php echo get_subnavbar(); ?>

				<? // Slideshow or Hero Image
				$args = array(
					'id' => 'product-hero-slides',
					'class' => '',
					'image_size' => 'product_images',
					'full_bleed' => false,
				);
				echo get_hero_slides($args); ?>
				
				<div class="centering_box">
					<h1 class="page-title"><?php the_title(); ?></h1>
				</div>				
							
				<div class="user_product_interaction  centering_box">
					<? echo get_productbar(); ?>
					
						<div class="fancybox_container">
							<div id="fb_binder_add">
								<? echo get_binder_add_form(); ?>
							</div>							
							
							<div id="fb_binder_request">
								<? //echo get_product_request_form() ?>
							</div>
						</div>

				</div>
			</header><!-- .page-header -->

			<div id="content" class="single centering_box" role="main">

			<?php while ( have_posts() ) : the_post();
			$productSubheader = get_post_meta($post->ID, 'productSubheader', true); ?>				
				
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						
				<div class="page-content">
				
					<div class="product_col">
						<h3><?php	echo $productSubheader; ?></h3>
						<?php the_content(); ?>
					</div>				
					
					<div class="product_metadata">
					
					<div class="meta_mod">
						<? echo get_productshare(); ?>
						<? echo get_socialshare(); ?>
					</div>					
					
					<div class="meta_mod">
						<? global $product_fields;
						foreach($product_fields as $field_value => $explanation ) {
							$metadata = getpostmeta_formatted($post->ID, $field_value, true);

							if($metadata) { ?>
								<div class="expand_module">
									<h4 class="expand_title" ><a href="" rel="<? echo $field_value ?>"><? echo $explanation ?></a></h4>
									<div class="field_value" id="<? echo $field_value ?>">
										<p><? 
											//var_dump(strpos($metadata, 'a:1:{'));
											if(strpos($metadata, ':1:{i:0'))
												echo 'Yes';
											elseif(!is_array($metadata))
												echo $metadata;
											else
												echo 'Yes';
												
												?>
											</p>
									</div>
								</div>
							<? }
						} ?>
					</div>
					
					<? $all_product_tags = get_the_term_list( $post->ID, 'p_tag', '<li>', '</li><li>', '</li>' ); 
						
						if($all_product_tags) { ?>	
							<div class="meta_mod">
								<h3>Tags</h3>
								<div class="product_tags"><?php echo $all_product_tags ?></div>
							</div>
						<? } ?>
					
				</div>				
					
					<div class="clearfix"></div>
					
					
					<div class="related_content">
				<?	$related_content=array(get_post_meta($post->ID, 'productRelatedContent1', true),get_post_meta($post->ID, 'productRelatedContent2', true));
					$i=0;								
					foreach($related_content as $content){
					$i++;
					if(!$content)
						continue; ?>
					
						<? $temp_query = $wp_query; 
						$args = array(
							'post_type' => 		'content',
							'p' =>		$content,
						);

						$related_post = get_posts( $args );
						
							foreach($related_post as $post) {
								global $post;
								setup_postdata($post); ?>											
								<div class="content_mod" id="content_mod<? echo $i ?>">
									
										<h3><a href="<?php the_permalink(); ?>"><? the_title() ?></a></h3>
									<a href="<?php the_permalink(); ?>"><? the_post_thumbnail('related_content'); ?></a>
									
								</div>
						<? } wp_reset_postdata();	?>								
					<? } ?>
				
					<div class="clearfix"></div> 
				</div>
					
				</div><!-- .page-content -->
				
			</article><!-- #post-<?php the_ID(); ?> -->		

			<?php endwhile; ?>
					
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

<?php get_footer(); ?>