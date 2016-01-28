/* ****************
SOCIAL INK LIBRARY:: 
WP BACKEND
DO NOT REPRODUCE WITHOUT PERMISSION
********************************************** */

jQuery(document).ready(function($) {
/*	$('#acf-productSubheader').append('<p class="socialink_backend_p">Characters remaining: <span id="subheader_counter"></span>.</p>');
	$('#acf-productSubheader input[type=text]').simplyCountable({
		counter:            '#subheader_counter',
	});
*/


//

if ($('.binder_item_layout').length > 0) {
 $(".binder_item_layout").tablesorter(); 
}


	
	$(".target_accordion_link").click(function(e) {
		var openbox = $(this).attr('href');
		$(this).toggleClass('opened_box');
		$(this).parents('.binder_overview').toggleClass('opened_box');
		$(openbox).fadeToggle('medium');
		$(openbox).toggleClass('opened_details');
		e.preventDefault();
	});


});		