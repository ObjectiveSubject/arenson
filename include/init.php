<?php
//aof codebase init


//INIT FUNCTIONS
include('socialink.library.slideshow_functions.php');
include('constants.php'); 
include('visual.php'); 
include('content.php'); 
include('ui.php');  
include('access.php');  
include('binder_funcs.php');  
include('user.php');  
include('pdf_creation.php');  
include('email.php');  
include('client.php');  
include('layout.php');  
include('exports.php');  

//INIT

add_image_size( 'related_content', 490, 315, true );
add_image_size( 'product_overviews', 330, 330, true );
add_image_size( 'hero_slideshow', 1400, 99999, true );
add_image_size( 'product_images', 999999, 600, false );		 


//returns slug of current page
function the_slug() {
	$post_data = get_post($post->ID, ARRAY_A);
	$slug = $post_data['post_name'];
	return $slug;
}


//returns "marker" of current page for uses
function get_current_marker() {
	wp_reset_postdata();wp_reset_query();
	
	if(is_page())
		$current_page = the_slug();
	elseif(is_category())
		$current_page = single_cat_title('',false);
	elseif(is_post_type_archive())
		$current_page = post_type_archive_title( '',false );
	elseif(is_front_page())
		$current_page = 'home';		
	elseif(is_home())
		$current_page = 'News';
	elseif( 'job' == get_post_type() )
		$current_page = 'job';	
	elseif( 'bio' == get_post_type() )
		$current_page = 'bio';
	
	return $current_page ? strtolower($current_page) : false;
}

//returns true if it is a single post type. equivalent to is_single() but is_single returns false for any type but "post"
function is_post_type_single() {
	global $post;
	$single_type = false;
	
	if(is_single()) {
		$allCPTs = get_post_types();

		foreach($allCPTs as $oneCPT) {
			$metainfo = get_post_type_object($oneCPT);
			if($post->post_type==$metainfo->name)
				$single_type = true;
		}

		if($single_type)
			return $post->post_type;
		else
			return false;
	} else
		return false;
}


//MISC FUNCTIONS	
function sanitize_user_inputs($var) {
	$var=stripslashes($var);
	global $wpdb;
	if(is_string($var)) {
		$var = mysql_real_escape_string ($var);
		$var = $wpdb->escape($var);
	}
	return stripslashes($var);
}



function create_slug($string){
   $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
   return $slug;
}

function create_hash() {
	$strKey = md5(microtime());
	return substr($strKey,0,15);	
}	

function dump($content) {
  echo '<pre>';
  print_r($content);
  echo '</pre>';
} 


//VIEWS



/********
 WP BACKEND  INTERACTION
 *******/
 
 
add_action('init', 'socialink_wp_backend');
add_action('admin_menu', 'sink_add_menus');	
add_action('admin_head', 'sink_add_menu_register_head');


	
	
	function sink_add_menus() {  

		add_menu_page("AOF Dashboard", "AOF Dashboard", "manage_options", "AOFMain", "aof_backend_main");
		add_submenu_page("AOFMain","Binder Explorer", "Binder Explorer", "manage_options", "aofBinderExplorer", "aof_binder_explorer");
	}
	
		function aof_backend_main() { 
			include('views/main.php');  
		 }  			
		function aof_binder_explorer() { 
			include('views/binder_explorer.php');  
		 }  						
		 
		function sink_add_menu_register_head() {
			 $url = get_bloginfo('template_url') . '/style.admin.css';
			 $fonturl = get_bloginfo('template_url') . '/admin/font/css/aof_backend.css';
			// $fancybox = get_bloginfo('template_url') . '/js/fb2/jquery.fancybox.css';
		//	 $tablesort = get_bloginfo('template_url') . '/js/jquery.tablesorter.min.js';
			 echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
			 echo "<link rel='stylesheet' type='text/css' href='$fonturl' />\n";
			// echo "<link rel='stylesheet' type='text/css' href='$fancybox' />\n";
			// echo "<link rel='stylesheet' type='text/css' href='$fancybox' />\n";
			// echo "<script type='text/javascript' src='$jeditable'></script>";
			// echo "
				// <!--AJAX -->
				// <script type='text/javascript'>
				 // directory_root = \"" . get_bloginfo('template_url') . "\";
				// /* <![CDATA[ */
				// var cswAJAX = {\"ajaxurl\":\"". get_bloginfo('url') ."/wp-admin/admin-ajax.php\",
								// \"specialNonce\":\"sdf90823njkxcvnmxcvjk23\"
								// };
				// /* ]]> */
				// </script>
				// ";
				
				if(is_admin()&&($_GET['page']=='aofBinderExplorer')){       
					$url = get_bloginfo('template_url') . '/js/tablesort_theme/style.css';
					echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
				} 
	
		}		
		
		

//admin JQ?

function socialink_wp_backend() {
    if (!is_admin()) {
    //    wp_enqueue_script('custom_script', get_bloginfo('template_url').'/js/sink_backend.js', array('jquery'));
    }
    if(is_admin()&&($_GET['page']=='aofBinderExplorer')){       
    //    wp_enqueue_script('counting_script', get_bloginfo('template_url').'/js/jquery.simplyCountable.js', array('jquery'));
	
        wp_enqueue_script('tablesorter', get_bloginfo('template_url').'/js/jquery.tablesorter.min.js', array('jquery'));
		wp_enqueue_script('aof_admin', get_bloginfo('template_url').'/js/social_ink.library.backend.js', array('jquery'));
    }   
}



?>