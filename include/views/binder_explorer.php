<?php

if(isset($_GET['aofBinderExplorerPP'])){
	$max = intval($_GET['aofBinderExplorerPP']);
	update_option('aofBinderExplorerPP',$max);	
} else {
	$max = get_option('aofBinderExplorerPP') ? intval(get_option('aofBinderExplorerPP')) : 10;
	}

if(isset($_GET['pg'])){
		$p = $_GET['pg'];
	} else {
		$p = 1;
}

if(isset($_POST['mx'])) {	
	$max = $_POST['mx'];
	}	
	
if(isset($_POST['sev'])) {	
	$search_on = $_POST['sev'];
	}	
	 
	 
if(isset($_GET['sortby'])) {	
	$sort_criteria = $_GET['sortby'];
	}	else
	$sort_criteria = 'id';
	
if(isset($_GET['sortorder'])) {	
	$sortorder = $_GET['sortorder'];
	} else
	$sortorder = 'DESC';


if(isset($_POST['filterType'])) {
	$filteroptions = $_POST['filterType'];
}

if(isset($_POST['filterTime'])) {
	$input = $_POST['filterTime'];
	foreach($input as $k=>$v)
		if(!$v)
			unset($input[$k]);
	$filtertime = implode(' AND ', array_map(function ($v, $k) { return $k . "(" . AOF_bindertable . ".date_added)='" . $v . "'"; }, $input, array_keys($input)));
}


//pagination vars

$limit = ($p - 1) * $max;
$prev = $p - 1;
$next = $p + 1;
$limits = (int)($p - 1) * $max;

$current_page = 'aofBinderExplorer';
$thispage = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);
$sortbase = $thispage.'&sortby=';
$current_table = AOF_bindertable;

$allYears = getBindersBy();
$allMonths = getBindersBy('MONTH');

$binders = getAllBinders($sort_criteria, $sortorder, $search_on, $limits, $max, $filteroptions, $filtertime);

$allBinders = $binders->records;

