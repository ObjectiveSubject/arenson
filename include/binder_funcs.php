<?php
//aof binder

// AJAX RECEIVERS


/* change item desc & title */
	add_action( 'wp_ajax_nopriv_binder_editMeta', 'ajax_binder_editMeta' );
	add_action( 'wp_ajax_binder_editMeta', 'ajax_binder_editMeta' );
	
function ajax_binder_editMeta() {
	$binder_id=sanitize_user_inputs($_POST['binderID']);
	$binderNewTitle=sanitize_user_inputs($_POST['binderNewTitle']);
	$binderNewDesc=sanitize_user_inputs($_POST['binderNewDesc']);
	
	$success=binder_modifydesc($binder_id, $binderNewTitle,$binderNewDesc);
	echo json_encode(array('updated_data'=>$success));
	die();
}

	function binder_modifydesc($binder_id, $binderNewTitle, $binderNewDesc) {
		$userID=get_cur_user_id();
		$success=false;
		
		if(binder_exists_for_user($binder_id, $userID)) {	//sec check
			$binderNewSlug = create_slug($binderNewTitle);
			global $wpdb;
			
			$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
			$myquery = "UPDATE $binders_table SET name='$binderNewTitle', slug='$binderNewSlug', description='$binderNewDesc' where id='$binder_id'";

			$myresult = $wpdb->query($myquery);
			if($myresult==1)
				$success=true;
		}	
		
		return $success;
	}
	
	
	
/* change item quantity binder */
	add_action( 'wp_ajax_nopriv_binder_item_changequantity', 'ajax_binder_item_changequantity' );
	add_action( 'wp_ajax_binder_item_changequantity', 'ajax_binder_item_changequantity' );
	
function ajax_binder_item_changequantity() {
	$binder_data=explode(":",sanitize_user_inputs($_POST['item']));
	$newquant=sanitize_user_inputs($_POST['newquant']);
	$binder_id=$binder_data[0];
	$binder_item=$binder_data[1];
	$success=binder_item_changequantity($binder_id, $binder_item,$newquant);
	echo json_encode(array('updatedquantity'=>$success));
	die();
}

	function binder_item_changequantity($binder_id, $binder_item, $newquant) {
		$userID=get_cur_user_id();
		$success=false;
		
		if(binder_exists_for_user($binder_id, $userID)) {	//sec check
			global $wpdb;
			
			$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	
			$myquery = "UPDATE $binder_item_table SET quantity='$newquant' where id='$binder_item'";

			$myresult = $wpdb->query($myquery);
			if($myresult==1)
				$success=true;
		}	
		
		return $success;
	}
	
	
/* delete item binder */
	add_action( 'wp_ajax_nopriv_binder_deleteitem', 'ajax_binder_deleteitem' );
	add_action( 'wp_ajax_binder_deleteitem', 'ajax_binder_deleteitem' );
	
function ajax_binder_deleteitem() {
	$binder_data=explode(":",sanitize_user_inputs($_POST['item']));
	$binder_id=$binder_data[0];
	$binder_item=$binder_data[1];
	$success=binder_deleteitem($binder_id, $binder_item);
	echo json_encode(array('deleted'=>$success));
	die();
}

	function binder_deleteitem($binder_id, $binder_item) {
		$userID=get_cur_user_id();
		$success=false;
		
		if(binder_exists_for_user($binder_id, $userID)) {	//sec check
			global $wpdb;
	
			$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	
			$myquery = "DELETE FROM $binder_item_table where id='$binder_item' and binder_id='$binder_id'";

			$myresult = $wpdb->query($myquery);
			if($myresult==1)
				$success=true;
		}	
		
		return $success;
	}


/* delete binder */
	add_action( 'wp_ajax_nopriv_binder_trashBinder', 'ajax_binder_trashBinder' );
	add_action( 'wp_ajax_binder_trashBinder', 'ajax_binder_trashBinder' );
	
function ajax_binder_trashBinder() {
	$binder_id=sanitize_user_inputs($_POST['binderID']);
	
	$success=binder_trashbinder($binder_id);
	$response_trash=array(
		'trashed_binder'=>$success
		);
	if($success)
		$response_trash['trashmessage']="Binder deleted. Redirecting you in a moment.";
	else
		$response_trash['trashmessage']="We couldn't delete the binder. Please try again or contact an admin.";
		
	echo json_encode($response_trash);
	
	die();
}


	function binder_trashbinder($binder_id) {
		$userID=get_cur_user_id();
		$success=false;
		
		if(binder_exists_for_user($binder_id, $userID)) {	//sec check

			global $wpdb;
			
			$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
			$myquery = "UPDATE $binders_table SET active='0' where id='$binder_id'";

			$myresult = $wpdb->query($myquery);
			if($myresult==1)
				$success=true;
		}	
		
		return $success;
	}


