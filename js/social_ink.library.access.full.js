/* ****************
SOCIAL INK LIBRARY
LOGGING IN / MEMBERSHIP ACCESS
DO NOT REPRODUCE WITHOUT PERMISSION
********************************************** */

jQuery(document).ready(function($) {

var ajaxLoadingImage = '<img src="'+ aofAJAX.homeURL+ '/wp-content/themes/arenson/img/ajax_loader.png" alt="Processing..." />';

/*
	if($('html').is('.ipad')) {
		$(".ipad .jq_top_nav").click(function(event) {
			event.preventDefault();
			$('.sub-menu').hide();
			$('.jq_top_nav_link').hide();		
				
			if($(this).parent('.menu-item').is('.opened')) {
				$(this).parent('.menu-item').removeClass('opened');	
				$('.menu-item').removeClass('opened');
			} else {
				$('.menu-item').removeClass('opened');		
				$(this).parent('.menu-item').addClass('opened');	
				var mylink = "#" + $(this).attr('id') + '_link';
				$(mylink).show();
				$(this).parent('.menu-item').children('.sub-menu').fadeIn();
			}
		});	
		
		$(".ipad .toplevel_nochildren").click(function(event) {
			$('.sub-menu').hide();
			$('.jq_top_nav_link').hide();		
			$('.menu-item').removeClass('opened');
		});
	}
*/

	
/*
	if($("#primary").is('.binder_favorites'))
		$('body').addClass('favorites_page');
*/


/* 	$('.fb_popup_container').addClass('centering_box'); */


/*
	$("#memberloginform").submit(function() {
	 
		$('.fb_loading').html(ajaxLoadingImage); 
		$('#login_form').fadeOut('fast');
		$('.fb_loading').show(); 	 

		$.ajax({
			type: 'POST',
			url: aofAJAX.homeURL + '/wp-login.php',
			data: "log="+$("#log").val()+"&pwd="+$("#pwd").val()+"&rememberme="+$("#rememberme").val(),
			success: function(data) {
			
				$('.fb_loading').fadeOut('fast'); 		
				//$.fancybox.update();			

				if(data.indexOf("ERROR") != -1) {
					$('#login_form').fadeIn('fast');
					$(".fb_results").fadeIn().addClass('login_error');
					$('.fb_results h3').html('Oops');
					$('.fb_results p.db_message').html("Sorry, we couldn't log you in! If you've lost your password, <a class=\"lost-pwd\" href=\"\">click here to reset it</a>, and we'll get you back in no time.");
					
					
					} else { 
						$(".fb_results").fadeIn().addClass('login_success');
						$('.fb_results h3').html('Welcome Back.');
						$('.fb_results p.db_message').text("Thanks for logging in! We'll send you on your way in a moment.");
						var redirectURL = $('#login_redirect_url').val();
						
						closewin = setTimeout(function() {	 
							$.fancybox.close();
							if(redirectURL!="")
								window.location.replace(redirectURL + '?upd=lggv');
							else
								location.reload(true);
									
						}, 2000);						
					}
			},
		});
		return false;	
		
	}); // .submit()		
	
	$('.cancel-lost-pwd').click(function(event){
		event.preventDefault();
		//$('.fb_temporaries').show();		
		//$('#login_form').fadeOut();
		$('#memberloginform').slideDown(250);
		$('#lostpasswdform').slideUp(250);
		return false;
	});
		
	$(".lost-pwd").live('click', function(event){
		$('.fb_temporaries').hide();		
		//$('#login_form').fadeIn();
		$('#memberloginform').slideUp(250);
		$('#lostpasswdform').slideDown(250);
		$('#user_login').addClass('required');
		//$.fancybox.center();
		return false;
	});

	$("#lostpasswordform").validate();
		
	$("#lostpasswordform").submit(function() {
			$('.fb_loading').html(ajaxLoadingImage); 
			$('#login_form').fadeOut('fast'); 
			$('.fb_loading').show(); 	 
		
			$.ajax({
				type: 'POST',
				url: aofAJAX.homeURL + '/wp-login.php?action=lostpassword',
				data: "user_login="+$("#user_login").val(),
				success: function(data) {
				
						$('.fb_loading').fadeOut('fast'); 		
						//$.fancybox.center();
						$(".fb_results").fadeIn()
											.addClass('login_success');
						$('.fb_results h3').html('Thanks');
						$('.fb_results p.db_message').text("We've just sent a password reset link to your box. Please check your spam folder if you don't see it in the next 10 minutes.");
						
						closewin   = setTimeout(function() 
						   {	 
						   
							$.fancybox.close();
							$('#lostpasswdform').hide();
							$('#memberloginform').show();
							
									
						   }, 3000);		
						   
					}
				});
			return false;	
		});	
		
	$("#newMemberPassCreate").submit(function() {
			$("#passReset_confirm").fadeOut();
			
				$.ajax({
					type: 'POST',
					url: aofAJAX.homeURL + '/wp-login.php?action=resetpass&key='+$("#reset_key").val()+'&login='+$("#user_login").val(),
					data: "pass1="+$("#pass1").val()+"&pass2="+$("#pass2").val()+"&key="+$("#reset_key").val()+'&login='+$("#user_login").val()+"&wp-submit=Reset Password",
					success: function(data) {
					//	console.log(data);
						$("#passReset_confirm").fadeIn();
						if(data.indexOf("Your password has been reset") != -1) {
							$("#pass1").attr("disabled", "disabled");
							$("#pass2").attr("disabled", "disabled");
							$("#resetpass_submit").attr("disabled", "disabled");	
							//$("#newMemberPassCreate").fadeOut("slow");	
							$("#passReset_confirm").addClass("success");
							$("#passReset_confirm").html("<h3>Thanks!</h3><p>We've reset your password.</p><p>We're redirecting you to the homepage in a few moments.</p>");
							$('#passReset_confirm').fadeOut(3000, function() {
								window.location.replace(aofAJAX.homeURL);
							  });

						}else {
							$("#resetpass_submit").val("Submit again");
							$("#passReset_confirm").addClass("error");
							$("#passReset_confirm").html("<h3>Sorry</h3><p>we couldn't reset your password.  Please make sure you're using the appropriate length and characters, and refer to your lost password email for the correct key.</p><p>If it still does not work, please contact an administrator.</p>");
							} 
					}
				});
				

				$("#lostpasswd_reset").fadeIn();
				
				return false;	
			});	
*/
		
	
	
/*
	$("a.ajax_action").click(function() {
		openbox = "#" + $(this).attr("rel");
		$("a.ajax_action").removeClass('selected_action');
		$(this).addClass('selected_action');
		//$('.login_subbox').fadeOut('fast');
		$('.action_alerts').fadeOut('fast');
		//alert(getViewportHeight());
		
	//	console.log($(this).attr("rel"));
		positionIt($(this).attr("rel"));
	//	positionIt($(".outside_confirm"));
	//	$(openbox).attr('margin-top',$(window).height());
		$(openbox).fadeToggle('medium');
		$.fancybox.close( true );
		return false;
	});
*/


/*
	//signup new users
	$.easing.elasout = function(x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	};
	

	$("a#ajax_createaccount").click(function() {
			$(this).addClass('selected_action');
			$('#aof_createaccount').fadeIn('fast');
			$.scrollTo( '#aof_createaccount', 2500, {easing:'elasout'} );
			return false;
	});
*/

/*
	$('#signup_user').live('click', function(event){
		event.preventDefault();	
		var $acct_confirmation=$('#newmember_confirm');
		
		$acct_confirmation.hide("fast");	

		var $form = $('#aof_createaccount_form');
		
		if(!$("#member_username").is('.error')) {	
			if($form.valid()) {
				
				$acct_confirmation.html(ajaxLoadingImage);
				$acct_confirmation.removeClass('error_message');
				$acct_confirmation.fadeIn(); 
				$('.acct_inputs').fadeTo('fast',.7);			

						var data = {
							action: 'ajax_registerUser',
							member_datum:  $form.serialize(),
							security : aofAJAX.specialNonce
								};

							$.ajax({
								url: aofAJAX.ajaxurl, 
								type: "POST",
								data: data,
								dataType: 'json',
								success: function(data) {
									
									var result_msg = '<p class="db_message">' + data.message + '</p>';
									$acct_confirmation.html(result_msg);	//('#newmember_confirm p.db_message').html(); 
									
									if(data.successful==true) {
										$acct_confirmation.addClass('login_success');
									} else {
										$acct_confirmation.addClass('login_error');
									}

								var redirectURL = $('#login_redirect_url').val();
								
								if(redirectURL=="")
									redirectURL = aofAJAX.sameURL;									
				
								//	$acct_confirmation.addClass(data.successful); 
									
									if(data.successful==true) {
										$('#newmember_confirm').fadeOut(10500, function() {
											window.location.replace(redirectURL);
										  });
										}else {
										$('.acct_inputs').fadeTo('fast',1);
									}
								}		
							});	
					} else {
						$acct_confirmation.fadeIn();
						$acct_confirmation.addClass('error_message');
				}
		}
	});


	//newuser acct validation rules
	$("#aof_createaccount_form").validate({
				rules: {	
					member_username: {
						required: true,
						minlength: 6
					},
					member_password: {
						required: true,
						minlength: 7
					},
					member_password_confirm: {
						required: true,
						minlength: 7,
						equalTo: "#member_password"
					},					
					member_company: {
						required: true,
						minlength: 1,
					}

				},
				messages: {

					member_password_confirm: {
						required: "Please provide a password",
						minlength: "Your password must be at least 7 characters long",
						equalTo: "Please enter the same password as above"
					},
				}
			});

		
	//username validation
	$('#member_username').focus(function(){
		$('#username_taken_label').hide();
	});

	$('#member_username').blur(function() {
		var data = {
			action: 'signup_verifyuser',
			username: $('#member_username').val(),
			security : aofAJAX.specialNonce
				};

			$.ajax({
				url: aofAJAX.ajaxurl, 
				type: "POST",
				data: data,
				dataType: "html",
				success: function(data) {
					if(data.indexOf("unavailable") > -1) {
						$('#member_username').addClass('error');
						$('#username_taken_label').show();
					} else {
						$('#member_username').removeClass('error');
						$('#username_taken_label').hide();
					}
				},					
			});		
	});			
		
		
	//email validation
	$('#member_email').focus(function(){
			$('#email_taken_label').hide();
		});

	$('#member_email').blur(function() {
			var data = {
				action: 'signup_verifyemail',
				email_address: $('#member_email').val(),
				security : aofAJAX.specialNonce
					};

				$.ajax({
					url: aofAJAX.ajaxurl, 
					type: "POST",
					data: data,
					dataType: "html",
					success: function(data) {
						if(data.indexOf("unavailable") > -1) {
							$('#member_email').addClass('error');
							$('#email_taken_label').show();
						} else {
							$('#member_email').removeClass('error');
							$('#email_taken_label').hide();
						}
					},					
				});		
		});	
*/

		
	//PDF Creation?
	//console.log($('.product_col').html()); 
/*
	$(".product_createpdf").click(function() {
	var data = {
		action: 'ajax_createPDF',
		htmldata: $('.product_col').html(),
		security : aofAJAX.specialNonce
			};
			
			

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
			//	console.log(data);
			}
		
		});	
		
	return false;

});
*/


/*
	//UI AND BINDER FUNC
	$(".ajax_ui").click(function() {
	var page_action = $(this).data('page_action');
	// alert (page_action);
	var data = {
		action: $(this).attr("rel"),
		security : aofAJAX.specialNonce
			};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				
				if(page_action == 'noreload')
					location.replace(aofAJAX.homeURL);
				else
					location.reload(true);
			}
		
		});	
		
	return false;

});

	//add to favorites
	$(".binder_notfavorited").live('click', function(event){

		if ($(this).hasClass('notlive')) { return; }			
			
		var $addbutton=$(this),
				data = {
					item: $addbutton.attr("rel"),
					action: 'binder_addtofavorites',
					security : aofAJAX.specialNonce
				};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				if(data.favorited == 'true') {
					$addbutton.prop('rel',data.faveID);
					$addbutton.removeClass('binder_notfavorited');
					$addbutton.addClass('binder_favorite_added');
					$addbutton.html('<span class="icon icon-ar_fav-closed"></span> Favorite');
				}				
			}
		});	
		
		return false;
	});

	//remove  favorites
	$(".binder_favorite_added").live('click', function(event){

		if ($(this).hasClass('notlive')) { return; }
	
		var $removebutton=$(this),
				prodID = $(this).parent().attr("rel"),
				data = {
					item: $(this).attr("rel"),	
					action: 'binder_removefromfavorites',
					security : aofAJAX.specialNonce
				};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				if(data.unfavorited== true) {
					$removebutton.prop('rel',prodID);
					$removebutton.removeClass('binder_favorite_added');
					$removebutton.addClass('binder_notfavorited');
					$removebutton.html('<span class="icon icon-ar_fav-open"></span> Add to Favorites');
				}				
			}
		});	
		
		return false;
	});

	//delete & edit binder clicks
	$("a.binder_tool_continue").click(function(ev) {
		var desired_box="#" + $(this).attr("rel");
		$('.binder_action_box').removeClass('open');
		$(desired_box).addClass('open');	
		return false;
	});

	//delete ajax
	$("#binder_trash_binder").click(function() {

	var binderID = $(this).attr("rel");

	var data = {
		binderID: binderID,
		action: 'binder_trashBinder',
		security : aofAJAX.specialNonce
			};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				if(data.trashed_binder==true) {
					$(".delete_message").html(data.trashmessage)
						.fadeOut(2500, function() {
							window.location.replace(aofAJAX.dashURL);
						  });			
								
				} else;
					$(".delete_message").html(data.trashmessage);				
			}
		});	
		
	return false;

});	

	//binder send to arenson
	$("#binder_tool_sendbinder").click(function() {
		var $emailResponseBox=$('#binder_tool_ajax_box').find(".share_response");
	
		$("#binder_tool_ajax_box").addClass('open');
		$emailResponseBox.html('<div id="ajax_loading">'+ajaxLoadingImage+'</div>');
	
		var binderHash = $(this).attr("rel");
	
		var data = {
			binderHash: binderHash,
			action: 'email_sendBinderAOF',
			security : aofAJAX.specialNonce
				};
	
			$.ajax({
				url: aofAJAX.ajaxurl, 
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(data) {
				//	console.log(data);
					
					$emailResponseBox.html(data.SentMessage);
					
					if(data.sent_successfully==true) {
						$emailResponseBox.addClass('success');
					}else
						$emailResponseBox.addClass('failure');
				}
			});	
			
		return false;
	
	});	

	//binder email / share
	$(".binder_email_form").submit(function() {
		var $emailResponseBox = $(this).find(".share_response");
		
		//$('#binder_tool_share_box').fadeOut();
		//$("#binder_tool_ajax_box").fadeIn('fast');
		$emailResponseBox.html('<div id="ajax_loading">'+ajaxLoadingImage+'</div>');
	
		var binderHash = $(this).attr("rel");
	
		var data = {
			binderHash: binderHash,
			destinationEmail: $('#binder_email_destination').val(),
			action: 'email_sendBinder',
			security : aofAJAX.specialNonce
		};
	
		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				
				$emailResponseBox.html(data.SentMessage);
				
				if (data.sent_successfully == true) {
					$emailResponseBox.addClass('success');
				} else {
					$emailResponseBox.addClass('failure');
				}
			}
		});	
			
		return false;
	});	

	//single product email / share
	$("a#product_shareEmail").click(function() {
		$("#single_sharebox").slideToggle(250);
		return false;
	});
	
	$(".product_email_form").submit(function() {
	var $emailResponseBox=$(".share_response");
	$emailResponseBox.html(ajaxLoadingImage);
	$(this).fadeOut('fast');
	
	var productID = $(this).attr("rel");

	var data = {
		productID: productID,
		destinationEmail: $('#product_email_destination').val(),
		action: 'email_sendProduct',
		security : aofAJAX.specialNonce
			};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
			//	console.log(data);
				
				if(data.sent_successfully==true) {
					$emailResponseBox.addClass('success');
				}else
					$emailResponseBox.addClass('failure');
					
				$emailResponseBox.html(data.SentMessage)
								 .fadeOut('medium');
									
			}
		});	
		
	return false;

});	
*/


	
	
/*
	// ADDING ITEM TO BINDER & REQUESTING FORMS
	$("a.ajax_binder").click(function() {

	add_functionality = $(this).attr("id");

	if(add_functionality=='binder_add'){
		$('.addtobinder_title').html('Add Item');
		$('#add_item_request_quote').val('Add Item');
		$('#binder_functionality').val('adding_simple');
	}else if(add_functionality=='binder_req_quote'){
		$('.addtobinder_title').text('Request a Quote');
		$('#add_item_request_quote').val('Request a Quote');
		$('#binder_functionality').val('adding_quote');
	}

});
	
	$('#binder_existing').change(function() {	
		var binderName = $(this).val();
	
		if(binderName=='newb') {
			$('.newbinder_fields').fadeTo('fast',1);
			$('#binder_create_name').val('eg Front Lobby');
			$('#binder_create_desc').val('eg. These are items for the front lobby with a blue and gray color scheme.');
			
		}else {
			$('.newbinder_fields').val('')
				.fadeTo('fast',.7);
		}
	});	
	
	// add to binder submission
	$(".binder_additem").submit(function() {

	var itemPath = $('#binder_functionality').val();	
	$('.fb_loading').html(ajaxLoadingImage); 
	$('#binder_add_form').fadeOut('fast'); 
	$('.fb_loading').show(); 
 
	var prodID = $(this).attr("rel");
	var binderExisting = $('#binder_existing').val();
	var binderNew = $('#binder_create_name').val();
	var binderDesc = $('#binder_create_desc').val();
	var itemQuantity = $('#binder_item_quantity').val();

	var data = {
		functionality: itemPath,
		item: prodID,
		binderExisting: binderExisting,
		binderNew: binderNew,
		binderDesc: binderDesc,
		itemQuantity: itemQuantity,
		action: 'binder_additem',
		security : aofAJAX.specialNonce
			};
	

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				console.log(data);
				$('.fb_loading').fadeOut('fast'); 		
				$('.fb_results p.db_message').html(data.binderAddMessage); 
				$('.fb_results h3').html(data.binderAddMessageTitle);
				//$.fancybox.center();
				
				if(data.binderAddSuccess==true) {
					$(".fb_results").fadeIn()
										.addClass('login_success');
				} else {

					$(".fb_results").fadeIn()
										.addClass('login_error');
				}
				
				
				
				closewin   = setTimeout(function() 
				   {	 
				   
					$.fancybox.close();
					
					if(data.quoteBehavior==true)
						window.location.replace(data.binderLink);
							
				   }, 3000);									
			}
		
		});	
		
	return false;

});	
*/
	
	
	
/*
	//create new binder
	$("#dashboard_createbinder").submit(function() {
 
	$('#binder_name_revise').hide(); 
	$('#binder_confirm').hide(); 
	
	var binderNew = $('#binder_create_name').val();
	var binderDesc = $('#binder_create_desc').val(); //
	
	if(binderNew=='Title') {
		$('#binder_name_revise').show();
		return false;
	}
		
	if(binderDesc=='Description (optional)')
		binderDesc='';

	var data = {
		binderNewTitle: binderNew,
		binderNewDesc: binderDesc,
		action: 'ajax_binder_createbinder',
		security : aofAJAX.specialNonce
			};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				$('#binder_confirm p.db_message').html(data.binderCreated); 
				if(data.created_binder==true) {
					$("#binder_confirm").fadeIn()
										.addClass('login_success');
				} else {
					$("#binder_confirm").fadeIn()
										.addClass('login_error');
				}
			}
		});	
		
	return false;

});	
	
	//delete item
	$(".binder_item_delete").click(function() {
	var item_code=$(this).attr("rel");
	var thisRow=".binder_product_overview[rel='"+item_code+"']";
	$(thisRow).html('<div id="ajax_loading">'+ajaxLoadingImage+'</div>');

	
	var data = {
		action: 'binder_deleteitem',
		item: item_code,
		security : aofAJAX.specialNonce
	};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
			
				if(data.deleted==true) {
					$(thisRow)
						.addClass('deleted')			
						.empty()
						.html('<p class="notification"><strong>This item has been removed from your binder</strong></p>');
				}

			}
		
		});	
		
	return false;

});	
	
	//change quantity
	$("a.binder_item_changequantity").click(function() {
		var item_code=$(this).attr("rel");
		thisChangeBox=".item_quant_change[rel='"+item_code+"']";
		thisOrig=".item_current_quantity[rel='"+item_code+"']";
		//$(thisOrig).toggle('fast');	//should we hide the original?
		$(thisChangeBox).fadeToggle(250);
		return false;
	});
	$(".item_new_quantity").blur(function() {
	var $quantity_changer=$(this);
	var item_code=$quantity_changer.attr("rel");
	var newquant=$quantity_changer.val();
	
	var data = {
		action: 'binder_item_changequantity',
		newquant: newquant,
		item: item_code,
		security : aofAJAX.specialNonce
			};

		$.ajax({
			url: aofAJAX.ajaxurl, 
			type: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
			//	console.log(data);
				if(data.updatedquantity==true) {
					thisOrig=".item_current_quantity[rel='"+item_code+"']";
					thisSuccessLabel=".changed_quantity_success[rel='"+item_code+"']";
					$quantity_changer.fadeOut(250);
					$(thisOrig).html(newquant);
					$(thisSuccessLabel).fadeIn(250);
				}				
				//	window.location.replace(aofAJAX.homeURL);
			}
		
		});	
		
	return false;

}); 
	$(".quantity_change_form").submit(function() {
		$(this).children(".item_new_quantity").blur();
		return false;
	});	
*/


		
/* ******
	CLEAR / REPLACE INPUT
****************************** */
	var clearMePrevious = '';
	
	// clear input on focus
/*
	$('.menu-main-container textarea').focus(function(){
		$(this).val('');
	});		
*/
	
	// clear input on focus
/*
	$('.menu-main-container input').focus(function(){
		$(this).val('');
	});	
*/
	
/*
	$('.clearMeFocus').focus(function(){
		if($(this).val()==$(this).attr('title')){
			clearMePrevious = $(this).val();
			$(this).val('');
		}
	});
*/
	
	// if field is empty afterward, add text again
/*
	$('.clearMeFocus').blur(function(){
		if($(this).val()=='') {
			$(this).val(clearMePrevious);
		}
	});
*/

/*
	$('.selectMyValue').focus(function(){
		 this.select();
	});			
*/
	

	
	
// misc

/*
$('#binder_create_desc').simplyCountable({
    counter:            '#binder_create_desc_counter',
});
$('#binder_create_name').simplyCountable({
    counter:            '#binder_create_name_counter',
    maxCount :          24,
});
*/


/*
positionIt = function($positionDiv) {
	if( document.getElementById ) {
		// Get a reference to divTest and measure its width and height.
		var div =  document.getElementById($positionDiv);
	//	var divWidth = div.offsetWidth ? div.offsetWidth : div.style.width ? parseInt( div.style.width ) : 0;
		var divHeight = div.offsetHeight ? div.offsetHeight :  div.style.height ? parseInt( div.style.height ) : 0;
		
		// Calculating setX and setX so the div will be centered in the viewport.
	//	var setX = ( getViewportWidth() - divWidth ) / 2;
		var setY = ( getViewportHeight() - divHeight ) / 2;
		
		// If setX or setY have become smaller than 0, make them 0.
	//	if( setX < 0 ) setX = 0;
		if( setY < 0 ) setY = 0;
		
		setY=getViewportScrollY()+150;
		// Position the div in the center of the page and make it visible.
	//	div.style.left = setX + "px";
		div.style.top = setY + "px";
	//	div.style.visibility = "visible";
	}
};
*/
	
/*
getViewportScrollY = function() {
  var scrollY = 0;
  if( document.documentElement && document.documentElement.scrollTop ) {
    scrollY = document.documentElement.scrollTop;
  }
  else if( document.body && document.body.scrollTop ) {
    scrollY = document.body.scrollTop;
  }
  else if( window.pageYOffset ) {
    scrollY = window.pageYOffset;
  }
  else if( window.scrollY ) {
    scrollY = window.scrollY;
  }
  return scrollY;
};
*/
	
	
/*
getViewportHeight = function() {
  var height = 0;
  if( document.documentElement && document.documentElement.clientHeight ) {
	height = document.documentElement.clientHeight;
  }
  else if( document.body && document.body.clientHeight ) {
	height = document.body.clientHeight;
  }
  else if( window.innerHeight ) {
	height = window.innerHeight - 18;
  }
  return height;
};
*/

});		

