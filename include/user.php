<?php
//aof codebase init



/* USER REG AND VERIFICATION ETC */

$member_iAMA= array("End User","Member of Executive Management","Architect or Designer","Facilities Manager","Owner's Representative","Information Technology Manager","Purchasing Manager","General Contractor","Arenson Team Member","Other Team Member");

$memberMarketSegment = array("Corporate + Commercial - (General)","Financial Services","Legal Services","Healthcare","Architecture + Design","Business Services","Consumer Brands + Services","Technology + Information Management","Media, Advertising + Creative Services","Transportation Services","Start-up + Small Business","Education - Higher Ed + K-12","Government","Real Estate Services","Hospitality","General Contracting","Not-for-profit + Cultural","Set Design + Decoration","Film, TV, Video + Commercial Production","Special + Corporate Events","Styling Design","Furniture Manufacturer + Arenson Team Member","Other");

$userReg_extrafields = array(
						"Phone"=>'member_phone',
						"Company"=>'member_company',
					//	"Title"=>'member_title',
);
			
$userReg_AddressFields = array(
					//	"Address"=>'member_address',
					//	"Street Address"=>'member_street_address',
					//	"Address Line 2"=>'member_street_address2',
						"City"=>'member_city',
					//	"State/Province/Region"=>'member_state',
					//	"Postal / Zip Code"=>'member_zip',
					//	"Country"=>'member_country'
					);

						
$client_fields = array(
					"Asset Manager Tool" => 'aofClientAssetManagerTool',
					"Facilities Manager Tool" => 'aofClientFacilitiesManagerTool',
					"Furniture Standards Tool" => 'aofClientFurnitureManagerTool',
					"Warehouse Manager Tool" => 'aofClientWarehouseManagerTool',
					);						

					
					
//username verification ajax
add_action( 'wp_ajax_nopriv_signup_verifyuser', 'verify_username_ajax' );
add_action( 'wp_ajax_signup_verifyuser', 'verify_username_ajax' );

function verify_username_ajax() {
	if(isset($_POST['username'])) 
		if(username_available(sanitize_user_inputs($_POST['username'])))
			echo "available";
		else
			echo "unavailable";
	
	die();
}

	function username_available($entered_username) {
		if(username_exists($entered_username))
			return false; //echo 'yes'; //return false;
		else
			return true; //echo 'no'; //return true;	
	}
	
	
//email verification ajax
add_action( 'wp_ajax_nopriv_signup_verifyemail', 'verify_email_ajax' );
add_action( 'wp_ajax_signup_verifyemail', 'verify_email_ajax' );

function verify_email_ajax() {
	if(isset($_POST['email_address'])) 
		if(!email_exists(sanitize_user_inputs($_POST['email_address'])))
			echo "available";
		else
			echo "unavailable";
	
	die();
}	


function mc_signup($userdata) {
	require_once 'inc/MCAPI.class.php';
	require_once 'inc/config.inc.php'; //contains apikey

	$api = new MCAPI($apikey);

	$merge_vars = array('FNAME'=>$userdata['first_name'], 'LNAME'=>$userdata['last_name']);

	// By default this sends a confirmation email - you will not see new members
	// until the link contained in it is clicked!
	$retval = $api->listSubscribe( $listId, $userdata['user_email'], $merge_vars );

	if ($api->errorCode){
		$success_subscription=false;
	//	echo "Unable to load listSubscribe()!\n";
	//	echo "\tCode=".$api->errorCode."\n";
	//	echo "\tMsg=".$api->errorMessage."\n";
	} else {
		$success_subscription=true;
	//	echo "Subscribed - look for the confirmation email!\n";
	}
	
	return $success_subscription;

}

/* ajax newuser from homepage */
	add_action( 'wp_ajax_nopriv_ajax_registerUser', 'ajax_registerUser' );
	add_action( 'wp_ajax_ajax_registerUser', 'ajax_registerUser' );
		
