<?php
/**
 * @package Arenson
 * @since Arenson 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="meta-group">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta auth-date">
			<?php arenson_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
			
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'arenson' ) );
				if ( $categories_list && arenson_categorized_blog() ) :
			?>
			<span class="entry-meta cat-links">
				<?php printf( __( 'Posted in %1$s', 'arenson' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ' ', 'arenson' ) );
				if ( $tags_list ) :
			?>
			<span class="entry-meta tag-links">
				<?php the_tags( '', '<br />', '<br />' ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
		
		<div class="entry-meta sharing">
				<?php if(function_exists('kc_add_social_share')) kc_add_social_share(); ?>
		</div>
	</div><!-- .entry-meta -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<div class="clearfix"></div>

</article><!-- #post-<?php the_ID(); ?> -->