/* remove from favorites */
	add_action( 'wp_ajax_nopriv_binder_removefromfavorites', 'binder_removefromfavorites' );
	add_action( 'wp_ajax_binder_removefromfavorites', 'binder_removefromfavorites' );
	
function binder_removefromfavorites() {
	$fave_id=sanitize_user_inputs($_POST['item']);
	$userID=get_cur_user_id();
	$favebinderID=getFavoritesBinder($userID);
	$unfavorited=binder_deleteitem($favebinderID, $fave_id);
	$removed_fa=array(
			'unfavorited'=>$unfavorited,
			);
	echo json_encode($removed_fa);
	
	die();
}

/* add to favorites */
	add_action( 'wp_ajax_nopriv_binder_addtofavorites', 'binder_addtofavorites' );
	add_action( 'wp_ajax_binder_addtofavorites', 'binder_addtofavorites' );
	
function binder_addtofavorites() {
	$prod_id=sanitize_user_inputs($_POST['item']);
	$userID=get_cur_user_id();
	$favebinderID=getFavoritesBinder($userID);
	
	if(!isFavoriteItem($prod_id,$userID)){
		$favorited=addBinderItem($userID, $prod_id,1,$favebinderID);
	}else
		$favorited=true;
		
	if($favorited)
		echo json_encode(array('faveID'=>$favorited, 'favorited'=>'true'));
	else
		echo json_encode(array('favorited'=>'false'));
	
	die();
}

/* add to binder */
	add_action( 'wp_ajax_nopriv_binder_additem', 'ajax_binder_additem' );
	add_action( 'wp_ajax_binder_additem', 'ajax_binder_additem' );
	
function ajax_binder_additem() {
	$userID = get_cur_user_id();

	$prod_id=sanitize_user_inputs($_POST['item']);
	$prod_title = get_the_title($prod_id);
	
	$binderExistingId=sanitize_user_inputs($_POST['binderExisting']);
	$binderNewName=sanitize_user_inputs($_POST['binderNew']);
	$binderDesc=sanitize_user_inputs($_POST['binderDesc']);
	$itemQuantity=sanitize_user_inputs($_POST['itemQuantity']);

	$addItemResult=false;
	$binderAddMessage="Sorry, we couldn't add the item. Please refresh the page and try again, or contact the administrator for more help.";
	
	//new binder or existing?
	if($binderExistingId!="newb"&&(($binderNewName=='eg Front Lobby')||($binderNewName==""))) {	//want existing
		if(binder_exists_for_user($binderExistingId, $userID)){	
			if(!binder_contains($binderExistingId, $userID, $prod_id)) {
				$added=addBinderItem($userID, $prod_id, $itemQuantity,$binderExistingId);
				if($added) {
					$binderLink = get_binder_link($binderExistingId);
					$binderAddMessage="You successfully added <span class=\"attention_description\">$itemQuantity</span> <span class=\"attention_title\">$prod_title</span> to your binder <a class=\"attention_binderlink\" href=\"" . $binderLink . "\">" . get_binder_name($binderExistingId) . "</a> <a href=\"\" class=\"fb_closer\">&#xaa;</a>";				
					$addItemResult=true;
					} 				
			}else
				$binderAddMessage="This item is already in the <span class=\"binder_attention\">" . get_binder_name($binderExistingId) . "</span> binder. Please visit your <a href=\"". get_binder_link($binderExistingId) ."\">binder page</a> to review.";
		}else
			$binderAddMessage="Sorry we don't have a binder by that name for you. Please create a new binder";
			
	} else { //make new
		$binderDesc = ($binderDesc=='eg. These are items for the front lobby with a blue and gray color scheme.') ? "" : $binderDesc;
		if(!binder_name_taken_for_user($binderNewName, $userID)) {
			$newbinderID=createbinder($binderNewName, $binderDesc, $userID );	
			$added=addBinderItem($userID, $prod_id, $itemQuantity,$newbinderID);
			if($added) {
				$binderLink = get_binder_link($newbinderID);
				$binderAddMessage="You successfully added <span class=\"attention_description\">$itemQuantity</span> <span class=\"attention_title\">$prod_title</span> to your binder <a class=\"attention_binderlink\" href=\"" . $binderLink . "\">" . $binderNewName . "</a> <a href=\"\" class=\"fb_closer\">&#xaa;</a>";							
				$addItemResult=true;		
				}
		}else
			$binderAddMessage="You already have a binder with the name <span class=\"binder_attention\">$binderNewName</span>. Please rename and try again, or clear the binder name field and select from an existing binder.";
	}
	
	$binderQuoteBehavior = ((sanitize_user_inputs($_POST['functionality'])=='adding_quote')&&$binderLink) ? true : false;
	
	$resultArray=array(
		'binderAddMessage'=>$binderAddMessage,
		'binderAddSuccess'=>$addItemResult,
		'quoteBehavior'=>$binderQuoteBehavior,
		'binderAddMessageTitle'=>$addItemResult ? 'Success.' : 'Oops',
		'binderLink'=>$binderLink,
	);
	
	echo json_encode($resultArray);

	die();
}



