<?php
 
add_action( 'parse_request', 'checkPDF' );

function checkPDF() {
	if(isset($_GET['dx'])) {
		$download_id=$_GET['dx'];
		$download_type=$_GET['tx'];
		
		if($download_type=='s') 
			$html = pdf_get_single_product($download_id);
		elseif($download_type=='b') 
			$html = pdf_get_binder($download_id);

		$html->header = getStyles();
		$html->footer = getFooter();
		
		ajax_createPDF($html);
		}
	}


function getStyles() {
	//$style_url=get_bloginfo('template_url').'/styles-pdf.css';
	
	//$header = '<link rel="stylesheet" type="text/css" href="' . $style_url . '" media="screen" />';
	
	$header =  '<style>
					 
					body {
						font-size:11pt;
					}
					
					.pdf_label {
						font-weight:bold;
						font-size:110%;
						margin-right:15px;
					}					
					
					h1 {
						font-weight:bold;
						font-size:50pt;
						margin-bottom:0px !important;
						padding:0px;
						margin-top:0px !important;
						letter-spacing:-4px;
						line-height:3px;
					}	

					table {
					
					}
					td {
					
					}

	
					
					h3 {
						font-weight:bold;
					}
					
					.item_content {
						font-weight:bold;
					}
					
					h4 {
						display:inline-block;
						font-weight:bold;
						font-size:110%;
						margin-right:15px;
						margin-top:25pt;
						line-spacing:0px;
						line-height:0px;
					}
					
					
					table.smalltable {
						font-size:10pt;
						font-weight:bold;
					}
					
					a {
						text-decoration:none;
						font-weight:bold;
						color:black;
					}
					
					td {

					}
					
					.clearfix { clear:both; }

					</style>
					
					<body>
					
					<table class="smalltable">
						<tr>
							<td style="width:50%;text-align:left"><img style="width: 200px; height: auto;" src="' . get_bloginfo('template_url').'/img/arenson_pdf_logo.png" /></td>
							<td style="width:50%;text-align:right">(212) 633 2400<br /><a href="http://aof.com">aof.com</a></td>
						</tr>
					
					</table>
					<br /><br /><br />
					';


	
	return $header;

}

function getFooter() {

	$footer =  '</body>';

	return $footer;

}
	
function pdf_get_binder($binderHash) {

	$newpdf = new stdClass();
	$newpdf->html = array();
	
	$binder_info=get_binder_by_hash($binderHash);
			
	if(getFavoritesBinder(get_cur_user_id())==$binder_info->id)
		$isFavoritesBinder=true;			
					
				ob_start(); 
				?>

				<div class="binder_intro">
					<h1>Binder: <?php echo $binder_info->name ?></h1>
					<h4>Created <? echo date("M d, Y", strtotime($binder_info->date_added)) ?></h4>
					<h3><?	echo $binder_info->description ?></h3>
								
				</div>
			
			
			<?	 
	//	$binder_header .= ob_get_clean();

		$newpdf->binder_header = ob_get_clean();
		$newpdf->binder_id = $binderHash;
		
		//now get all items
		$binder_items = get_binder_items($binder_info->id);

			if(is_array($binder_items)) {
			
				foreach($binder_items as $item) {
					
					$single_prod_html = pdf_get_single_product($item->product_id);
					
				//	var_dump($single_prod_html->html[0]);
					
					$newpdf->html[]= $single_prod_html->html[0];
				}
			}
						
		
		//var_dump($newpdf);
		
		
	//	$newpdf->html[]=$item_formatted;

	return $newpdf;	//return $item_formatted;
}


