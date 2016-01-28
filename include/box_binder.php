<?php 
$thispage_hash = create_hash();
ob_start() ?>	

	<div class="form_container">

		<h3 class="addtobinder_title"><? echo $binderadd_title ?></h3>
		
		<div class="close_window_button"><a href="#" class="close_fancybox" rel="login_form"><span class="icon icon-ar_close"></span></a></div>
		
		<form method="post" id="binder_additem<? echo $thispage_hash ?>" class="binder_additem" name="binder_additem" rel="<? echo $prod_id ?>">	
			
			<input type="hidden" id="binder_functionality" value="adding_simple" />
				
			<div id="binder_add_section" class="form_module open">
				<p rel="#binder_submodule_existing<? echo $thispage_hash ?>" class="binder_accordion_group"><a href="#binder_submodule_existing<? echo $thispage_hash ?>" class="binder_accordion">Add to Existing Project Binder<span class="icon"></a></p>
				<div class="binder_module_container clearfix" id="binder_submodule_existing<? echo $thispage_hash ?>">
					<? $mybinders=getBinders(get_cur_user_id());
						//$mybinders=$mybinders[0]; ?>
					<span class="binder_select binder_sublabel">Select</span>	
					<select name="binder_existing" id="binder_existing" class="aof_select">
						
						<!--<option value="newb">Choose Binder or Create New Below</option>-->
						<? foreach($mybinders as $onebinder) { ?>
							<option value="<? echo $onebinder['id']?>"><? echo $onebinder['name']?></option>
						<? } ?>						
					</select>
					<div class="clearfix"></div>
				</div>
				
			</div> 		
			
			<div id="binder_create" class="form_module">
				<p rel="#binder_submodule_new<? echo $thispage_hash ?>" class="binder_accordion_group"><a href="#binder_submodule_new<? echo $thispage_hash ?>" class="binder_accordion">Or Create a new Project Binder<span class="icon"></span></a></p>
				<div class="binder_module_container clearfix" id="binder_submodule_new<? echo $thispage_hash ?>">
					<span class="binder_select binder_sublabel">Name (24 characters)</span>
					<input type="text" value="eg Front Lobby" title="eg Front Lobby" class="newbinder_fields aof_input clearMeFocus" maxlength="24" id="binder_create_name" name="binder_create_name" />
					<span class="text_countdown" id="binder_create_name_counter"></span>
					<br /><br />
					<span class="explanation binder_sublabel">Enter description (optional)</span>
					<textarea name="binder_create_desc" title="eg. These are items for the front lobby with a blue and gray color scheme." class="newbinder_fields aof_input clearMeFocus" id="binder_create_desc" maxlength="140">eg. These are items for the front lobby with a blue and gray color scheme.</textarea>
					<span class="text_countdown" id="binder_create_desc_counter"></span>
				</div>
			</div>		
			
			<div id="binder_quantity" class="form_module">
				<label for="binder_item_quantity" class="thecaption">Quantity</label>
				<input type="text" value="1" title="1" class="aof_input clearMeFocus" id="binder_item_quantity" name="binder_item_quantity" />
				<div class="clearfix"></div>
			</div>
			<br />
			
			<div class="login_buttons menu_horizontal">
				<ul>
					<li class="left_button cancel"><a class="aof_button close_fancybox" href="#">Cancel</a></li>
					<li class="right_button submit"><input type="submit" name="itemAdding_quote" value="<? echo $binderadd_button ?>" id="add_item_request_quote" class="aof_button" /></li>
				</ul>
			</div>	
			
			<div class="clearfix"></div>
			
		</form>
	
	</div>

	<? 
	$good_html = ob_get_clean();
?>