//FUNCTIONS

function getFavorites($user_id) {
	$favebinderID=getFavoritesBinder($user_id);
	$binderitems = get_binder_items($favebinderID);
//	var_dump($favebinderID);
	
	return $binderitems;
	
/*	global $wpdb;
	$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	
	$myquery = "SELECT id,product_id FROM $binder_item_table where binder_id='$favebinderID'";
	$myresult = $wpdb->get_results($myquery);

	if($myresult)
		return $myresult;
	else
		return false;	
*/
}

function getFavoritesBinder($userID,$returnhash=false) {
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";
	if($returnhash)
		$myquery = "SELECT hash FROM $binders_table where name='Favorites' AND user_id='$userID'";
	else
		$myquery = "SELECT id FROM $binders_table where name='Favorites' AND user_id='$userID'";
	
	$binderID = $wpdb->get_var($myquery);

	return $binderID;
}


function isFavoriteItem($prod_id,$user_id) {
	$favebinderID=getFavoritesBinder($user_id);
	global $wpdb;
	$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	
	$myquery = "SELECT id FROM $binder_item_table where product_id='$prod_id' AND user_id='$user_id' AND binder_id='$favebinderID'";
	$myresult = $wpdb->get_var($myquery);

	if($myresult)
		return $myresult;
	else
		return false;
}

function getBinders($userId,$fulldescription=false) {
	$favebinderID=getFavoritesBinder($userId);
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	
	if($fulldescription)
		$myquery = "SELECT id,name,hash,description FROM $binders_table where user_id='$userId' AND active!='0' AND id!='$favebinderID' ";
	else
		$myquery = "SELECT id,name FROM $binders_table where user_id='$userId' AND active!='0' AND id!='$favebinderID' ";
		
	$myresult = $wpdb->get_results($myquery,ARRAY_A);

	return $myresult;
}

function binder_exists_for_user($binderID, $userID) {
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	$myquery = "SELECT name FROM $binders_table where user_id='$userID' AND active!='0' AND id='$binderID'";
	$myresult = $wpdb->get_var($myquery);

	if($myresult||current_user_can('administrator'))
		return true;
	else
		return false;
}

function binder_name_taken_for_user($binderName, $userID) {
	$slug=create_slug($binderName);
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	$myquery = "SELECT count(id) FROM $binders_table where user_id='$userID' AND slug='$slug'";
	$myresult = $wpdb->get_var($myquery);

	if($myresult)
		return true;
	else
		return false;
}


function get_binder_link($binderID) {
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	$myquery = "SELECT hash FROM $binders_table where id='$binderID' AND active!='0' LIMIT 1";
	$myresult = $wpdb->get_var($myquery);
	
	if($myresult) {
		return home_url('binder') . "?b=$myresult";
	}else
		return false;
}

function get_binder_by_hash($binderHash) {
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	$myquery = "SELECT id,name,description,date_added,user_id FROM $binders_table where hash='$binderHash' AND active!='0' LIMIT 1";
	$myresult = $wpdb->get_results($myquery);
	
	if($myresult) {
		$binderinfo=$myresult[0];
		return $binderinfo;
	}else
		return false;
}

function get_binder_name($binderExistingID) {
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	$myquery = "SELECT name FROM $binders_table where id='$binderExistingID'";
	$myresult = $wpdb->get_var($myquery);

	if($myresult)
		return $myresult;
	else
		return false;
}



