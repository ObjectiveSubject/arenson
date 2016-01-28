(function($){

	/* Variables
	--------------------------------------------------- */
	var Arenson = {},
			ajaxLoadingImage = '<img src="'+ aofAJAX.homeURL+ '/wp-content/themes/arenson/img/ajax_loader.png" alt="Processing..." />';


	/* Methods
	--------------------------------------------------- */
	Arenson.users = function () {

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
		$('#memberloginform').slideDown(250);
		$('#lostpasswdform').slideUp(250);
		return false;
	});

		$(".lost-pwd").live('click', function(event){
			$('.fb_temporaries').hide();
			$('#memberloginform').slideUp(250);
			$('#lostpasswdform').slideDown(250);
			$('#user_login').addClass('required');
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
						$(".fb_results").fadeIn().addClass('login_success');
						$('.fb_results h3').html('Thanks');
						$('.fb_results p.db_message').text("We've just sent a password reset link to your box. Please check your spam folder if you don't see it in the next 10 minutes.");
						
						closewin = setTimeout(function() {
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

		$('#signup_user').live('click', function(event) {
			event.preventDefault();
			var $acct_confirmation=$('#newmember_confirm');
			$acct_confirmation.hide("fast");
			var $form = $('#aof_createaccount_form');
			
			// Spam filters
			var spam_quiz = $('#spam_quiz').val().toUpperCase();
			if (spam_quiz !== "ARENSON") { return false; }
			if ($('#user_email').index() > -1) {
				if ($('#user_email').val() !== "" || $('#user_message').val() !== "") {
					console.log('no bots allowed!');
					return false;
				} else {
					console.log('looks good boss');
				}
			}
			
			if (!$("#member_username").is('.error')) {
				if ($form.valid()) {
				
				$acct_confirmation.html(ajaxLoadingImage);
				$acct_confirmation.removeClass('error_message');
				$acct_confirmation.fadeIn(); 
				$('.acct_inputs').fadeTo('fast',0.7);

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
					
					if(redirectURL=="") { redirectURL = aofAJAX.sameURL; }
	
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

	}; //users

	Arenson.createPDF = function () {
	
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
				}
			});	
				
			return false;		
		});
		
	}; //createPDF

	Arenson.binder = function () {
	
		//UI AND BINDER FUNC
		$(".ajax_ui").click(function() {
			var page_action = $(this).data('page_action'),
					data = {
						action: $(this).attr("rel"),
						security : aofAJAX.specialNonce
					};
		
			$.ajax({
				url: aofAJAX.ajaxurl, 
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(data) {	
					if (page_action == 'noreload') {
						location.replace(aofAJAX.homeURL);
					} else { 
						location.reload(true);
					}
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
			var binderID = $(this).attr("rel"),
					data = {
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
							$(".delete_message")
								.html(data.trashmessage)
								.fadeOut(2500, function() {
									window.location.replace(aofAJAX.dashURL);
								});								
						} else {
							$(".delete_message").html(data.trashmessage);
						}
					}
				});	
				return false;
		});	

		//binder send to arenson
		$("#binder_tool_sendbinder").click(function() {
			var $emailResponseBox=$('#binder_tool_ajax_box').find(".share_response");
			$("#binder_tool_ajax_box").addClass('open');
			$emailResponseBox.html('<div id="ajax_loading">'+ajaxLoadingImage+'</div>');
			var binderHash = $(this).attr("rel"),
					data = {
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
			$emailResponseBox.html('<div id="ajax_loading">'+ajaxLoadingImage+'</div>');		
			var binderHash = $(this).attr("rel"),
					data = {
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
	
		//open binder dropdown
		$('.binder_action_box .close-btn').click(function(ev){
			ev.preventDefault();
			$('.binder_action_box').removeClass('open');
		});

		//edit binder
		$(".binder_edit_form").submit(function() {
			var binderID = $(this).attr("rel"),
					binderNewTitle = $('#binder_new_title').val(),
					binderNewDesc = $('#binder_new_desc').val(),
					data = {
						binderID: binderID,
						binderNewTitle: binderNewTitle,
						binderNewDesc: binderNewDesc,
						action: 'binder_editMeta',
						security : aofAJAX.specialNonce
					};
		
			$.ajax({
				url: aofAJAX.ajaxurl, 
				type: "POST",
				data: data,
				dataType: 'json',
				success: function(data) {
					if(data.updated_data==true) {
						$(".page-title .bindername").html(binderNewTitle);
						$(".page-title .binder_description").html(binderNewDesc);
						$(".binder_action_box").removeClass('open');
									
					}			
				}
			});	
				
			return false;
		});	

		$("a.binder_accordion").live('click', function(ev){
			ev.preventDefault();
			var form_module = $(this).closest('.form_module'),
					module_container = $(form_module).find('.binder_module_container');
					
			if (!$(form_module).hasClass('open')) {
				$('.form_module').removeClass('open');
				$('.binder_module_container').slideUp();
				$(form_module).addClass('open');
				$(module_container).slideDown();
			}
		});
		
		//Dashboard - create new binder
		$("#dashboard_createbinder").submit(function() {
	 
			$('#binder_name_revise, #binder_confirm').hide(); 
			
			var binderNew = $('#binder_create_name').val(),
					binderDesc = $('#binder_create_desc').val();
			
			if (binderNew == 'Title') {
				$('#binder_name_revise').show();
				return false;
			}
				
			if (binderDesc == 'Description (optional)') { binderDesc = ''; }
		
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
			var item_code=$(this).attr("rel"),
					thisRow=".binder_product_overview[rel='"+item_code+"']";
					
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
					if (data.deleted == true) {
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
			var item_code = $(this).attr("rel"),
					thisChangeBox = ".item_quant_change[rel='"+item_code+"']",
					thisOrig = ".item_current_quantity[rel='"+item_code+"']";
			$(thisChangeBox).fadeToggle(250);
			return false;
		});
		
		$(".item_new_quantity").blur(function() {
			var $quantity_changer = $(this),
					item_code = $quantity_changer.attr("rel"),
					newquant = $quantity_changer.val(),	
					data = {
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
					if(data.updatedquantity==true) {
						thisOrig=".item_current_quantity[rel='"+item_code+"']";
						thisSuccessLabel=".changed_quantity_success[rel='"+item_code+"']";
						$quantity_changer.fadeOut(250);
						$(thisOrig).html(newquant);
						$(thisSuccessLabel).fadeIn(250);
					}				
				}
			
			});	
			
			return false;
		}); 

		$(".quantity_change_form").submit(function() {
			$(this).children(".item_new_quantity").blur();
			return false;
		});	
			
	}; //binder

	Arenson.divisionSubNav = function (id) {
			
			var cntnt = $(id).find('.content, .desc'),
					toggle = $(id).find('.toggle-btn'),
					close = $(id).find('.close-btn');
			
			
			$(toggle).each(function(){
				$(this).click(function(ev){
					ev.preventDefault();
					if ($(id).hasClass('closed')) {
						$(id).addClass('open').removeClass('closed');
						$(cntnt).slideDown({duration: 150});
					} else {
						$(cntnt).slideUp({duration: 150});
						$(id).removeClass('open').addClass('closed');
					}
				});
			});

			$(close).click(function(ev){
				ev.preventDefault();
				$(cntnt).slideUp({duration: 150});
				$(id).removeClass('open').addClass('closed');
			});
						
		}; //divisionSubNav

	Arenson.focusLink = function (elem, target) {
			$(elem).click(function(ev){
				ev.preventDefault();
				$(target).focus();
			});
		}; //focusLink

	Arenson.forms = function () {
		$(".aof_select, input[type='checkbox']").uniform();
		
		// Select appropriate division in contact form
		var division = $('body').attr('data-division');
		$('#contact .division input[type="radio"]').attr('checked', null).each(function(){
			if ($(this).attr('value') === division) {
				$(this).attr('checked', 'checked');
			}
		});
		
		// Placeholder text fix
		$('input[type="text"], input[type="tel"], textarea, input[type="text"]').each(function(){
			var value = $(this).attr('value');
			$(this).attr('placeholder', value);
			$(this).focus(function(){
				if ($(this).attr('value') == value) {
					$(this).attr('value', '');	
				}
			});
			$(this).blur(function(){
				if ($(this).attr('value') == '') {
					$(this).attr('value', value);
				}
			});
		});
		
	}; //forms

	Arenson.headerDropdown = function (elem, close) {
			var hash = $(elem).attr('href');
			var html = $(elem).html();

			$(elem).click(function(ev){
				ev.preventDefault();
				if ($(hash).hasClass('open')) {
					$(elem).removeClass('open');
					$(hash).removeClass('open');
				} else {
					$(this).addClass('open');
					$(hash).addClass('open').find('#s').focus();
				}
			});

			$(close).click(function(ev){
				ev.preventDefault();
				$(elem).removeClass('open').html(html);
				$(hash).removeClass('open');
			});

		}; //searchLink

	Arenson.homeSlides = function (elem) {
			$(elem)
				.each(function(){
					var indx = $(this).index() + 1;
					if (indx === 1 && $(window).width() > 700) {
						$(this).addClass('open slide-'+indx);
					} else {
						$(this).addClass('closed slide-'+indx);
					}
				})
				.hover(function(){
					$(elem).removeClass('open closed').toggleClass('not-hovered');
					$(this).toggleClass('not-hovered hovered');
				}, function(){
					$(elem).addClass('closed').removeClass('not-hovered hovered');
					$(this).addClass('open').removeClass('closed');
				})
				.click(function(ev){
					window.location = $(this).find('.slide-title a').attr('href');
				});
					
		}; // homeSlides	

	Arenson.divisionMenu = function () {
		$('.title-division .toggle, #product_map .close-btn').click(function(ev){
			ev.preventDefault();
			if ($('#product_map').hasClass('closed')) {
				$('.title-division .toggle').addClass('open');
			} else {
				$('.title-division .toggle').removeClass('open');
			}
			$('#product_map').toggleClass('open closed');
			return false;
		});
		
		$('#product_map a.division-name').click(function(ev){
			ev.preventDefault();
			var href = ev.target.href,
					html = ev.target.innerHTML;
			$('body').append('<div id="division-switch" class="scrim white"><div class="scrim-content"><p class="">You are now moving to a different division</p><h1 class="division-name">'+ html.replace('<br>', ' ') +'</h1><div id="ajax_loading"><img src="/wp-content/themes/arenson/img/ajax_loader.png" alt="ajax_loader" /></div><a href="#" class="cancel"><span class="icon icon-ar_close"></span> Cancel</a></div></div>');
			$('#division-switch').fadeIn().addClass('visible');
			var timeout = setTimeout(function(){
				window.location = href;
			}, 100);
			$('.cancel').click(function(ev){
				ev.preventDefault();
				clearTimeout(timeout);
				$('#division-switch').fadeOut(500, function(){
					$(this).remove();
				});
			});
		});
	}; //menus		

	Arenson.mobile = function () {
		$('.menu-toggle').click(function(ev){
			ev.preventDefault();
			$('.main-navigation').toggleClass('open');
			$('.menu-toggle').toggleClass('icon-ar_close icon-ar-menu');
		});

		$(".iphone .fancy_popup.login_button.button_img").click(function(){
			$(this).attr("href","/userlogin");
		});
	}; //mobile

	Arenson.heroSlides = function () {
		$('.slideshow').slick({
			dots: true,
			speed: 500,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 5000
		});
	}; //heroSlides

	Arenson.collectionSlides = function () {
			
			var break_one = {
				      breakpoint: 1700,
				      settings: {
				      	slide: 'li',
				      	infinite: false,
				        slidesToShow: 5,
				        slidesToScroll: 5,
				        speed: 1100,
				      }
				    },
					break_two = {
				      breakpoint: 1300,
				      settings: {
				      	slide: 'li',
				      	infinite: false,
				        slidesToShow: 4,
				        slidesToScroll: 4,
				        speed: 900,
				      }
				    },
				  break_three = {
				      breakpoint: 900,
				      settings: {
				      	slide: 'li',
				      	infinite: false,
				        slidesToShow: 3,
				        slidesToScroll: 3,
				        speed: 700,
				      }
				    },
				  break_four = {
				      breakpoint: 600,
				      settings: {
				      	slide: 'li',
				      	infinite: false,
				        slidesToShow: 2,
				        slidesToScroll: 2,
				        speed: 500,
				      }
				    },
				  break_five = {
				      breakpoint: 350,
				      settings: {
				      	slide: 'li',
				      	infinite: false,
				        slidesToShow: 1,
				        slidesToScroll: 1,
				        speed: 300,
				      }
				    };
			
			var args = {
				slide: 'li',
				lazyLoad: 'ondemand',
			  infinite: false,
			  speed: 1300,
			  slidesToShow: 6,
			  slidesToScroll: 6,
			  responsive: [ break_one, break_two, break_three, break_four, break_five ]
			};
			
			$('.slide-form').each(function(){
				$(this).slick(args);
			});
		}; //slides

	Arenson.singleProducts = function () {
		$(".expand_title").click(function(){
			var a = "#" + $(this).children("a").attr("rel");
			$(a).slideToggle(200);
			$(this).toggleClass("openedGroup");
			return false;
		});
		
		//single product email / share
		$("a#product_shareEmail").click(function() {
			$("#single_sharebox").slideToggle(250);
			return false;
		});
		
		$(".product_email_form").submit(function() {
			var $emailResponseBox = $(".share_response");
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
					if (data.sent_successfully == true) {
						$emailResponseBox.addClass('success');
					} else {
						$emailResponseBox.addClass('failure');
					}
					$emailResponseBox.html(data.SentMessage).fadeOut('medium');
				}
			});	
			return false;
		});	
		
		// ADDING ITEM TO BINDER & REQUESTING FORMS
		$("a.ajax_binder").click(function() {
			var add_functionality = $(this).attr("id");		
			if (add_functionality=='binder_add') {
				$('.addtobinder_title').html('Add Item');
				$('#add_item_request_quote').val('Add Item');
				$('#binder_functionality').val('adding_simple');
			} else if (add_functionality == 'binder_req_quote') {
				$('.addtobinder_title').text('Request a Quote');
				$('#add_item_request_quote').val('Request a Quote');
				$('#binder_functionality').val('adding_quote');
			}
		});
	
		$('#binder_existing').change(function() {	
			var binderName = $(this).val();
			if (binderName=='newb') {
				$('.newbinder_fields').fadeTo('fast',1);
				$('#binder_create_name').val('eg Front Lobby');
				$('#binder_create_desc').val('eg. These are items for the front lobby with a blue and gray color scheme.');
			} else {
				$('.newbinder_fields').val('').fadeTo('fast',0.7);
			}
		});	
	
		// add to binder submission
		$(".binder_additem").submit(function() {
	
			var itemPath = $('#binder_functionality').val();	
			$('.fb_loading').html(ajaxLoadingImage); 
			$('#binder_add_form').fadeOut('fast'); 
			$('.fb_loading').show(); 
		 
			var prodID = $(this).attr("rel"),
					binderExisting = $('#binder_existing').val(),
					binderNew = $('#binder_create_name').val(),
					binderDesc = $('#binder_create_desc').val(),
					itemQuantity = $('#binder_item_quantity').val(),
					data = {
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
					$('.fb_loading').fadeOut('fast'); 		
					$('.fb_results p.db_message').html(data.binderAddMessage); 
					$('.fb_results h3').html(data.binderAddMessageTitle);
					
					if(data.binderAddSuccess==true) {
						$(".fb_results").fadeIn().addClass('login_success');
					} else {
						$(".fb_results").fadeIn().addClass('login_error');
					}
	
					closewin = setTimeout(function() {	 
						$.fancybox.close();
						if(data.quoteBehavior==true) {
							window.location.replace(data.binderLink);
						}
					}, 3000);									
				}
			});	
			return false;
		});	
			
	}; //products

	Arenson.fancyBox = function () {
		var calcMaxWidth = parseInt($('.centering_box').css('width'));
		if (calcMaxWidth == "") { calcMaxWidth=1020; }

		function cleanUpBoxes() {
			$('.fb_temporaries').hide();
			$('.fb_popup_default').show();
			$('.sub-menu').css('display', '');
		}
		
		$("a.fancy_popup").fancybox({
				'speedIn'					:	1000, 
				'speedOut'				:	1000, 
				'maxWidth'				:	calcMaxWidth, 
				//'width'						: '680px',
				'height'					:	'auto',
				'autoSize'				:	false, 	
				'autoHeight'			:	false, 	
				'autoWidth'				:	false, 	
				'closeBtn'				:	false, 	
				'autoResize'			:	false, 	
				'overlayColor'		:	'#FFF', 
				'openEffect'			:	'fade', 
				'closeEffect'			:	'fade', 
				'overlayOpacity'	:	0.9, 
				'padding'					:	0,
				'showCloseButton'	:	false,
				'afterClose'			:	function() { cleanUpBoxes(); },
				//  helpers : { 
				//	   overlay: {
				//		opacity: 0.9, 
				//	//	css: {'background-color': '#FFF'} 
				//	   } 
				//  } 
		});
	
		$(".fb_closer").click(function() {
			$.fancybox.close();
			return false;
		});
		
		$('.close_fancybox').click(function(ev){
			ev.preventDefault();
			$.fancybox.close(true);
		});

	}; //fancybox

	/* Invocation
	--------------------------------------------------- */
	Arenson.users();
	Arenson.createPDF();
	Arenson.forms();
	Arenson.binder();
	Arenson.divisionMenu();
	Arenson.mobile();
	Arenson.focusLink('.subscribe .row-title a', '#mce-EMAIL');
	Arenson.headerDropdown('.site-header a[href="#search"]', '.site-header #search .close-btn');
	Arenson.headerDropdown('.site-header a[href="#contact"]', '.site-header #contact .close-btn');
	Arenson.fancyBox();

	if ($('body').hasClass('home')) { Arenson.homeSlides('.slide'); }

	if ($('.slideshow').index() > -1) { Arenson.heroSlides(); }

	if ($('.slide-form').index() > -1) { Arenson.collectionSlides(); }

	if ($('.single-product').index() > -1) { Arenson.singleProducts(); }

	if ($('.single-division').index() > -1) { Arenson.divisionSubNav('#div-sub-nav'); }

})(jQuery);