//dump($allBinders);


	?>
	

	<div class="wrap">
			
		<div class="aof_config metabox-holder">
			<h2 class="icon-camera">AOF Dashboard > Binder Explorer</h2>
				
				<div id="post-body">
					<div id="post-body-content" class="has-sidebar-content">

						<div class="section introsection">
											
							<div class="data_manipulation">
								
								<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">

									<select class="export_selector" name="filterType" id="filterType">
										<? $currentclass = 'selected="selected"'; ?>
										
										<option value="">All Types</option>
										<option <? if($filteroptions=='fav') echo $currentclass ?> value="fav">Favorites</option>
										<option <? if($filteroptions=='nofav') echo $currentclass ?> value="nofav">User Binders</option>										
									</select>					
																		
									
									<select class="export_selector" name="filterTime[month]" id="filterMonth">
										<option value="">All Months</option>
										<?	 unset($currentclass);
											if(is_array($allMonths)) {		
											foreach($allMonths as $mth) {

											if(isset($_POST['filterTime'])&&$_POST['filterTime']['month']==$mth) 
												$currentclass = 'selected="selected"';

											?>
												<option <? echo $currentclass ?> value="<? echo $mth ?>"><? echo date("F", mktime(0, 0, 0, $mth, 10)) ?></option>
										<? 
											unset($currentclass);
											} 
										}?>
									</select>			
									
									<select class="export_selector" name="filterTime[year]" id="filterYear">
										<option value="">All Years</option>
										<? if(is_array($allYears)) {		
											foreach($allYears as $year) {

											if(isset($_POST['filterTime'])&&$_POST['filterTime']['year']==$year) 
												$currentclass = 'selected="selected"';
													
											?>
												<option <? echo $currentclass ?> value="<? echo $year ?>"><? echo $year ?></option>
										<? 	unset($currentclass);
											} 
										}?>
									</select>
									
								<div class="search_binders">
											<p><label for="post-search-input" class="descriptor">Keywords</label>
											<input type="text" value="<? echo $search_on ?>" name="sev" id="post-search-input">
											</p>
		
										<? if($search_on) { ?>
											<h4>Found <span class="search_result_count"><? echo count($allBinders) ?></span> results for keyword "<span class="search_result_count"><? echo $search_on ?></span>".</h4>
										<? } ?>

								</div>
							
					
									<p>
										<input type="hidden" value="1" name="pg">
										<input type="hidden" value="<? echo $current_page ?>" name="page">
										<input type="hidden" name="filter" value="Y">
										<input type="submit" class="button-primary" name="submit" value="Filter" />
										<a class="button-primary" href="<?php echo str_replace( '%7E', '~', $_SERVER['PHP_SELF']); ?>?page=<? echo $current_page ?>">Clear Filter</a>
									</p>										
								</form>	

								<div class="clearfix"></div>	
								
								<p class="information icon-info-circled">Click any <span class="icon-down-open"></span> in the table below to see expanded view of a user-created or favorites binder.  In expanded view you'll see all the contents of the binder, and be able to sort by name, quantity or date added by clicking the column header.</p>
								
							</div>							
							
							<div class="clearfix"></div>
							
							<? if(!$search_on) { ?>	
								<div class="history_paginate">
									<p>Page <? echo $p ?></p>
									<form method="get" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">						
									<p>
									<label class="descriptor" for="postperpage">Showing</label><input type="text" class="tinyinput" value="<? echo $max ?>" name="aofBinderExplorerPP" id="postsperpage"><span class="descriptor">Per Page</span>
									</p>
								<input type="hidden" value="<? echo $current_page ?>" name="page">									
									</form>

											
									<? echo aof_paginationDIV(AOF_bindertable, $current_page, $p, $max,$prev,$next); ?>
									
								</div>
							<? } ?>
							
						</div>
				
						<div class="section table_section">
						
						
							<table class="widefat imagetable">
							
							
								<thead>
									<tr>
										<th class="manage_col">View</th>
										<th>User</th>
										<th>Name</th>
										<th>Description</th>
										<th>Created</th>									
									</tr>
								</thead>
								
								<tbody>
								
									<? if($allBinders) {
										foreach($allBinders as $binder) {
											global $post;
											
											$userinfo = get_userdata($binder->user_id);
											$items = get_binder_items($binder->id);
											$binder_title = ($binder->name!='My Favorites') ? $binder->name : "User Favorites Album";
											
										?>
										
										<tr class="binder_overview resultinfo<? echo $binder->id ?>" id="resultoverview<? echo $binder->id ?>">
											<td class="manage_col">
												<? if($items) { ?>
													<a class="target_accordion_link" href="#resultdetail<? echo $binder->id ?>"></a>
												<? } ?>
											</td>
											<td>
												<a target="_blank" title="Click here to read more about <? echo $userinfo->first_name ?> <? echo $userinfo->last_name ?>" href="<? echo admin_url('') ?>/user-edit.php?user_id=<? echo $binder->user_id ?>"><? echo $userinfo->first_name ?> <? echo $userinfo->last_name ?></a>
											</td>
											<td><? echo $binder_title ?></td>
											<td><? echo $binder->description ?></td>
											<td><? echo $binder->date_added ?></td>
											
											</tr>

											<? 
												if($items) { 
												?>											
											
											<tr class="binder_deets resultinfo<? echo $binder->id ?>" id="resultdetail<? echo $binder->id ?>">
												<td colspan="5">
													<table class="tablesorter binder_item_layout">
														<thead>
															<tr>
																<th>Item Name</th>
																<th>Quantity</th>
																<th>Added</th>
															</tr>
														</thead>
															<? foreach($items as $item) {
																	$post = get_post($item->product_id);
																	setup_postdata($post);
																
																?>
																<tr>
																	<td>
																		<li data-binder="" data-item_id="<? echo $item->id ?>"><a href="<? echo admin_url('post.php') ?>?post=<? echo $item->product_id ?>&action=edit"><? the_title() ?></a>
																	</td>
																	<td><? echo $item->quantity ?></td>
																	<td><? echo $item->date_added ?></td>
																</tr>
															<? } ?>
													
														
													</table>

												
												</td>
											
											</tr>									
											
										<? }
										}
									} else { ?>
										<tr>
											<td colspan="5"><b>Sorry, we couldn't find any binders with that criteria. Try changing your filter options and reloading the page.</b></td>
										
										</tr>
									<? } ?>
								
								</tbody>
								
								<tfoot>
									<tr>
										<th class="manage_col">View</th>
										<th>User</th>
										<th>Name</th>
										<th>Description</th>
										<th>Created</th>
										
									</tr>
								</tfoot>
								
								
								
							</table>
						
						
						
						</div>
						
						
						
						
					</div>
				
				</div>
				
				

		</div>
		
	 </div>