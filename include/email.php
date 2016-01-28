<?php
//AOF EMAIL FUNCTIONALITY
//YONATAN REINBERG 2012.


$debug=false;


add_action( 'wp_ajax_nopriv_email_sendBinderAOF', 'email_sendBinderAOF_ajax' );
add_action( 'wp_ajax_email_sendBinderAOF', 'email_sendBinderAOF_ajax' );

function email_sendBinderAOF_ajax() {
	$binderHash=sanitize_user_inputs($_POST['binderHash']);

	global $post;
	$args=array(
				'p'=>1047,
				'post_type'=>'email_templates'
			);
	$email_template=get_posts($args);
	foreach( $email_template as $post ) :	setup_postdata($post);
		$email_title=get_the_title();
		$email_contents=get_formatted_content();
	endforeach;

	$email_contents=replaceBinderEmailPlaceholders($email_contents,$binderHash,true);
	
	global $debug;

	if(!$debug)
		$emailErrors=aof_emailSend(get_bloginfo("admin_email"), $email_title, $email_contents);
	
	if(!$emailErrors) {
		$binderEmailResponse=array( 
			'SentMessage' =>	"Thank you for your inquiry. Arenson will contact you shortly with a quote.",
			'sent_successfully'	=>	true);
	}else {
		$binderEmailResponse=array( 
			'SentMessage' =>	"Sorry, we couldn't share your binder. Please refresh the page and try again, or contact an administrator.",
			'sent_successfully'	=>	false);	
	}
	
	echo json_encode($binderEmailResponse);
	
	die();
}


add_action( 'wp_ajax_nopriv_email_sendBinder', 'email_sendBinder_ajax' );
add_action( 'wp_ajax_email_sendBinder', 'email_sendBinder_ajax' );

function email_sendBinder_ajax() {
	$binderHash=sanitize_user_inputs($_POST['binderHash']);
	
	$destinationEmail=sanitize_user_inputs($_POST['destinationEmail']);
	
	global $post;
	$args=array(
				'p'=>1045,
				'post_type'=>'email_templates'
			);
	$email_template=get_posts($args);
	foreach( $email_template as $post ) :	setup_postdata($post);
		$email_title=get_the_title();
		$email_contents=get_formatted_content();
	endforeach;

	$email_contents=replaceBinderEmailPlaceholders($email_contents,$binderHash,true);
	
	global $debug;

	if(!$debug)
		$emailErrors=aof_emailSend($destinationEmail, $email_title, $email_contents);
	
	if(!$emailErrors) {
		$binderEmailResponse=array( 
			'SentMessage' =>	"Thanks, we sent the binder to $destinationEmail.",
			'sent_successfully'	=>	true);
	}else {
		$binderEmailResponse=array( 
			'SentMessage' =>	"Sorry, we couldn't share your binder. Please refresh the page and try again, or contact an administrator.",
			'sent_successfully'	=>	false);	
	}
	
	echo json_encode($binderEmailResponse);
	
	die();
}


add_action( 'wp_ajax_nopriv_email_sendProduct', 'email_sendProduct_ajax' );
add_action( 'wp_ajax_email_sendProduct', 'email_sendProduct_ajax' );

