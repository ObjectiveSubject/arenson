<?

function getBinderforExport($filteroptions, $filtertime) {
	global $wpdb;
	$binder_table = AOF_bindertable;
	$binder_items = AOF_bindertable_meta;
	$post_table = $wpdb->posts;
	$usertable = $wpdb->users;
	$usermetatable = $wpdb->usermeta;

	if($filtertime)
		$filtertime = "AND " . $filtertime;
		
	global $wpdb;

	$myquery = "SELECT $binder_table.name, $usertable.user_nicename, $binder_table.description, $binder_table.date_added, 
				GROUP_CONCAT($binder_items.quantity, ' x ' , $post_table.post_title SEPARATOR '; ') as binder_items, 
				$usermetatable.meta_value, $usertable.user_email, $usertable.user_registered
				FROM $binder_table
				JOIN $binder_items ON ($binder_items.binder_id = $binder_table.id)
				JOIN $post_table ON ($post_table.id = $binder_items.product_id)
				JOIN $usertable ON ($binder_table.user_id = $usertable.ID)
				JOIN $usermetatable ON ($usertable.ID = $usermetatable.user_id AND $usermetatable.meta_key='last_name')
				WHERE $binder_table.active!='0'
				$filteroptions $filtertime
				GROUP BY $binder_table.date_added
				DESC";		

	//dump($myquery);

	$transactionData = ($object) ? $wpdb->get_results($myquery) :  $wpdb->get_results($myquery, ARRAY_A);

	return $transactionData;
}
	
	


//exportation
		
add_action('init','aof_exportBinders'); //added this so you can change headers/content-type without headers already loaded
		
	function aof_exportBinders() {
		global $wpdb;
		
		$binder_table = AOF_bindertable;
		$binder_items = AOF_bindertable_meta;
		$post_table = $wpdb->posts;
		$usertable = $wpdb->users;
		$usermetatable = $wpdb->usermeta;
	
		global $pagenow;
		$data_headers = AOF_export_fields;

		if(isset($_GET['page']))
			if($_POST['export_aof_binders'] == 'Y') {

				if(isset($_POST['filterType'])&$_POST['filterType']!="") {
					if($_POST['filterType']=='fav')
						$filteroptions = "AND $binder_table.name='Favorites' ";
					else
						$filteroptions = "AND $binder_table.name!='Favorites' ";
				}

				if(isset($_POST['filterTimeStart']) && isset($_POST['filterTimeEnd'])  ) {
					$starts = $_POST['filterTimeStart'];
					$ends = $_POST['filterTimeEnd'];
					
					$filtertime = "$binder_table.date_added BETWEEN '" . $starts['year'] . "-" . $starts['month'] . "-01 00:00:00' AND '" . $ends['year'] . "-" . $ends['month'] . "-28 00:00:00'";
					
				}


		
				$data_rows = getBinderforExport($filteroptions, $filtertime);
				$data_headers = AOF_export_fields;
				
				$file_name = 'binder_export' . _ . date('m.d.y') . '.csv';
				
				$lfile = WP_CONTENT_DIR . '/aof_export/' . $file_name;
				
				$fp = fopen($lfile, 'w') or exit("Can't open $lfile!");
				
				fwrite($fp, "$data_headers\n");
				
				foreach ($data_rows as $result) {
					fputcsv($fp, $result);
				} 
				
				fclose($fp);

				//construct URL				
				$external_file = WP_CONTENT_DIR . '/aof_export/' . $file_name;	
				$external_file = realpath($external_file);

				header("Content-type: application/vnd.ms-excel");
				header('Content-Length: ' . filesize($lfile));
				header("Content-Disposition: attachment; filename=" . basename($external_file)); 
				header("Pragma: no-cache");
				header("Expires: 0");						
				readfile($external_file); 
				
				unlink($external_file);

				exit;
		}

	}


?>