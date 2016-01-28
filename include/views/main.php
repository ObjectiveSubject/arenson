<?php

$allYears = getBindersBy();
$allMonths = getBindersBy('MONTH');

?>
	

	<div class="wrap">
			
		<div  id="" class="aof_config metabox-holder">

			<h2 class="icon-camera">AOF Dashboard</h2>

				<div id="post-body">
					<div id="post-body-content" class="has-sidebar-content">
					
						<div class="section introsection">
							
							<p class="credit">by <a href="http://social-ink.net">Social Ink</a></p>
				
						</div>	
						
						<div class="section">
							<h3>Detailed Binder View</h3>
							<p>Visit the <a href="<? echo admin_url('admin.php?page=aofBinderExplorer') ?>">binder view page for more</a>.</p>
							
						</div>

						<div class="section">
						
							<div class="data_manipulation">
								<h3 class="icon-chart-pie">Binder Offsite Management</h3>
								
								<form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
									<p>Exports the database in a CSV format for data/sorting use in Excel or for import in other programs.</p>
									<p>Note: Empty binders are not part of this export.</p>

									<div class="exportSection">
										<p>Favorites are a kind of binder, so they will be included in the binder, but you can choose to exclude or show only.</p>
										<select class="export_selector" name="filterType" id="filterType">
											<? $currentclass = 'selected="selected"'; ?>
											
											<option value="">All Types</option>
											<option <? if($filteroptions=='fav') echo $currentclass ?> value="fav">Favorites</option>
											<option <? if($filteroptions=='nofav') echo $currentclass ?> value="nofav">User Binders</option>										
										</select>					
									</div>										
									
									
									<div class="exportSection">
										<p>Choose a date range for export.</p>
										<select class="export_selector" name="filterTimeStart[month]" id="filterMonthStart">
											<option value="<? echo date("m", mktime(0, 0, 0, $allMonths[0], 10)) ?>">Start Month (default will be first month in database)</option>
											<?	 unset($currentclass);
												if(is_array($allMonths)) {		
												foreach($allMonths as $mth) {

												if(isset($_POST['filterTimeStart'])&&$_POST['filterTimeStart']['month']==$mth) 
													$currentclass = 'selected="selected"';

												?>
													<option <? echo $currentclass ?> value="<? echo date("m", mktime(0, 0, 0, $mth, 10)) ?>"><? echo date("F", mktime(0, 0, 0, $mth, 10)) ?></option>
											<? 
												unset($currentclass);
												} 
											}?>
										</select>			
										
										<select class="export_selector" name="filterTimeStart[year]" id="filterYearStart">
											<option value="<? echo $allYears[0] ?>">Start Year (default will be first year in database)</option>
											<? if(is_array($allYears)) {		
												foreach($allYears as $year) {

												if(isset($_POST['filterTimeStart'])&&$_POST['filterTimeStart']['year']==$year) 
													$currentclass = 'selected="selected"';
														
												?>
													<option <? echo $currentclass ?> value="<? echo $year ?>"><? echo $year ?></option>
											<? 	unset($currentclass);
												} 
											}?>
										</select>										
										
										<select class="export_selector" name="filterTimeEnd[month]" id="filterMonthEnd">
											<option value="<? echo date('m') ?>">End Month (default this month)</option>
											<?	 unset($currentclass);
												if(is_array($allMonths)) {		
												foreach($allMonths as $mth) {

												if(isset($_POST['filterTimeEnd'])&&$_POST['filterTimeEnd']['month']==$mth) 
													$currentclass = 'selected="selected"';

												?>
													<option <? echo $currentclass ?> value="<? echo date("m", mktime(0, 0, 0, $mth, 10)) ?>"><? echo date("F", mktime(0, 0, 0, $mth, 10)) ?></option>
											<? 
												unset($currentclass);
												} 
											}?>
										</select>			
										
										<select class="export_selector" name="filterTimeEnd[year]" id="filterYearEnd">
											<option value="<? echo date('Y') ?>">End Year (default this year)</option>
											<? if(is_array($allYears)) {		
												foreach($allYears as $year) {

												if(isset($_POST['filterTimeEnd'])&&$_POST['filterTimeEnd']['year']==$year) 
													$currentclass = 'selected="selected"';
														
												?>
													<option <? echo $currentclass ?> value="<? echo $year ?>"><? echo $year ?></option>
											<? 	unset($currentclass);
												} 
											}?>
										</select>			
									</div>						
									

					
									<p>
										<input type="hidden" name="export_aof_binders" value="Y">
										<input type="submit" class="button-primary" name="submit" value="Export" />
									</p>										
								</form>		
							
							</div>	
							

						</div>
						 			

					</div>
				
				</div>
				
				

		</div>
		
	 </div>