<?php
//aof codebase init

function checkStoreAccess($associatedClient) {

	if(!$associatedClient||(get_cur_user_id()!=$associatedClient)) {
		if(current_user_can('administrator'))
				echo adhere_admin_bar("store");
			else {
				wp_redirect(get_bloginfo('url')); 
				exit;				
			}
	}
}


function checkBinderAccess($binder_info, $binderHash) {
	
	$binder_referral_variable = '?binder_refer=' . $binderHash;	
	$redirectURL = get_bloginfo('url') . '/userlogin?' . $binder_referral_variable;
	$accessBinderAllowed=false;
	
	$user_id=$binder_info->user_id;
	$isClientBinder=isClient($user_id);
	$myBinder = (get_cur_user_id()==$binder_info->user_id) ? true : false;
	
	if(current_user_can('administrator')||$myBinder)
		$accessBinderAllowed=true;
		
	//var_dump($isClientBinder);
	
	if(!$isClientBinder)
		$accessBinderAllowed=true;
		
	if($binderHash=="")
		$accessBinderAllowed=false;

	if($accessBinderAllowed) {
	
		if(current_user_can('administrator')&&(!$myBinder))
			echo adhere_admin_bar("binder");	
				
	}else {
		wp_redirect($redirectURL); 
		exit;		
	}
		
}

add_action( 'parse_query', 'checkAOFAccess' );

function checkAOFAccess() {
	$preventAccess = false;
	
	if(isProtected()) {
		if(member_logged_in()) {
		}else {
			$preventAccess=true;
			}	
	}
	
	if($preventAccess) 
	{
		wp_redirect(get_bloginfo('url'));
		exit;
	}  
}

function block_wp_admin_init() {
	$doing_ajax = (defined('DOING_AJAX')); //constant('DOING_AJAX');
	//var_dump($doing_ajax);
	if (strpos(strtolower($_SERVER['REQUEST_URI']),'/wp-admin/') !== false) {
		if ( !current_user_can('administrator') && !$doing_ajax  ) {
			wp_redirect( get_option('siteurl'), 302 );
		}
	}
}
add_action('init','block_wp_admin_init',0);



function member_logged_in() {
	$userAllowed=false;

	if(isset($_SESSION['curUser']))
		$userAllowed=true;	
	elseif (is_user_logged_in()||is_admin()||current_user_can('administrator')) {
		global $current_user;
		get_currentuserinfo();
		$my_username = $current_user->user_login;
		$my_id = $current_user->ID;
		$_SESSION['curUser']=$my_id;
		$userAllowed=true;		
	}

	return $userAllowed;
}




/* ajax logout */
	add_action( 'wp_ajax_nopriv_ui_logout', 'ui_logout' );
	add_action( 'wp_ajax_ui_logout', 'ui_logout' );
		
function ui_logout() {
	unset($_SESSION['curUser']);
	wp_logout();
	wp_set_current_user(0);
	echo json_encode(array('unset'=>'logout'));
	exit;
}



function isProtected() {
	$protectedPage=false;
	global $protectedPages;
	global $post;
	global $wp_query;
	$curPage=$wp_query->queried_object->ID;

	if(is_page())
		if(in_array($curPage,$protectedPages))
			$protectedPage=true;
	
	return $protectedPage;
}


/* Disable WordPress Admin Bar for all users but admins. */
if (!current_user_can('administrator')):
  show_admin_bar(false);
endif;
	

?>