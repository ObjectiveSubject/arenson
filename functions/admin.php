<?php 

/**
 * Remove unused menus from the Dashboard
 *
 * @since Arenson 1.0.5
 */
function os_remove_menus() {
	global $menu;

	$hidden = array(
		__('Links'),
		__('Comments')
	);
	end ($menu);
	while (prev($menu)) {
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $hidden)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'os_remove_menus');


/**
 * Move "Media" further down in sidebar
 *
 * @since Arenson 1.0.5
 */
function os_move_media () {
	global $menu; $menu[14] = $menu[10]; unset($menu[10]);
} 
add_action('admin_menu', 'os_move_media');

/**
 * Add custom stylesheet and js to backend
 *
 * @since Arenson 1.0.5
 */
function os_admin_stylesheet_js() {
 	//$siteurl = get_option('siteurl');
    $theme_url = get_bloginfo('template_url');
    
   echo '<link rel="stylesheet" href="' . $theme_url . '/admin/admin.css">';
   //echo '<script type="text/javascript" src="' . $theme_url . '/js/admin.js"></script>';
}
add_action('admin_head', 'os_admin_stylesheet_js');

/**
 * Removed unused Dashboard modules
 *
 * @since Arenson 1.0.5
 */
function os_disable_default_dashboard_widgets() {

	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}
add_action('admin_menu', 'os_disable_default_dashboard_widgets');


/**
 * Add custom Dashboard widgets
 *
 * @since Arenson 1.0.7
 */
function os_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_widget_intro', 'Site Information', 'os_dashboard_intro');
}
add_action('wp_dashboard_setup', 'os_custom_dashboard_widgets');

/**
 * Custom intro widget
 *
 * @since Arenson 1.0.7
 */
function os_dashboard_intro() {
	print '<img src="/wp-content/login-logo.png" alt="Logo">';
	print '<h4>Welcome!</h4>';
	print '<p>Custom dashboard widget. Could be used to provide messages to users logged in under different roles.';
	print '<h4>Media</h4>';
	print '<p>WordPress features auto-embeds from a number of popular media sources (<a href="http://codex.wordpress.org/Embeds">full list</a>).';
}


/**
 * Change default order of admin columns (might be unneeded with Codepress Admin Columns update)
 *
 * @since Arenson 1.0.5
 */
function os_admin_order($wp_query) {  
  if (is_admin()) {  
    $post_type = $wp_query->query['post_type'];  
  	
    $title_sort = array( );
    $type_sort = array('other', 'slides', 'markets', 'projects', 'services' );

    if ( in_array( $post_type, $title_sort ) ) {   
      $wp_query->set('orderby', 'title');   
      $wp_query->set('order', 'ASC');  
    }
    elseif ( in_array( $post_type, $type_sort )) {   
      $wp_query->set('orderby', 'menu_order');   
      $wp_query->set('order', 'ASC');  
    }    
  }  
}  
add_filter('pre_get_posts', 'os_admin_order'); 



/**
 * Change "posts" to "news" in admin area
 *
 * @since Katie 1.1
 */
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] = 'News';
	$submenu['edit.php'][10][0] = 'Add News';
	$submenu['edit.php'][16][0] = 'News tags';
	echo '';
}
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'News';
	$labels->singular_name = 'News';
	$labels->add_new = 'Add News';
	$labels->add_new_item = 'Add News';
	$labels->edit_item = 'Edit News';
	$labels->new_item = 'News';
	$labels->view_item = 'View News';
	$labels->search_items = 'Search News';
	$labels->not_found = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
}
add_action( 'init', 'change_post_object_label' );
add_action( 'admin_menu', 'change_post_menu_label' );
