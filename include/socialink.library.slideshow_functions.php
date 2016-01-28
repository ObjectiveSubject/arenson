<?php
 
	//KIRK SLIDESHOW GALLERY FUNCTION
 	function get_hero_slides($args=array()) {
		global $wp_query;
		global $post;
	 	$defaults = array(
	 		'id' 					=> '',
	 		'class' 			=> '',
	 		'image_size' 	=> 'hero_slideshow',
	 		'full_bleed' 	=> true,
	 		'with_fade' 	=> false,
	 		'slides' => false,
	 	);
	 	$args = wp_parse_args( $args, $defaults );
	 	
	 	if ( $args['slides'] ) { // will use specified 'slides' array
 	
		 	ob_start(); ?>
	 		<div id="<?php echo $args['id']; ?>" class="slideshow hero-slides <?php echo $args['class']; ?>">
				<?php foreach($args['slides'] as $slide) : ?>
				<div class="slide <?php echo ($args['full_bleed']) ? 'full-bleed' : 'no-full-bleed'; ?>">
					<?php echo wp_get_attachment_image($slide[slide_image], $args['image_size']); ?>
					<? if ($args['with_fade']) { ?><div class="fade"></div><? } ?>
					<? if ($slide[slide_large_text] || $slide[slide_small_text]) { ?>
					<div class="text">
						<div class="centering_box">
							<? if ($slide[slide_large_text]) { ?><h3 class="large-text"><?php echo $slide[slide_large_text]; ?></h3><? } ?>
							<? if ($slide[slide_small_text]) { ?><div class="small-text"><?php echo $slide[slide_small_text]; ?></div><? } ?>
						</div>
					</div>
					<? } ?>
				</div>
				<?php endforeach; ?>
			</div>
	
			<?php 
			$hero_slides_output = ob_get_clean();
			return $hero_slides_output;

	 	} else { // Will use child attachments of current post
	 		
	 		$childArgs = array(
	 			'post_parent' => $post->ID, 
	 			'post_type' => 'attachment',
	 			'order' => 'ASC',
	 			'orderby' => 'menu_order'
	 		);
	 		$post_attachments = get_children($childArgs);
	 		if ($post_attachments) {
			  ob_start(); ?>
				<div id="<?php echo $args['id']; ?>" class="slideshow hero-slides <?php echo $args['class']; ?>">
					<? foreach ($post_attachments as $image) :
					if (get_post_meta($image->ID, 'slide_useinslideshow', true) === "checked") : ?>
					<div class="slide <?php echo ($args['full_bleed']) ? 'full-bleed' : 'no-full-bleed'; ?>">
						<? echo wp_get_attachment_image($image->ID, $args['image_size']); ?>
						<? if ($args['with_fade']) { ?><div class="fade"></div><? } ?>
					</div>
					<? endif; endforeach; ?>
				</div>
				
				<?php
		 		$hero_slides_output = ob_get_clean();
				return $hero_slides_output; 
			} else { 
				return false;
			}
		}

	} // function: get_hero_slides
 
 
 