function ajax_registerUser($user_info) {
	//global $user_extra_data;
	//remember to sanitize!
	//http://codex.wordpress.org/Function_Reference/wp_insert_user
	$user_info=$_POST;
	$user_info_extended_post=explode('&',sanitize_user_inputs($user_info['member_datum']));
	foreach($user_info_extended_post as $one_data) {
		$key = substr($one_data,0,strpos($one_data,'='));
		$value = urldecode(substr($one_data,strpos($one_data,'=')+1));
		$user_info_extended[$key] = $value;
	}
		
	
	$create_user_result = false;
//	var_dump($user_info_extended);


		if(verify_password(sanitize_user_inputs($user_info_extended['member_password']),sanitize_user_inputs($user_info_extended['member_password_confirm']))) {
			$user_insert_data = array(
				"user_pass" => $user_info_extended['member_password'],
				"first_name" => $user_info_extended['member_firstname'],
				"last_name" => $user_info_extended['member_lastname'],
				"user_email" => $user_info_extended['member_email'],
				"user_login" => $user_info_extended['member_username'],
			);
						
			//wp_new_user_notification
			$newuser=wp_insert_user($user_insert_data);
			
			//create unauthenticated user for now
			if($newuser) {
			
				//did they want newsletter?
				if($user_info_extended['member_newsletterconfirm'])
					mc_signup($user_insert_data);
					
				//add all those metas
				global $userReg_AddressFields;
				
				foreach($userReg_AddressFields as $fieldy)
					add_user_meta( $newuser, $fieldy, $user_info_extended[$fieldy]);

				add_user_meta( $newuser, 'member_phone', $user_info_extended['member_phone']);
				add_user_meta( $newuser, 'member_company', $user_info_extended['member_company']);
				add_user_meta( $newuser, 'member_title', $user_info_extended['member_title']);
				add_user_meta( $newuser, 'member_iAMA', $user_info_extended['member_iAMA']);
				add_user_meta( $newuser, 'member_marketSegment', $user_info_extended['member_marketSegment']);
				
				//create a favorites binder
				createbinder('Favorites', 'My Favorites',$newuser); 
				
				
				//sign them in automagically
				$creds = $user_insert_data;
				$creds['user_password'] = $user_insert_data['user_pass'];
				$creds['remember'] = true;
				$signin_user = wp_signon( $creds, false );

				
				$_SESSION['curUser']=$newuser;
				$create_user_result=true;
				$create_user_result_msg="Thanks for signing up! You will be redirected to the home page in a few moments.  If you chose to sign up for our newsletter, you will see a confirmation email in your box shortly.";
			} else {
				$create_user_result_msg="We couldn't create a new user. Please refresh the page and try again, or contact an administrator."; 
			}
		} else 
		$create_user_result_msg="Sorry, your password is invalid or doesn't match"; 

	$newuser_response=array(
				'successful'=>$create_user_result,
				'message'=>$create_user_result_msg );
				
	echo json_encode($newuser_response);
	die();
}

	//password verify
	function verify_password($pwd,$matcher) {
		$error=array();

		if($pwd!=$matcher)
			$error[]="Passwords don't match.";
			
		if( strlen($pwd) > 20 ) 
			$error[]="Password too long! <br />";

		if( strlen($pwd) < 7 ) 
			$error[]="Password too short! <br />";

		if( !preg_match("#[0-9]+#", $pwd) ) 
			$error[]="Password must include at least one number! <br />";

		if( !preg_match("#[a-z]+#", $pwd) ) 
			$error[]="Password must include at least one letter! <br />";
		
		if($error)
			return false;
		else
			return true;
	}	

	//password changes
	add_filter ( 'retrieve_password_title', 'aofChangeTitle', 10, 1 );
	add_filter ( 'retrieve_password_message', 'aofChangeMesage', 1, 2); 
	
	function aofChangeMesage($message,$key) {
		$user_login=substr($message,strpos($message,"&login=")+7,strpos($message,">")-1);
		$user_login = PREG_REPLACE("/[^0-9a-zA-Z_]/i", '', $user_login);
		//$user_login = PREG_REPLACE("/[^0-9a-zA-Z]/i", '', $user_login);

		$followlink = home_url("password-reset") . "?action=rp&key=$key&login=" . rawurlencode($user_login);

		$message = "Dear Arenson User,\r\n\r\n";
		$message = "Dear $user_login,\r\n\r\n";
		$message.= "You requested to reset the password associated with this account on the Arenson Site.\r\n\r\n";
		$message.= "Please note your username (different from your email), which is used to log in : $user_login.\r\n\r\n";
		$message.= "Follow the link below to reset the password. If you didn't request it, you can safely delete this email.\r\n\r\n";
		$message.=$followlink;
		$message.= "\r\n\r\nThank you,\r\nArenson\r\n";
		$message.= "Contact: " . home_url("contact-us");	;
		
		return $message;
	}		
	
	function aofChangeTitle($subject) {
		$subject = "Arenson Users: Your password reset link.";
		return $subject;
	}

	
	


