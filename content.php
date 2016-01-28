<?php
/**
 * @package Arenson
 * @since Arenson 1.0
 */

if ($count == 1) $first = 'first-post';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($first); ?>>
	
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'arenson' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

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
		<div class="clearfix"></div>
	</header><!-- .entry-header -->


	<?php $post_type_excerpts = array( 'projects', 'markets', 'services' ); ?>

	<?php if ( is_search() || in_array( get_post_type(), $post_type_excerpts ) || is_page('news')) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'arenson' ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	
	
	
	<footer class="entry-meta comments">

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="sep"> | </span>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'arenson' ), __( '1 Comment', 'arenson' ), __( '% Comments', 'arenson' ) ); ?></span>
		<?php endif; ?>

	</footer><!-- #entry-meta -->
	
	<div class="clearfix"></div>
	
	
</article><!-- #post-<?php the_ID(); ?> -->