function get_binder_items($binderID) {
	global $wpdb;
	$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	

	$myquery = "SELECT id,product_id,date_added,quantity FROM $binder_item_table where binder_id='$binderID' ORDER BY date_added";
	
	$myresult = $wpdb->get_results($myquery);

	if($myresult)
		return $myresult;
	else
		return false;	
}

function binder_contains($binderID, $userID, $itemID=null) {
	global $wpdb;
	$binders_table = $wpdb->get_blog_prefix() . "aof_binders";	
	$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	

	$myquery = "SELECT COUNT($binder_item_table.id) FROM $binders_table, $binder_item_table
				WHERE $binders_table.id='$binderID'
				AND $binder_item_table.binder_id='$binderID'
				AND $binder_item_table.product_id='$itemID'";

	$myresult = $wpdb->get_var($myquery);

	if($myresult)
		return true;
	else
		return false;	
}


/* create binder */
	add_action( 'wp_ajax_nopriv_ajax_binder_createbinder', 'ajax_binder_createbinder' );
	add_action( 'wp_ajax_ajax_binder_createbinder', 'ajax_binder_createbinder' );
	
function ajax_binder_createbinder() {
	$binderNewTitle=sanitize_user_inputs($_POST['binderNewTitle']);
	$binderNewDesc=sanitize_user_inputs($_POST['binderNewDesc']);
	$newbinderID=createbinder($binderNewTitle, $binderNewDesc,get_cur_user_id() );
	
	$binderadd['created_binder'] = ($newbinderID) ? true :false;
	$binderadd['binderCreated'] = ($newbinderID) ? "We added binder $binderNewTitle to your account. Please refresh the page to see the binder." :"Sorry, we couldn't add $binderNewTitle to your account. Please try reloading the page, or contacting an admin.";
	
	echo json_encode($binderadd);
	die();
}



	function createbinder($name, $description,$userID) {
		$slug=create_slug($name);
		$hash=create_hash($name);
		$name = substr($name, 0, 24);
		global $wpdb; 
		$binders_table = $wpdb->get_blog_prefix() . "aof_binders";

		$newBinderAdd= array(
				'user_id'=> $userID,
				'slug'=> $slug,
				'hash'=> $hash,
				'name'=> $name,
				'description'=> stripslashes($description),
		);

		$newBinder =  $wpdb->insert($binders_table, $newBinderAdd );	

		$successful_add=$newBinder ? $wpdb->insert_id : false;
		
		return $successful_add;
	}

function addBinderItem($userID, $prod_id, $itemQuantity=1,$binderID) {
		
	$prod_sku=get_prod_sku($prod_id);
	
	global $wpdb; 
	$binder_item_table = $wpdb->get_blog_prefix() . "aof_binder_items";	

	$newItemAdd= array(
			'user_id'=> $userID,
			'product_id'=> $prod_id,
			'product_sku'=> $prod_sku,
			'quantity'=> $itemQuantity,
			'binder_id'=> $binderID,	//0 is favorites
	);

	$newItemAdded =  $wpdb->insert($binder_item_table, $newItemAdd );	
			
	if($newItemAdded)
		$successful_add=$wpdb->insert_id;	
	else
		$successful_add=false;
		
	return $successful_add;

}




	
	
// BINDER ADDS 8/1/2013


// function () {
	// global $wpdb;
	// $binders_table = $wpdb->get_blog_prefix() . "aof_binders";	

	// $myquery = "SELECT  FROM $binders_table where user_id='$userId' AND active!='0' AND id!='$favebinderID' ";

	// $myresult = $wpdb->get_results($myquery,ARRAY_A);

	// return $myresult;
// }