/* USER DATA */

function get_cur_user_id() {
	global $current_user;
	get_currentuserinfo();
	return $current_user->ID;
}

function get_cur_phone($curuser=true) {
	if($curuser) {
		$curid = get_cur_user_id();
		return get_user_meta($curid, 'member_phone', true);
	}
}

function get_cur_email($curuser=true) {
	if($curuser) {
		global $current_user;
		get_currentuserinfo();
		return $current_user->user_email;
	}
}

function get_cur_username() {
	global $current_user;
	get_currentuserinfo();
	return $current_user->display_name;
}

function get_firstname() {
	global $current_user;
	get_currentuserinfo();
	return $current_user->user_firstname;
}
function get_lastname($fullword=true) {
	global $current_user;
	get_currentuserinfo();
	$lastname= $current_user->user_lastname;
	if($fullword)
		return $lastname;
	else
		return substr($lastname ,0,1);
}



//DASHBOARD

function get_user_dash() {
	$user_id=get_cur_user_id();
	$client_data=isClient($user_id);
	$favebinder_hash = getFavoritesBinder($user_id,true);
//	dump(getFavoritesBinder(1,true));
	
	ob_start(); ?>
	<div class="metaContentBlackBar">
		<div class="userdash centering_box menu_horizontal">
			<ul>
				<? if($client_data) { ?>
				
				<? } else { ?>
					<li><a href="<? echo home_url('contact') ?>">Contact Arenson</a></li>
					<li class="even"><a href="<? echo home_url('binder') ?>?b=<? echo $favebinder_hash ?>">My Favorites</a></li>
					<li class="third"><a href="<? echo home_url('dashboard#binder_intro') ?>">My Binders</a></li>
				<? } ?>
			</ul>
			<div class="clearfix"></div>
		</div>
	</div>
			
	
	
	<?$dash=ob_get_clean();
	
	return $dash;

}



