<?php
/**
 * Arenson functions and definitions
 *
 * @package Arenson
 * @since Arenson 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Arenson 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 800; /* pixels */

/**
 * Remove cruft from the WordPress header
 *
 * @since Arenson 1.0.2
 */
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function get_the_content_formatted ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
$content = get_the_content($more_link_text, $stripteaser, $more_file);
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]>', $content);
return $content;
}

function getpostmeta_formatted($postid, $metakey) {
	global $wpdb;
	$postmeta_table = $wpdb->get_blog_prefix() . "postmeta";
	$myquery = "SELECT CONVERT(meta_value USING utf8) FROM $postmeta_table where meta_key='$metakey' AND post_id='$postid' LIMIT 1";
	$myresult = $wpdb->get_var($myquery);
	return nl2br($myresult);

}

if ( ! function_exists( 'arenson_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Arenson 1.0
 */
function arenson_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/functions/template-tags.php' );
	
	/**
	 * Custom post types for this theme.
	 */
	//require( get_template_directory() . '/functions/post-types.php' );

	/**
	 * Tweaks to the WordPress admin area.
	 */
	require( get_template_directory() . '/functions/admin.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/functions/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/functions/theme-options/theme-options.php' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'main-navigation' => __( 'Main Navigation', 'arenson' ),
	) );
}
endif; // arenson_setup
add_action( 'after_setup_theme', 'arenson_setup' );


/* Alter Main Query */
function alter_query( $query ) {
    if ( $query->is_search() ) {
        $query->set( 'posts_per_page', 30 );
    }
}
add_action( 'pre_get_posts', 'alter_query' );



/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Arenson 1.0
 */
function arenson_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'arenson' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
// add_action( 'widgets_init', 'arenson_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function arenson_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );

}
add_action( 'wp_enqueue_scripts', 'arenson_scripts' );

/**
 * Make read more link to article rather than #more
 *
 * @since Arenson 1.0.4
 */
function remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
		}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
		}
	return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');

/**
 * Enqueue javascript
 *
 * @since Arenson 1.0.9
 */
function enqueue_js() {
  // register your script location, dependencies and version
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery-1.11.1.min.js', false, '1.7.2', false);
	wp_register_script('jquery_migrate', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.min.js', array('jquery'), '', false);
  wp_register_script('slick', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.0', true );
  wp_register_script('core', get_template_directory_uri() . '/js/core.min.js', array('jquery'), '1.0', true );
  
  // enqueue the script
  wp_enqueue_script('jquery_migrate');
  wp_enqueue_script('slick');
  wp_enqueue_script('core');
}
add_action('wp_enqueue_scripts', 'enqueue_js');

/**
 * Enqueue javascript
 *
 * @since Arenson 1.0.10
 */
function remove_comments_rss( $for_comments ) {
    return;
}
add_filter('post_comments_feed_link','remove_comments_rss');



//
// SOCIAL INK MODS, STARTING 7/20/2012
//

include('include/init.php');

	add_filter( 'wpseo_use_page_analysis', '__return_false' );

	add_filter( 'wpseo_metabox_prio', function() { return 'low';}); 