function getAllBinders($sort_criteria = 'id', $sortorder = 'DESC', $filter_keyword = false, $limits = false, $max = false, $filteroptions = false, $filtertime=false, $object = true) {

	$binderDeets = new stdclass();
	
	global $wpdb;
	$regtable = AOF_bindertable;
	$metatable = AOF_bindertable_meta;
	$usertable = $wpdb->users;
	$usermetatable = $wpdb->usermeta;

	
	
	$myfields =explode(',', AOF_bindertable_fields);
	foreach($myfields as &$f)
		$f=AOF_bindertable . '.' . $f;
		
	$userdata_fields = explode(',', AOF_userdata_fields);
	foreach($userdata_fields as &$f)
		$f=$usertable . '.' . $f;		

	$myfields = array_merge($myfields, $userdata_fields);	
	$myfields = implode(',',$myfields);
	
//	var_dump($myfields);
//	return false;

			

	if($filteroptions) {
		if($filteroptions=='fav')
			$filteroptions = "AND name='Favorites' ";
		else
			$filteroptions = "AND name!='Favorites' ";
	}
		
		
	if($filtertime)
		$filtertime = 'AND ' . $filtertime;
				
	if($filter_keyword) {
		$filter_keyword = trim(strtoupper($filter_keyword));
		
		$fields_array = explode(',', AOF_bindertable_fields);
		foreach($fields_array as &$f)
			$f=AOF_bindertable . '.' . $f;		
		unset($fields_array['id']);

		// $fields_array_meta = explode(',', AOF_bindertable_meta_fields);
		// foreach($fields_array_meta as &$f)
			// $f=AOF_bindertable_meta . '.' . $f;		
		// unset($fields_array_meta['id']);		
		
		$userdata_fields = explode(',', AOF_userdata_fields);
		foreach($userdata_fields as &$f)
			$f=$usertable . '.' . $f;		
	//	unset($fields_array_meta['id']);		
		
		$userdata_fields = explode(',', AOF_userdata_fields);
		foreach($userdata_fields as &$f)
			$f=$usertable . '.' . $f;			
			
		$usermetadata_fields = explode(',', AOF_usermetadata_fields);
		foreach($usermetadata_fields as &$f)
			$f=$usermetatable . '.' . $f;		
				
	//	$myfields
		
		
		//$fields_array = array_merge($fields_array,$fields_array_meta,$userdata_fields,$usermetadata_fields);
		$fields_array = array_merge($fields_array,$userdata_fields,$usermetadata_fields);

	//	var_dump($myfields);
	//	var_dump($userdata_fields);
		
		$field_query="";
		foreach($fields_array as $field)
			$field_query.=" OR UPPER($field) LIKE '%$filter_keyword%'";	

		$query_base	 = "FROM $regtable
						JOIN $usertable ON ($regtable.user_id = $usertable.ID)
						JOIN $usermetatable ON ($regtable.user_id = $usermetatable.user_id)

						WHERE (hash LIKE '%$filter_keyword%' 															 
						$field_query)
						$filteroptions $filtertime 						
						AND $regtable.active != '0'";
					//	ORDER BY " . $sort_criteria;
		
		$count_query = "SELECT COUNT(*) " .  $query_base;
		$record_query = "SELECT DISTINCT $myfields " .  $query_base;
							
	} else {
			$query_base = 	"FROM $regtable
							JOIN $usertable ON ($regtable.user_id = $usertable.ID)
							WHERE $regtable.active!='0' $filteroptions $filtertime ORDER BY $regtable." . $sort_criteria . " " . $sortorder;
					/*	if($limits||$max)	{
							$record_query.= " LIMIT " . $limits . "," . $max; 
						} */
							
			$count_query = "SELECT COUNT(*) " .  $query_base;
			$record_query = "SELECT $myfields " .  $query_base;
			
			if($limits||$max)
				$record_query.= " LIMIT " . $limits . "," . $max; 			
		
		}
		


			
		

	
	//dump($count_query);
	//dump($record_query);
	
	$record_count = $wpdb->get_results($count_query);
	$record_details = ($object) ? $wpdb->get_results($record_query) :  $wpdb->get_results($record_query, ARRAY_A);
	
	//dump($record_details);
	
	
	$binderDeets->records = $record_details;
	$binderDeets->count = $record_count;
	return $binderDeets;
	
}


function getBinderTypes() {
	global $wpdb;
	$transction_table = AOF_bindertable;		
	$formatted_results=array();
	$all_options = "SELECT DISTINCT status
					FROM $transction_table";

	$query_results = $wpdb->get_results($all_options, ARRAY_N);		

	foreach($query_results as $oneresult)
		$formatted_results[] = $oneresult[0];
		
	return $formatted_results;		
}

function getBindersBy($metric = 'YEAR') {
	global $wpdb;
	$transction_table = AOF_bindertable;		
	$formatted_results=array();
	$all_options = "SELECT DISTINCT $metric(date_added)
					FROM $transction_table";

	$query_results = $wpdb->get_results($all_options, ARRAY_N);		

	foreach($query_results as $oneresult)
		$formatted_results[] = $oneresult[0];
		
	return $formatted_results;		
}


?>