/*  
		$slideshow_atts = array(
					'id' => $wp_query->post->ID,
					'prefix' => 'frontpage',
					'showmeta' => true
					);
											
		slideshow_gallery($slideshow_atts);		
						
	*/

	//YONI SLIDESHOW GALLERY FUNCTION 2.0
	function slideshow_gallery($args = array()) {

		$defaults = array(
			'id' 						 => '',						//post id
			'prefix' 				 => "",						//prefix for ID and class
			'excludes' 			 => array(0),			//any images to exclude?
			'size' 					 => 'large',			//what size
			'order'					 => 'ASC',				//what order
			'orderby' 			 => 'menu_order',	//ordering how?
			'showmeta' 			 => false,				//display title,caption,description & link
			'addclass'		 	 => "",						//add a special class
			'echo_me'		 		 => true,					//echo or return output
			'onlyslideshows' => false,				//only show images checked with "show in slideshow"
			'fullbleed'		 	 => false,				//full bleed with resizing, makes slide background the imageinstead
		);
		
		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );
		
		if($addclass)
			$addclass = ' ' . $addclass;		
		
		global $wp_query;global $post;$tmp_post = $post;$tmp_query = $wp_query;			//preserve old post/Loops							

		$args = array(
			'post_type' => 'attachment',
			'orderby' => $orderby,
			'order' => $order,
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $id
			); 
			
		$attachments = get_posts($args);	//get all attachments
		
		global $attachment;
		
		$myid=0;
		
		if ($attachments) {
			foreach ($attachments as $attachment) {
				$img_title = apply_filters('the_title', $attachment->post_title);
				$img_url = wp_get_attachment_image_src($attachment->ID, $size);
				
				
				//get all the appropriate values
				$img_description= $attachment->post_content;	//post description section
				$img_caption= $attachment->post_excerpt;		//post's caption section
				$img_alttext= get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
				$img_title= $attachment->post_title;		//Title

				//slide links to
				$slide_destination = get_post_meta($attachment->ID, 'slide_destination', true);			
				$caption_color_class = (get_post_meta($attachment->ID, "slide_captioncolor", true)=='Black') ? 'captioncolor_black' : 'captioncolor_white';

				//anything to exclude?
				$image_id = $attachment->ID;

				if (in_array($image_id,$excludes))
					continue;					
				
				if($onlyslideshows&&(get_post_meta($attachment->ID, 'slide_useinslideshow', true)!="checked"))
					continue;
					
					
				if($img_url[0] != "") {	//as long as its not blank (eg a PDF attachment to a post)
					$myid++;
					//full bleed?
					if($fullbleed)
						$fullbleed="style=\"background-image:url('" . $img_url[0]. "');\"";				

					$output .= "<div class=\"sink_" . $prefix . "_slide$addclass\" id=\"sink_" . $prefix . "_slide" . $myid  . "\" $fullbleed >";
					
					if(!$img_alttext)
						$img_alttext = $img_title;
						
					if(!$fullbleed)
						$output .= "<img src=\"" . $img_url[0] . "\" id=\"sink_" . $prefix . "_img_" . $myid . "\" alt=\"" . $img_alttext . "\" class=\"sink_" . $prefix . "_img$addclass\" />\n";
						
						if($showmeta) {
								if($slide_destination) {
									$linked_title = "<a href=\"$slide_destination\">$img_title</a>";
									$img_caption = "<a href=\"$slide_destination\">$img_caption</a>";
									$img_description = "<a href=\"$slide_destination\">$img_description</a>";
									
									}
								else
									$linked_title = $img_title;
									
								$output .= "<div class=\"yc_slidemeta $caption_color_class\">									
												<h2 class=\"slide_details slide_details_title\">$linked_title</h2>
												<span class=\"slide_details slide_details_caption\">$img_caption</span>
												<span class=\"slide_details slide_details_desc\">$img_description</span>										
											</div>";
							}

					$output .= "</div>\n";
				}
			}
		}
		
		$post = $tmp_post; $wp_query = $tmp_query;			//return old post/Loop

		$slideshow_result = new stdClass();
		
		$slideshow_result->code = $output;
		$slideshow_result->count = $myid;
		
		if($echo_me)
			echo $output;
		else
			return $slideshow_result;
										
	}		
	
	// THIS FUNCTION ADDS FIELDS TO THE IMAGE GALLERY POPUP
	function sink_image_attachment_fields_to_edit($form_fields, $post) {
		// $form_fields is a an array of fields to include in the attachment form
		// $post is nothing but attachment record in the database
		//     $post->post_type == 'attachment'
		// attachments are considered as posts in WordPress. So value of post_type in wp_posts table will be attachment
		// now add our custom field to the $form_fields array
		// input type="text" name/id="attachments[$attachment->ID][custom1]"
		$current_caption = (get_post_meta($post->ID, "slide_captioncolor", true)=='Black') ? 'Black' : 'White';
		if($current_caption=='Black')
			$caption_color_html = "<input type='radio' name='attachments[{$post->ID}][slide_captioncolor]' checked value='Black'>Black</ br><input type='radio' name='attachments[{$post->ID}][slide_captioncolor]' value='White'>White (default)</ br>";
		else
			$caption_color_html = "<input type='radio' name='attachments[{$post->ID}][slide_captioncolor]' value='Black'>Black</ br><input type='radio' name='attachments[{$post->ID}][slide_captioncolor]' checked value='White'>White  (default)</ br>";
			
		$form_fields["slide_destination"] = array(
			"label" => __("Slide links to"),
			"input" => "text", // this is default if "input" is omitted
			"value" => get_post_meta($post->ID, "slide_destination", true),
					"helps" => __("Can be an external or internal link; please use http:// in front."),
		);		
		$form_fields["slide_useinslideshow"] = array(
			"label" => __("Use as a slideshow?"),
			"input" => "html", // this is default if "input" is omitted
			"html" 	=> "<input type='hidden' value='' 
				name='attachments[{$post->ID}][slide_useinslideshow]' 
				id='attachments[{$post->ID}][slide_useinslideshow]' />Use in slideshow
			<input type='checkbox' value='checked' 
				name='attachments[{$post->ID}][slide_useinslideshow]' 
				id='attachments[{$post->ID}][slide_useinslideshow]' ". get_post_meta($post->ID, "slide_useinslideshow", true)  ." />",
		);		
		
/*
		$form_fields["slide_captioncolor"] = array(
			"label" => __("Caption Color"),
			"input" => "html", // this is default if "input" is omitted
			"html" 	=> $caption_color_html,
		);
*/

	   return $form_fields;
	}
	// now attach our function to the hook
	add_filter("attachment_fields_to_edit", "sink_image_attachment_fields_to_edit", null, 2);	
	
	/* this will save it when they type it */
	function sink_image_attachment_fields_to_save($post, $attachment) {
		// $attachment part of the form $_POST ($_POST[attachments][postID])
			// $post['post_type'] == 'attachment'
		if( isset($attachment['slide_destination']) ){
			// update_post_meta(postID, meta_key, meta_value);
			update_post_meta($post['ID'], 'slide_destination', $attachment['slide_destination']);
		}		
		if( isset($attachment['slide_useinslideshow']) ){
			// update_post_meta(postID, meta_key, meta_value);
			update_post_meta($post['ID'], 'slide_useinslideshow', $attachment['slide_useinslideshow']);
		}		
/*
		if( isset($attachment['slide_captioncolor']) ){
			// update_post_meta(postID, meta_key, meta_value);
			update_post_meta($post['ID'], 'slide_captioncolor', $attachment['slide_captioncolor']);
		}
*/
		return $post;
	}
	// now attach our function to the hook.
	add_filter("attachment_fields_to_save", "sink_image_attachment_fields_to_save", null , 2);	

?>