function email_sendProduct_ajax() {
	$productID=sanitize_user_inputs($_POST['productID']);

	$destinationEmail=sanitize_user_inputs($_POST['destinationEmail']);
	
	global $post;
	$args=array(
				'p'=>1049,
				'post_type'=>'email_templates'
			);
	$email_template=get_posts($args);
	foreach( $email_template as $post ) :	setup_postdata($post);
		$email_title=get_the_title();
		$email_contents=get_formatted_content();
	endforeach;

	$email_contents=replaceProductEmailPlaceholders($email_contents,$productID,true);
	
	global $debug;

	if(!$debug)
		$emailErrors=aof_emailSend($destinationEmail, $email_title, $email_contents);
	
	if(!$emailErrors) {
		$binderEmailResponse=array( 
			'SentMessage' =>	"Thanks, we shared this product with $destinationEmail.",
			'sent_successfully'	=>	true);
	}else {
		$binderEmailResponse=array( 
			'SentMessage' =>	"Sorry, we couldn't share this product. Please refresh the page and try again, or contact an administrator.",
			'sent_successfully'	=>	false);	
	}
	
	echo json_encode($binderEmailResponse);
	
	die();
}

	
	
	function aof_emailSend($userEmail,$subject,$email_contents) {
		//$user_info = get_userdata($user_id);

		$fromEmail="Arenson <" . get_bloginfo("admin_email") . ">";

		//$emailDestination="$user_info->first_name $user_info->last_name <$userEmail>";
		$emailDestination=$userEmail;
		$emailReceiptSubject=$subject;
		//headers
		$emailReceiptHeaders = 	"From: $fromEmail \r\n";
		$emailReceiptHeaders.= 	"Reply-To: $fromEmail \r\n";
		
		// To send HTML mail, the Content-type header must be set
		$emailReceiptHeaders.= 'MIME-Version: 1.0' . "\r\n";
		$emailReceiptHeaders.= 'Content-type: text/html; charset=UTF-8' . "\r\n";		
		
		ob_start(); ?>
		
			<html>
				<head>
				<style type="text/css" media="all">
				 <!--
				 body {background:white;color: #4D4D4D;font-family: Helvetica,Arial,"sans serif";font-size: 13px; } -->
				 </style>
				</head>
				<body style="background:white;">		
					<? echo $email_contents ?>	
				</body>
			</html>
		<? 
		$emailReceiptBody.=ob_get_contents();
		ob_end_clean();
				 
		if(wp_mail($emailDestination, $emailReceiptSubject, $emailReceiptBody, $emailReceiptHeaders))
			$errors=null;
		else
			$errors="Could not send email";

		if($errors)
			return $errors;
		else
			return false;
		}	
	
	
	function replaceProductEmailPlaceholders($responseString,$productID) {
				
		$productSubheader= get_post_meta($productID, 'productSubheader', true);
		
		$replacement_keys = array( 	
									'[sharer_username]' => get_cur_username(),
									'[sharer_firstname]' => get_firstname(),
									'[sharer_lastname]' => get_lastname(),
									'[sharer_email]' => get_cur_email(),
									'[product_name]' => get_prod_name($productID),
									'[product_description]' => get_prod_description($productID),
									'[product_subheader]' => $productSubheader,
									'[product_link]' =>  "<a href=\"" . get_permalink($productID) . "\">click here</a>",
									'[product_pdf_link]' =>  "<a href=\"" . get_permalink($productID) . "?dx=$productID&tx=s\">click here</a>",
									);
									
		foreach($replacement_keys as $original => $replacement) {
			$span_class=substr($original,1,strpos($original,"]")-1);
			$responseString =  str_replace($original, "<span class=\"aof_$span_class\">".$replacement."</span>", $responseString);			
		}		

		$responseString = '<p>' . $responseString . '</p>';	
		return $responseString;
	}	
	

	
	function replaceBinderEmailPlaceholders($responseString,$binderHash, $includeOwner=false) {
				
		$binder_info=get_binder_by_hash($binderHash);
		$binder_items = get_binder_items($binder_info->id);
		
		$replacement_keys = array( 	
									'[binder_owner_username]' => get_cur_username(),
									'[binder_owner_firstname]' => get_firstname(),
									'[binder_owner_lastname]' => get_lastname(),
									'[binder_owner_email]' => get_cur_email(),
									'[binder_owner_phone]' => get_cur_phone(),
									'[binder_name]' => $binder_info->name,
									'[binder_list]' => formatBinderItemsList($binder_items),
									'[binder_description]' =>  $binder_info->description,
									'[binder_link]' =>  "<a href=\"" . home_url('binder') . "?b=$binderHash\">click here</a>",
									'[binder_date]' => date("F d g:ia", strtotime($binder_info>date_added)),
									);
									
		foreach($replacement_keys as $original => $replacement) {
			$span_class=substr($original,1,strpos($original,"]")-1);
			$responseString =  str_replace($original, "<span class=\"aof_$span_class\">".$replacement."</span>", $responseString);			
		}		

		$responseString = '<p>' . $responseString . '</p>';	
		return $responseString;
	}	
	
		function formatBinderItemsList($binder_items) {
			if(is_array($binder_items)) {
			
					$binderoutput.='<ul>';
					
					foreach($binder_items as $item) {
						$itemindex++;
						$args = array(
							'post_type' => 		'products',
							'p'	=>	 $item->product_id,
						);			
						$myitem = get_posts( $args );
							global $post;
						foreach($myitem as $post) {
							
							setup_postdata($post);
							
							$binderoutput.='<li><a href="' . get_permalink() .'">' . get_the_title() .'</a>. Quantity: ' . $item->quantity . '</li>';
						}
					}
					
					$binderoutput.='</ul>';
			}
			else
				$binderoutput.='No items';
				
		return $binderoutput;
		}
	
	function get_formatted_content($more_link_text = '(more...)', $stripteaser = 0, $more_file = '')
	{
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}	


	function isValidEmail($str) {
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
	}

//OVERWRITE DEFAULT EMAIL

add_filter ( 'wp_mail_from', 'aof_output_new_email' );
function aof_output_new_email() {
	return get_bloginfo('admin_email');
}

add_filter ( 'wp_mail_from_name', 'aof_output_new_name' );
function aof_output_new_name() {
	return get_option('blogname');	
}
	
?>