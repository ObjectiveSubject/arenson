<?php get_header();
	$user_id=get_cur_user_id();
	$isClient=isClient($user_id);
	$max_items_before_scrolling = 5;
 ?>

		<div id="primary" class="site-content client-dashboard">
		
			<div class="page-header yellow">
				<div class="centering_box">
					<h1 class="page-title">
						Welcome Back<br />
						<span class="page-subtitle small lightweight"><? echo get_firstname() ?> <? echo get_lastname(false) ?>.</span><br />
						<? if($isClient) { ?> 
							<span class="dashboard_company lightweight small"><? echo get_the_author_meta('member_company', $user_id ) ?> </span>
						<? } ?>
					</h1>
				</div>
			</div><!-- .page-header -->

			<?php echo get_user_dash(); ?>
		
			<div id="content class" class="page" role="main"> 
				
			
				<?php if ($isClient) { echo getClientDash($user_id); } ?>
					
				<div class="mybinders">
					<div class="centering_box" id="binder_intro"><h2>My Project Binders</h2></div>
		
					<div class="binders_existing">
				
				
				
				
						<? // USER BINDERS ------------------------------------------ //
						
						$mybinders = array_reverse(getBinders($user_id,true));
						foreach($mybinders as $binder) :
						
							$binder_items = get_binder_items($binder['id']);
							$binder_item_class = 'binder_items_' . count($binder_items);
							
							if(count($binder_items) > $max_items_before_scrolling) 
								$binder_countainer_class='binder_scrolling'; 
							elseif(!$binder_items)
								$binder_countainer_class='emptybinder';
							elseif(count($binder_items) > 0)
								$binder_countainer_class='binder_normal';									
									
							$binder_id='binder_'.$binder['id'];
							$binder_items_id='binder_items_'.$binder['id']; ?>
							
							<div class="collection_frame one_binder shadow_module <? echo $binder_countainer_class.' '.$binder_item_class; ?>" id="<? echo $binder_id ?>" rel="<? echo $binder['id'] ?>">
								<div class="collection_header centering_box">
									<h3 class="collection_name"><span class="icon icon-ar_binder"></span> <a href="<? echo home_url('binder') ?>?b=<? echo $binder['hash'] ?>"><? echo $binder['name'] ?></a></h3><span class="viewbinder viewmore"><a href="<? echo home_url('binder') ?>?b=<? echo $binder['hash'] ?>">View Project Binder</a></span>
									<div class="collection_desc">
										<p><? echo $binder['description']; ?></p>
										<? if (!$binder_items) { ?><p><strong>This Project Binder is empty. To start adding products to your binder, browse our <a href="<? echo site_url('products'); ?>">Products</a></strong></p><? } ?>
									</div>
								</div>
									
								<?php 
									if(count($binder_items) > $max_items_before_scrolling) 
										$binder_class='scrollbinder'; 
									elseif(!$binder_items)
										$binder_class='emptybinder';																			
									elseif(count($binder_items) > 0)
										$binder_class='centering_box_items'; ?>									
									
									<div class="binder_items <? echo $binder_class; ?>" id="<? echo $binder_items_id; ?>">
										<?php if($binder_items) { ?>
											<ul class="slides slide-form">
											<?php echo itemsShowOverviews($binder_items,$binder['id']); ?>												
											</ul>
										<?php } ?>
									</div>
									<?php if($binder_items) { ?>
										<div class="item_navigators"  id="item_navigator_<? echo $binder_items_id ?>">
											<div class="clearfix"></div>
										</div>		
									<?php } ?>
									
								<div class="clearfix"></div>
							</div> <!-- .one_binder -->
								
						<?php endforeach; ?>		
	
	
	
	
	
						<? // FAVORITES BINDER ------------------------------------------ //
						
						$favebinder_hash = getFavoritesBinder($user_id,true);
						$binder_items = getFavorites($user_id);
						$binder_class = (count($binder_items)>$max_items_before_scrolling) ? 'binder_scrolling' : 'binder_nonscrolling';
						$collection_items_class = (count($binder_items)>$max_items_before_scrolling) ? 'scrollbinder' : 'centering_box_items';
						$binder_item_class = 'binder_items_' . count($binder_items);
						$binder_id='binder_favorites'; ?>
											
						<div class="collection_frame one_binder favorites_binder <? echo $binder_class ?> <? echo $binder_item_class ?>" rel="<? echo $binder['id'] ?>">
							<div class="collection_header centering_box">
								<h3 class="collection_name"><span class="icon icon-ar_fav-closed"></span> My Favorite Items</h3>
								<span class="viewbinder viewmore"><a href="<?php echo home_url('binder') ?>?b=<? echo $favebinder_hash ?>">View all</a></span>
							</div>
						
							<div id="<?php echo $binder_id ?>" class="collection_items binder_items <? echo $collection_items_class ?>">	
								<ul class="slides slide-form">
									<?php	echo itemsShowOverviews($binder_items,$favebinder_hash); ?>		
								</ul>
								<div class="clearfix"></div>
							</div>
							
							<div class="item_navigators"  id="item_navigator_<? echo $binder_id ?>">
								<div class="clearfix"></div>
							</div>							
						</div><!-- .one_binder -->
						
						
					</div> <!-- .binders_existing -->
					
					
					
					<? // CREATE BINDER ------------------------------------------ // ?>
					<div class="create_binder centering_box">
						<h2>Create New Binder</h2>
						
						<form method="post" id="dashboard_createbinder" name="dashboard_createbinder" rel="<? echo $user_id ?>">	
							<label id="binder_name_revise" class="error_labels">Please enter a name for the Project Binder</label>
							<input type="text" value="Title" title="Title" class="newbinder_fields aof_input clearMeFocus" id="binder_create_name" name="binder_create_name" />
							<textarea name="binder_create_desc" title="Description (optional)" class="newbinder_fields aof_input clearMeFocus" id="binder_create_desc">Description (optional)</textarea>		
							<input type="submit" value="Add" id="" class="aof_button" />
						</form>
						
						<div id="binder_confirm" class="action_alerts">
							<p class="db_message"></p>
						</div>
					
					</div><!-- .create_binder -->
					
				</div>				
								
			</div><!-- #content -->
		</div><!-- #primary .site-content -->


<?php get_footer(); ?> 