<?php 

$binderHash=sanitize_user_inputs($_GET["b"]);
$binder_info=get_binder_by_hash($binderHash);
checkBinderAccess($binder_info, $binderHash); //naughty, you can't see other's binder!

get_header(); 

if (getFavoritesBinder(get_cur_user_id()) == $binder_info->id) { $isFavoritesBinder = true; }
$binderClass = $isFavoritesBinder ? 'binder_favorites' : 'binder_normal';
$myBinder = (get_cur_user_id() == $binder_info->user_id) ? true : false; ?>

	<div id="primary" class="<? echo $binderClass ?> site-content binder-page">
			
			<div class="page-header yellow">
				<div class="centering_box">
					<h1 id="binder_bindername" class="page-title">
						<span class="bindername"><? echo $binder_info->name; ?></span><br />
						<? if (!$isFavoritesBinder &&  $binder_info->description) { ?> 
							<span class="binder_description page-subtitle small lightweight">
								<? echo $binder_info->description; ?>
							</span>
						<? } ?>
					</h1>
					<? if (!$isFavoritesBinder) { ?><h5 class="binder_timestamp">Created <? echo date("M d, Y", strtotime($binder_info->date_added)); ?></h5><? } ?>

					<? if (!$isFavoritesBinder && $myBinder) : ?>
				
					<div class="binder_tool_containers">
					
						<div id="binder_tool_edit_box"  class="binder_action_box">
							<h4>Edit this binder:</h4>
							<form class="binder_edit_form" rel="<? echo $binder_info->id ?>">
								<input type="text" class="clearMeFocus" id="binder_new_title" value="<? echo $binder_info->name ?>" title="<? echo $binder_info->name ?>" rel="<? echo $binder_info->id ?>" />
								<textarea id="binder_new_desc" class="clearMeFocus"  title="<? echo $binder_info->description ?>" rel="<? echo $binder_info->id ?>" /><? echo $binder_info->description ?></textarea>
								<input type="submit" value="Change" class="aof_button" />
							</form>
							<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
						</div>						
						
						<div id="binder_tool_delete_box" class="binder_action_box">
							<h4>Are you sure you want to delete this binder?</h4>
							<a href="#" class="aof_button" id="binder_trash_binder" rel="<? echo $binder_info->id ?>">I'm sure</a>
							<p class="message delete_message"></p>
							<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
						</div>	
						
						<div id="binder_tool_ajax_box" class="binder_action_box">
							<h4>Request a Quote</h4>
							<p class="message share_response"></p>
							<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
						</div>		
						
						<div id="binder_tool_dl_box" class="binder_action_box">
							<h4>Download Binder</h4>
							<p><a target="_blank" href="<? echo get_permalink() ?>?dx=<? echo $binderHash ?>&tx=b" class="aof_button">Download Binder</a>&nbsp;&nbsp;&nbsp;<span class="message explanation">Will open in separate window</span></p>
							<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
						</div>		
						
						<div id="binder_tool_email_box" class="binder_action_box">
							<h4>Email This Binder</h4>
							<form class="binder_email_form" rel="<? echo $binderHash ?>">
								<input type="text" class="clearMeFocus required email" id="binder_email_destination" value="Enter email" title="Enter email" rel=">" />
								<input type="submit" value="Send" class="aof_button" />
								<p class="message share_response"></p>
							</form>
							<a href="#" class="close-btn"><span class="icon icon-ar_close"></span></a>
						</div>
					
					</div><!-- .binder_tool_containers -->
				
					<? endif; ?>

				</div><!-- .centering_box -->
			</div><!-- .page-header -->

			<? if (!$isFavoritesBinder && $myBinder) : ?>
			<div class="binder_toolbox metaContentBlackBar clearfix">
				<div class="centering_box">
					<ul>
						<li class=""><a class="binder_tool_continue" id="binder_tool_sendbinder" rel="<? echo $binderHash ?>" href=""><span class="icon icon-ar_send-binder"></span> Request a Quote</a></li>
						<li class="even"><a class="binder_tool_continue" id="binder_tool_share_download" rel="binder_tool_dl_box" href=""><span class="icon icon-ar_dwnld-binder"></span> Download Binder</a></li>
						<li class="third"><a class="binder_tool_continue" id="binder_tool_share_email" rel="binder_tool_email_box" href=""><span class="icon icon-ar_share-binder"></span> Share Binder</a></li>
						<li class="even lower_row"><a id="binder_tool_seeall" href="<? echo get_bloginfo('url') ?>/dashboard"><span class="icon icon-ar_see-binder"></span> See all binders</a></li>
						<li class="lower_row"><a class="binder_tool_continue" id="binder_tool_edit" rel="binder_tool_edit_box" href=""><span class="icon icon-ar_edit-binder"></span> Edit Binder Info</a></li>
						<li class="lower_row even third"><a class="binder_tool_continue" id="binder_tool_delete" rel="binder_tool_delete_box" href=""><span class="icon icon-ar_close"></span> Delete Binder</a></li>
					</ul>
				</div>
			</div>
			<? endif; ?>



			<div id="content" class="page" role="main">		
				
				<div class="binder_items">
					<div class="centering_box">
					<? 	$binder_items = get_binder_items($binder_info->id);
						$itemindex=0;

						if(is_array($binder_items)) {
						//var_dump($binder_items);
						foreach($binder_items as $item) {
							$itemindex++;
							$args = array(
								'post_type' => 		'any',
								'p'	=>	 $item->product_id,
								'suppress_filters'	=>	true
							);			
							$myitem = get_posts( $args );
							foreach($myitem as $post) {
								setup_postdata($post);
								$itemcode=$binder_info->id . ":" . $item->id;
							
								?>

								<div class="binder_product_overview <? echo ($itemindex % 2) ? 'odd' : 'even' ?>"  id="binder_overview_row<? echo $itemcode ?>" rel="<? echo $itemcode ?>">
									<h3><a href="<? the_permalink() ?>"><? the_title() ?></a></h3>
									<div class="item_image binder_item_image" rel="<? echo $post->ID ?>"><a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a></div>
									
									<div class="binder_item_desc" id="imgdesc<? echo $post->ID ?>" ><p><? echo get_the_excerpt() ?></p></div>
																		
									<div class="binder_item_info">
										<table>
											<tbody>
											
											<?if(!$isFavoritesBinder&&$myBinder) { ?>
												<tr>
													<td class="item_desc">Quantity&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="binder_tool binder_item_changequantity" rel="<? echo $itemcode ?>">Edit</a></td>
													<td class="item_value">
														<span class="item_current_quantity" rel="<? echo $itemcode ?>"><? echo $item->quantity ?></span>
														<span rel="<? echo $itemcode ?>" class="changed_quantity_success explanation">Quantity changed</span>
														<div class="item_quant_change" rel="<? echo $itemcode ?>">
															<form class="quantity_change_form">
																<input type="text" class="item_new_quantity" value="<? echo $item->quantity ?>" title="<? echo $item->quantity ?>" rel="<? echo $itemcode ?>" />
															</form>
														</div>
													</td>
												</tr>	
											<? } ?>
												
												<tr>
													<td class="item_desc">Added</td> 
													<td class="item_value"><? echo date("M d, Y", strtotime($item->date_added)) ?></td>
												</tr>												
												<tr>
													<td class="item_desc">Item Number</td>
													<td class="item_value"><? the_field('productArensonSKU') ?></td>
												</tr>												
												<tr>
													<td class="item_desc">
														<?if($myBinder||$isFavoritesBinder) {
															$delete_text = $isFavoritesBinder ? 'Unfavorite' : 'Delete';
															?>
															<a class="binder_iconic_links binder_tool binder_item_delete" rel="<? echo $itemcode ?>" href=""><span class="icon icon-ar_close"></span><? echo $delete_text ?></a>
														<? } ?>
													</td>
													<td class="item_value">
														<a class="binder_iconic_links binder_tool binder_item_downloadpdf" target="_blank" href="<? echo get_permalink($item->product_id) ?>?dx=<? echo $item->product_id ?>&tx=s" rel="<? echo $item->id ?>"><span class="icon icon-ar_dwnld-binder"></span>Download Item PDF</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>	
									<div class="clearfix"></div>
								</div>

							
							
							<?	} 
						}

					} else {?>
					
						<div class="empty_binder">
							<?	if(!$isFavoritesBinder)
									$empty_binder_msg = 'You currently have no favorites selected.';
								else
									$empty_binder_msg = 'This binder is empty. Please visit our products and add an item to get started.';

								?> 
							<h3><? echo $empty_binder_msg ?></h3>
						</div>
					
					<? } ?>
				</div>
			</div>
			
			</div><!-- #content -->
		</div><!-- #primary .site-content -->

				
<?php get_footer(); ?>