function pdf_get_single_product($prod_id) {
	$newpdf = new stdClass();
	
		$args = array(
			'post_type' => 		'any',
			'suppress_filters'	=>	true,
			'p'	=>	 $prod_id,
		);			
		$myitem = get_posts( $args );
		global $post;
		foreach($myitem as $post) {
			
			setup_postdata($post);
			$itemcode=$post->ID;
			
			$newpdf->sku = get_post_meta($itemcode, 'productArensonSKU', true);		
			$newpdf->title = get_the_title();
			$newpdf->slug = the_slug();
			$newpdf->product_cat = get_the_terms( $post->ID, 'p_cat' );
			$newpdf->market_cat = get_the_terms( $post->ID, 'markets' );
			$newpdf->tags = get_the_terms( $post->ID, 'p_tag' );
			
			ob_start(); 
			?>

			<div class="item">
				
				
				<table cellspacing="10">
					<tr>
						<td >
							<h1 style="font-weight:bold;font-size:170px; letter-spacing:-4px; line-height: 3px;"><?php the_title(); ?></h1>
						</td>
					</tr>
					<tr>
						<td style="width:45%; vertical-align:top;"  valign="top">
						
							<div class="product_col">				
								
								<div class="item_image" rel="<? echo $post->ID ?>"><a href="<? the_permalink() ?>"><? the_post_thumbnail('product_overviews') ?></a></div>
							</div>
						
						</td>							
						
						<td style="width:10%">&nbsp;	</td>		

						
						<td style="width:45%; vertical-align:top;" valign="top">
				
						<div class="product_col prod_metadata">
							<h3 style="font-weight:bold;"><?	echo $productSubheader ?></h3>
							
							<div class="item_content"  style="font-weight:bold;"><?php echo get_the_content(); ?></div>
							
							<br /><br /><br /><br />
							
							<? if($newpdf->product_cat&&is_array($newpdf->product_cat)) { ?>
							
							<h4 style="display:inline-block; font-weight:bold; font-size:110%; margin-right:15px; margin-top:25pt; line-spacing:0px; line-height:0px;">Product Categories</h4>
								<?$itemindex=0;
									foreach($newpdf->product_cat as $onecat) { 
										$itemindex++;
										echo $onecat->name;
										if($itemindex<count($newpdf->product_cat))
											echo  ', ';
									} ?>
								<br />
							<?	} ?>					
								
							
							<? if($newpdf->market_cat&&is_array($newpdf->market_cat)) { ?>
							<br /><br />
								<h4 style="display:inline-block; font-weight:bold; font-size:110%; margin-right:15px; margin-top:25pt; line-spacing:0px; line-height:0px;">Market</h4>
								<?	$itemindex=0;
									foreach($newpdf->market_cat as $onecat) { 
										$itemindex++;
										echo $onecat->name;
										if($itemindex<count($newpdf->market_cat))
											echo  ', ';
									} ?>
								<br />
							<?	} ?>				
								
							
							<? if($newpdf->tags&&is_array($newpdf->tags)) { ?>
							<br /><br />
							<h4 style="display:inline-block; font-weight:bold; font-size:110%; margin-right:15px; margin-top:25pt; line-spacing:0px; line-height:0px;">Tags</h4>
							
							<?		$itemindex=0;
									foreach($newpdf->tags as $onecat) { 
										$itemindex++;
										echo $onecat->name;
										if($itemindex<count($newpdf->tags))
											echo  ', ';
									} ?>
								<br />
							<?	} ?>	
								
								
						<? 		
					
						global $product_fields;

								foreach($product_fields as $field_value => $explanation ) {
									$metadata = get_post_meta($post->ID, $field_value, true);

									if($metadata) { ?>
								<br />
									<div class="one_data_item">
										<h4 style="display:inline-block; font-weight:bold; font-size:110%; margin-right:15px; margin-top:25pt; line-spacing:0px; line-height:0px;"><? echo $explanation ?>: </h4>
										<br />
										<span class="metadata_value">
										<? if(is_array($metadata)) {
												$count=0;
												foreach($metadata as $onepiece) {
													$count++;
													if($count<count($metadata))
														echo $onepiece .', ';
													else
														echo $onepiece . '.';
												}
											} else
												echo $metadata;
									 ?>
										
										</span>
									</div>
								<?	}

								}?>
								
						</div>
					</td>
					
					
				</tr>
				
				
				</table>
				<div class="binder_link" style="border-top: 5px solid black;"><a class="text-decoration:none;font-weight:bold;color:black;" href="<? the_permalink() ?>"><? the_permalink() ?></a></div>
			</div>
		
		
		<?	} 
		$item_formatted .= ob_get_clean();
		
		$newpdf->html = array();
		
		$newpdf->html[]=$item_formatted;

	return $newpdf;	//return $item_formatted;
}


 
function ajax_createPDF($newpdf) {
	 
	require_once('tcpdf/config/lang/eng.php');
	require_once('tcpdf/tcpdf.php');



	class AOF_SINK_PDF extends TCPDF {


		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'B', 10);
			// Page number
			$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		}
	}


	// create new PDF document
	$pdf = new AOF_SINK_PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Arenson');
	$pdf->SetTitle('Arenson Product');
	$pdf->SetSubject('Arenson Products');
	$pdf->SetKeywords('Arenson Products');

	// set default header data
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING);
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', PDF_HEADER_STRING);
	$pdf->SetPrintHeader(false);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	//set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	//set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//set some language-dependent strings
	$pdf->setLanguageArray($l);

	// ---------------------------------------------------------

	// set font
	//$pdf->SetFont('helvetica', '', 12);



		/* NOTE:
		 * *********************************************************
		 * You can load external XHTML using :
		 *
		 * $html = file_get_contents('/path/to/your/file.html');
		 *
		 * External CSS files will be automatically loaded.
		 * Sometimes you need to fix the path of the external CSS.
		 * *********************************************************
		 */

		// define some HTML content with style
		
		if($newpdf->binder_header==null) {
		
			// add a page
			$pdf->AddPage();
	
			$html = $newpdf->header . $newpdf->html[0] . $newpdf->footer;
		//var_dump($html);

		// output the HTML content
			$pdf->writeHTML($html, true, false, true, false, '');
			
		} else {

			// add a welcome
			$pdf->AddPage();			
			$html_firstpage = $newpdf->header . $newpdf->binder_header;
			$pdf->writeHTML($html_firstpage, true, false, true, false, '');
			
			foreach($newpdf->html as $oneItem) {
				// add a page
				$pdf->AddPage();			
				$pdf->writeHTML($oneItem, false, false, true, false, '');

			}
			
			$footer = $newpdf->footer;
			$pdf->writeHTML($footer, true, false, true, false, '');
			
		
		}

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// *******************************************************************
		// HTML TIPS & TRICKS
		// *******************************************************************

		// REMOVE CELL PADDING
		//
		// $pdf->SetCellPadding(0);
		// 
		// This is used to remove any additional vertical space inside a 
		// single cell of text.

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// REMOVE TAG TOP AND BOTTOM MARGINS
		//
		// $tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		// $pdf->setHtmlVSpace($tagvs);
		// 
		// Since the CSS margin command is not yet implemented on TCPDF, you
		// need to set the spacing of block tags using the following method.

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// SET LINE HEIGHT
		//
		// $pdf->setCellHeightRatio(1.25);
		// 
		// You can use the following method to fine tune the line height
		// (the number is a percentage relative to font height).

		// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

		// CHANGE THE PIXEL CONVERSION RATIO
		//
		// $pdf->setImageScale(0.47);
		// 
		// This is used to adjust the conversion ratio between pixels and 
		// document units. Increase the value to get smaller objects.
		// Since you are using pixel unit, this method is important to set the
		// right zoom factor.
		// 
		// Suppose that you want to print a web page larger 1024 pixels to 
		// fill all the available page width.
		// An A4 page is larger 210mm equivalent to 8.268 inches, if you 
		// subtract 13mm (0.512") of margins for each side, the remaining 
		// space is 184mm (7.244 inches).
		// The default resolution for a PDF document is 300 DPI (dots per 
		// inch), so you have 7.244 * 300 = 2173.2 dots (this is the maximum 
		// number of points you can print at 300 DPI for the given width).
		// The conversion ratio is approximatively 1024 / 2173.2 = 0.47 px/dots
		// If the web page is larger 1280 pixels, on the same A4 page the 
		// conversion ratio to use is 1280 / 2173.2 = 0.59 pixels/dots

		// *******************************************************************

		// reset pointer to the last page
		$pdf->lastPage();

		// ---------------------------------------------------------

		//Close and output PDF document
		if($newpdf->binder_header==null)
			$pdfname = 'aof_product_' . $newpdf->sku;
		else
			$pdfname = 'aof_binder_' . $newpdf->binder_id;
			
		$pdf->Output($pdfname, 'I');
		
		exit();

		//============================================================+
		// END OF FILE                                                
		//============================================================+


}

?>