/*****************
BACKEND USER FIELD SAVING/SHOWING
***********************************************/
	
	//remove default fields
	function edit_contactmethods( $contactmethods ) {
	   unset($contactmethods['yim']);
	   unset($contactmethods['aim']);
	   unset($contactmethods['jabber']);
	 return $contactmethods;
	 }
	 add_filter('user_contactmethods','edit_contactmethods',10,1);
 
		
	add_action('register_form','aof_show_extra_fields');
	
	//show fields on user edit page
	add_action( 'show_user_profile', 'aof_show_extra_fields' );
	add_action( 'edit_user_profile', 'aof_show_extra_fields' );

	function aof_show_extra_fields( $user ) { 

		global $userReg_AddressFields;
		global $userReg_extrafields;
		global $client_fields;
		$fieldArray=array_merge( $userReg_extrafields, $userReg_AddressFields);

	?>

		<h3>AOF Registration Information</h3>

		<table class="form-table">
	
			<? foreach($fieldArray as $fieldcaption=>$fieldvalue) {	?>
				<tr>
					<th><label for="<? echo $fieldvalue ?>"><? echo $fieldcaption ?>:</label></th>

					<td>	
						<input type="text" name="<? echo $fieldvalue ?>" id="<? echo $fieldvalue ?>" value="<?php echo get_user_meta( $user->ID, $fieldvalue, true) ?>" class="regular-text" /><br />
						<span class="description"><? //echo $fieldcaption ?></span>
					</td>
				</tr>
			<? } ?>
		
			<tr><th><label for="member_iAMA" class="thecaption">*I am A(n)</label></th>
			<? global $member_iAMA;
				$curiAMA=get_user_meta( $user->ID, 'member_iAMA', true); ?>
			
			<td><select name="member_iAMA" id="member_iAMA" class="required aof_select">
				<option value="newb">Choose An Option</option>
				<? foreach($member_iAMA as $oneIAMA) { ?>
					<option value="<? echo $oneIAMA?>" <? if($oneIAMA==$curiAMA) echo ' selected' ?>><? echo $oneIAMA ?></option>
				<? } ?>						
			</select></td></tr>
			<br />				
			
			<tr><th><label for="member_marketSegment" class="thecaption">My Market Segment:</label></th>
			<? global $memberMarketSegment;
				$curSegment=get_user_meta( $user->ID, 'member_marketSegment', true);
				?>
			
			<td><select name="member_marketSegment" id="member_marketSegment" class="required aof_select">
				<option value="newb">Choose A Segment</option>
				<? foreach($memberMarketSegment as $oneSeg) { ?>
					<option value="<? echo $oneSeg?>" <? if($oneSeg==$curSegment) echo ' selected' ?>><? echo $oneSeg ?></option>
				<? } ?>						
			</select></td></tr>

		
		</table>
		
		<h3>AOF Client Information</h3>

		<table class="form-table">
		
			<tr><th><label for="aofIsClient" class="thecaption">This user is a client</label></th>
			<td><input type="checkbox" name="aofIsClient" id="aofIsClient" value="true" <?php if (esc_attr( get_the_author_meta('aofIsClient', $user->ID ) )) { echo 'checked=checked'; } ?> /></td></tr>		
	
			<? foreach($client_fields as $fieldcaption=>$fieldvalue) {	?>
				<tr>
					<th><label for="<? echo $fieldvalue ?>"><? echo $fieldcaption ?>:</label></th>

					<td>	
						<input type="text" name="<? echo $fieldvalue ?>" id="<? echo $fieldvalue ?>" value="<?php echo get_user_meta( $user->ID, $fieldvalue, true) ?>" class="regular-text" /><br />
						<span class="description"><? //echo $fieldcaption ?></span>
					</td>
				</tr>
			<? } ?>
			
			<tr><th><label for="member_relatedContent" class="thecaption">Associated Content Page (note this can also be set through Client Content in sidebar):</label></th>
			<?	$allContentArgs = array(
						'post_type' => 		'client_content',
						'showposts'	=>	 -1,
					);			
					$client_content_pages = get_posts( $allContentArgs );
					
					$curRelatedContent=get_user_meta( $user->ID, 'member_relatedContent', true);
					
					global $post;
				?>
			
			<td><select name="member_relatedContent" id="member_relatedContent" class="aof_select">
				<option value="">Choose page</option>
				<? 	foreach($client_content_pages as $post) {
					setup_postdata($post);
					
						?>
					<option value="<? echo $post->ID?>" <? if($post->ID==$curRelatedContent) echo ' selected' ?>><? the_title() ?></option>
				<? } ?>						
			</select></td></tr>			
		
			

		</table>
							
	<?php }

	
	//save fields on user edit page
	add_action( 'personal_options_update', 'aof_save_extra_fields' );
	add_action( 'edit_user_profile_update', 'aof_save_extra_fields' );

	function aof_save_extra_fields( $user_id ) {
	
		global $userReg_AddressFields;
		global $userReg_extrafields;
		global $client_fields;
		$fieldArray=array_merge( $userReg_extrafields, $userReg_AddressFields,$client_fields);
		$extraz=array('member_iAMA','member_marketSegment','aofIsClient','member_relatedContent');
		

	if ( !current_user_can( 'edit_user', $user_id ) )
			return false;

		foreach($fieldArray as $fieldcaption=>$fieldvalue) {
		update_user_meta( $user_id, $fieldvalue, $_POST[$fieldvalue] );
		} 		
		
		foreach($extraz as $fieldvalue) {
		update_user_meta( $user_id, $fieldvalue, $_POST[$fieldvalue] );
		} 
	}
	
	

?>