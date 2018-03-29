var objtz = jstz.determine(); // Determines the time zone of the browser client
var tz= objtz.name();
$('.steps-slide').carousel({
	pause: true,
	interval: false
});
if(loginRedirect==1 || loginRedirect==2){
	openPopup(UserUrls.Login+'?tz='+tz);
}
var deviceAgent = navigator.userAgent.toLowerCase();
var agentID = deviceAgent.match(/(iPhone|iPod)/i);
if (agentID) {
    window.addEventListener('DOMContentLoaded',function() {
        $("#nav-mobile").addClass("iosnavfix");
        $("body").addClass("iosBugFixCaret");
   });
}
else
{
    $(document).ready(function () {
        $("#nav-mobile").removeClass("iosnavfix");
        $("body").removeClass("iosBugFixCaret");
    });
}
$(document ).ready(function() {
	if($(".singleSelect").length) {
		$(".singleSelect").multipleSelect({
			single: true,
		});
	}
	if($(".select-with-check").length) {
		$(".select-with-check").multipleSelect({
	    multiple: true,
	    multipleWidth: '100%'
		});
	}
	if($(".select-with-input").length) {
		$(".select-with-input").multipleSelect({
	    single: true,
	    filter: true,
	    width: '100%'
		});
	}
	$(document).on('focus', '.select-with-check', function () {
  	$('.ms-drop').find('input').addClass('filled-in');
	});


	$("body").on("click", ".hover-items", function(){
		$(this).toggleClass('active');

		// if($(this).hasClass("active")){
		// 	$(".modal").on('click', function(){
		// 		$(".hover-items").removeClass("active");
		// 	});
		// }
	});


	 // Detect ios 11_0_x affected
    // NEED TO BE UPDATED if new versions are affected
    // var ua = navigator.userAgent,
    // iOS = /iPad|iPhone|iPod/.test(ua),
    // iOS11 = /OS 11_0_1|OS 11_0_2|OS 11_0_3|OS 11_1/.test(ua);

    // // ios 11 bug caret position
    // if ( iOS && iOS11 ) {

    //     // Add CSS class to body
    //     $("body").addClass("iosBugFixCaret");

    //     $("#nav-mobile").addClass("iosnavfix");

    // }
// if($('.profile-banner').length) {
//   $('.profile-banner').owlCarousel({
// 		loop: true,
// 		margin: 0,
// 		nav: true,
// 		navText: ['prev', 'next'],
// 		dots: false,
// 		autoWidth: false,
// 		autoplay: true,
// 		autoplayTimeout:5000,
// 		items: 1,
// 		responsiveClass:true,
// 			responsive : {
// 		    // breakpoint from 480 up
// 		    0 : {
// 		      items: 1
// 		    },
// 		    480 : {
// 		    	items: 1
// 		    },
// 		    768 : {
// 		    	items: 1
// 		    },
// 		    993 : {
// 		    	items: 1
// 		    }
// 			}
// 	});
// }
	$("body").on("click", ".filter-icon", function(e){
		$(".search-filter").toggleClass("show-filter");
	});
	$("body").on("click", ".venue-map-view", function(e){
		$(".sticky-map").show();
                initMap();
		$(".list-view").hide();
	});
	$("body").on("click", ".venue-list-view", function(e){
		$(".sticky-map").hide();
		$(".list-view").show();
	});
	//for landing page start -----------------------------------------
	$("body").on("click", "#waitlistBtn", function(e){
		err=0;
		form = $("form#waitlistFrm");
		validateRequiredField();
		if ($.trim($('input[name="hear_from"]').val()) == '') {
			msg = "This is required field!";
    		error($("#hear_from_err"));
		}
		validateEmail("email");
		checkEmailExistence("email");
		if ($.trim($("#instagramSoical").val()) != '') {
	        //var url = $("#instagramSoical").val();
	        //var regx = /^(http|https)\:\/\/www.instagram.com\/.*/i;
	        //if (!url.match(regx)) {
	          //  msg = "Please enter valid instagram url!";
	          //  error($("#instagramSoical"));
        	//}
        	var urlStatus=validateURL($("#instagramSoical").val());
        	if($('input[name="social_type"]').val()!='other'){
	        	if(urlStatus===true){
	        		msg = "Please enter valid username!";
	    			error($("#socail-div"));
	        	}
        	}else{
        		if(urlStatus==false){
	        		msg = "Please enter valid website!";
	    			error($("#socail-div"));
	        	}
        	}
    	}else{
    		msg = "This is required field!";
    		error($("#socail-div"));
    	}
    	checkReferralCode();
		if(err==0 && ajaxErr==0){
			 $("#loader").show();
			 $.ajax({
				url: UserUrls.Waitlist,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data,status,xhr) {
					$("#loader").hide();
					if($.trim(data)=='1'){
						resetForm('waitlistFrm');
						$("#cmnPoupUp").modal('close');
						$("#confirmGallery .successMsg").text("Great! You're on the waitlist.");
						$("#confirmGallery").modal('open');
					}else{
						resetForm('waitlistFrm');
						$("#cmnPoupUp").modal('close');
						//console.log('Server Error');
						//alert("Something went wrong.");
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		}
		e.preventDefault();
	});

	$("body").on("click", "#waitlistSignUpBtn", function(e){
		err=0;
		form = $("form#waitlistSignUpFrm");
		validateRequiredField();
		if(err==0){
			 $("#loader").show();
			 $.ajax({
				url: UserUrls.VerifyEmailCode,
				type: 'POST',
				data: form.serialize(),
				dataType: "json",
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data,status,xhr) {
					$("#loader").hide();
					if(data.result){
						if($.trim(data.token)=='2'){
							//$('#email_verify_code').val('');
							openPopup(UserUrls.Register+'?tz='+tz+'&email_verify_code='+$.trim(data.code)+'&referal_code='+$.trim(data.referal_code)+'&owner_type='+$.trim(data.owner_type));
						} else {
							msg = "You have entered an invalid code. Try again!";
	                    	error(email_verify_code);
						}
						//window.location.replace(PageUrls.Home);
					}else{
						if($.trim(data.token)=='0'){
							msg = "You have entered an invalid code. Try again!";
	                    	error(email_verify_code);
						}
						if($.trim(data.token)=='1'){
							msg = "You have entered a used code!";
	                    	error(email_verify_code);
						}
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		}
		e.preventDefault();
	});

	//for landing page end -----------------------------------------

	// Scroll to top
	$("a[href='#top']").click(function(){
	    $('html, body').animate({scrollTop : 0},800);
	    return false;
  	});

  // Facilities hover effects
  $('.web-facilities').slideUp();
  $(".our-services-box .row a").hover(function(){
  	var rowChilds = $(".our-services-box .row .service-box");

  	rowChilds.each(function(item){
  		$((rowChilds[item].children[0]).children[0]).removeClass('active');
  	});
  	var sliders = $('.web-facilities');
  	var that = this;
  	sliders.each(function(item){
  		if(sliders[item].id != that.name)
  			$("#"+sliders[item].id).slideUp();
  	});
  	$(this.children[0]).addClass('active');
  	//setTimeout(function(){
  		$("#"+this.name).slideDown();
  	//},900)

  });


	// More Filter
	$('.more-filter-button').click(function() {
	  $('.more-filter').animate({'right': '0'});
	});
	$('.close-more-filter').click(function() {
	  $('.more-filter').animate({'right': '-400px'});
	});
	// Fullscreen Slider
	$('.controls li.prev, .controls li.next, #banner-image').click(function() {
	  $('.banner-gallery').addClass('show-gallery');
	    if($('.banner-gallery').hasClass('show-gallery')){
	  	$('body').css('overflow','hidden');
	  	$('#fullscreen-carousel').owlCarousel({
				loop: true,
				margin: 0,
				nav: true,
				navText: [ 'prev', 'next' ],
				dots: false,
				autoWidth: false,
				items: 1
			});
	  }
	});
	$('.banner-gallery .icon-close').click(function() {
	  $('.banner-gallery').removeClass('show-gallery');
	  $('body').css('overflow','');
	});

	// View More
	$('.view-more-btn').click(function(){
	 $('.the-space-view-more').toggleClass('height-full');
	 if($(this).text() == '+ More'){
	  $(this).text('- Less')
	 }else if($(this).text() == '- Less'){
	  $(this).text('+ More')
	 }
	})



	// Sticky sidebar initialize
	$( '.sticky-map' ).fixedsticky();
	// Material Datepicker initialize
	$('.datepicker').pickadate({
		selectMonths: true, // Creates a dropdown to control month
		selectYears: 15 // Creates a dropdown of 15 years to control year
	});

	// jquery UI datepicker
	$( ".jq-ui-datepicker" ).datepicker({
		changeMonth: false,
		changeYear: true,
		dayNamesMin: ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
		minDate: 0,
		firstDay: 1 // Start with Monday
	});

	// Tooltip initialize
	$('.tooltipped').tooltip();
	// Side nav close on click
	$(".button-collapse").sideNav({closeOnClick: true})
	$('body').css({'padding-bottom':$('footer').outerHeight() + "px"});
	$(window).resize(function(){
		$('body').css({'padding-bottom':$('footer').outerHeight() + "px"});
	});
	$("body").on("click", ".pop", function(){
		var className = $(this).attr('name');
		if (typeof className !== typeof undefined && className !== false) {
			className=$(this).attr('name');
		}else{
			className='';
		}
		$(".phone_number").mask(phnMask);
		openPopup($(this).attr('page'),className);
	});
	$(window).on('load', function() {
		removeFlashMessages();
		function removeFlashMessages() {
			setTimeout(function() {
				$(".flash-messages .message").hide(1000);
			}, 3000);
		}
	});
	$("body").on("submit", "#signupFrm", function(e){
		err=0;
		form = $("form#signupFrm");
		 validateRequiredField();
		 validateEmail("email");
		 checkEmailExistence();
		 if($('#referal_code').val()==''){
		 	$("input[name='social_link']").addClass('required');
		 	validateRequiredField();
		 }
		if($('#referal_code').is('[readonly]') === false){
			checkReferralExistence();
		}

		//checkEmailWaitlistExistence();
		//validatePhoneNumber("phone_number");
		validatePassword("password",'login');
		validateConfirmPassword();

		if($('input[name=social_type]').val()=='other'){
			if(!validateURL($("#instagramSoical").val())){
				msg = 'Please enter valid url.';
	        	error($("#instagramSoical"));
			}
		}
		 if(err==0){
			 $("#loader").show();
			 $.ajax({
				url: UserUrls.RegisterNew+'?tz='+tz,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data,status,xhr) {
					$("#loader").hide();
					if($.trim(data)=='1'){
						window.location.replace(UserUrls.RegisterImage);
					}else{
						alert("Something went wrong.");
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		 }
		e.preventDefault();
	});
	$("body").on("submit", "#ForgotPasswordForm", function(e){
		err=0;
		form = $("form#ForgotPasswordForm");
		validateRequiredField();
		validateEmail("email");
		if(err==0){
			 $.ajax({
				url: UserUrls.ForgotPassword,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
					$('#forgotMsg').html('');
				},
				success: function (data) {
					$("#loader").hide();
					var data = $.parseJSON(data);
					if($.trim(data.success)=='1'){
						$('.modal').modal('close');
						setTimeout(function(){
							$(".okBtn").show();
							$("#msgDiv").html(data.msg);
							$("#messagePop").modal('open');
						},1000);
					}else{
						msg=data.msg;
						error($('input[name="email"]'));
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		}
		e.preventDefault();
	});

	$("body").on("keydown", "input[type=\"tel\"],.numbersOnly", function(e){
				return numbersOnly(e);
	});
	$("body").on("keydown", ".notAllow", function(e){
		e.preventDefault();
		return false;
	});
	$("body").on("click", ".checkboxMsg", function(){
		$('div.errorRemove div.error-message').remove();
	});
	$("body").on("keydown", "input[name=\"fullname\"],.alphaOnly", function(e){
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A, Command+A
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
			 // Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
					 // let it happen, don't do anything
					 return;
		}
		// allow letters and whitespaces only.
		if(!(e.keyCode >= 65 && e.keyCode <= 120) && (e.keyCode != 32 && e.keyCode != 0) && (e.keyCode != 37 && e.keyCode != 39 && e.keyCode != 8 && e.keyCode != 46 )) {
			e.preventDefault();
		}
	});
	// initinalize modal
	 $('.modal').modal({
			dismissible: true,
			startingTop: '0',
			endingTop: '0',
			ready: function(modal, trigger) {
				if($(this.$el[0]).hasClass('open')){
					$('body').addClass('modal-open');
				}
			}
		});
		$('.parallax').parallax();

		$("body").on("click", ".modal-close", function(){
			$('.modal').modal('close');
			$('body').removeClass( "modal-open" );
		});
		$("body").on("click", ".loginBtn", function(){
				openPopup(UserUrls.Login+'?tz='+tz);
		});
		$("body").on("click", ".registerBtn", function(){
				openPopup(UserUrls.Register+'?tz='+tz);
		});
		$("body").on("submit", "#resetPasswordFrm", function(e){
			err=0;
			form = $("form#resetPasswordFrm");
			validateRequiredField();
			validatePassword("password",'');
			validateConfirmPassword();
			if(err==0){
				$.ajax({
					url: UserUrls.Reset+resetToken,
					type: 'POST',
					data: form.serialize(),
					async:false,
					beforeSend: function () {
						$("#loader").show();
					},
					success: function (data) {
						$("#loader").hide();
						var data = $.parseJSON(data);
						$("#forgotErrDIv").html('');
						if(data.success=='1'){
							$(".loginBtn").show();
							$(".successImg").show();
							$(".okBtn").hide();
						}else{
							$(".loginBtn").hide();
							$(".successImg").hide();
							$(".okBtn").show();
						}
						if(data.success=='2'){
							$("#forgotErrDIv").html(data.msg);
						}else{
							$('.modal').modal('close');
							setTimeout(function(){
								$("#msgDiv").html(data.msg);
								$("#messagePop").modal('open');
							},1000);
						}
					},
					error: function (e,x,t) {
						$("#loader").hide();
						ajax_error(e);
					},
					complete: function () {

					}
				});
			}
			e.preventDefault();
		});
	if(resetToken!=''){
		$.ajax({
			url: UserUrls.Reset+resetToken,
			type: 'GET',
			data: '',
			async:false,
			beforeSend: function () {
				$("#loader").show();
			},
			success: function (data) {
				$("#loader").hide();
				var data = $.parseJSON(data);
				if(data.success==1){
					$("#resetPasswordModal").modal('open');
				}else{
					$(".loginBtn").hide();
					$(".successImg").hide();
					$(".okBtn").show();
					$("#msgDiv").html(data.msg);
					$("#messagePop").modal('open');
				}
			},
			error: function (e,x,t) {
				$("#loader").hide();
				ajax_error(e);
			},
			complete: function () {

			}
		});
	}

	if(verificationToken!=''){
		$.ajax({
			url: UserUrls.EmailVerification+verificationToken,
			type: 'POST',
			data: '',
			async:false,
			beforeSend: function () {
				$("#loader").show();
			},
			success: function (data) {
				$("#loader").hide();
				$(".uploadPhotoStep").hide();
				var data = $.parseJSON(data);
				$("#msgDiv").html(data.msg);
				if(data.success==1){
					//$(".uploadPhotoStep").show();
					//$(".successImg").show();
					stepChange('signup-step-3');
					$("#signupSteps").modal('open');
				}else{
					$(".successImg").hide();
					$(".loginBtn").hide();
					$(".okBtn").show();
					$("#messagePop").modal('open');
				}
				//$(".loginBtn").hide();
				//$(".okBtn").show();
				//$("#messagePop").modal('open');
			},
			error: function (e,x,t) {
				$("#loader").hide();
				ajax_error(e);
			},
			complete: function () {

			}
		});
	}

	if(fbEmailErr=='3' || fbEmailErr=='4' || fbEmailErr=='5'){
		//openPopup(UserUrls.Register+'?tz='+tz);
	}else{
		if((fbEmailErr=='1' || fbEmailErr=='2' || loginRedirect=='3') && verificationToken=='' && resetToken==''){
			openPopup(UserUrls.Login+'?tz='+tz);
		}else{
			// if((loginType=='1' || loginType=='2') && verificationToken=='' && resetToken==''){
			// 	if(currentSignUpStep!=0){
			// 		if(currentSignUpStep==SIGNUP_STEP_PHONE){
			// 			stepChange('signup-step-1');
			// 			$("#signupSteps").modal('open');
			// 		}
			// 		if(currentSignUpStep==SIGNUP_STEP_OTP){
			// 			stepChange('signup-step-2');
			// 			$("#signupSteps").modal('open');
			// 		}
			// 		if(currentSignUpStep==SIGNUP_STEP_EMAIL_VERIFY){
			// 			if(loginType=='2'){
			// 				stepChange('signup-step-2');
			// 			}else{
			// 				stepChange('signup-step-3');
			// 			}
			// 			$("#signupSteps").modal('open');
			// 		}
			// 		if(currentSignUpStep==SIGNUP_STEP_UPLOAD_DP){
			// 			$("#signupSuccess").modal('open');
			// 		}
			// 	}else{
			// 		$("#welcomePop").modal('open');
			// 	}
			// }
			if(loginType=='2'){
				$("#referal-confirmation-modal").modal('open');
			}
			if(loginType=='1' || loginType=='2'){
				$.ajax({
					url: UserUrls.UpdateTimeZone,
					type: 'POST',
					data: {tz:tz},
					async:false,
					beforeSend: function () {
					},
					success: function (data) {

					}
				});
			}
		}
	}
	$("body").on("click", ".nextStep", function(){
			$.ajax({
				url: UserUrls.CheckRegisterUser,
				type: 'POST',
				data: '',
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					$("#loader").hide();
					var data = $.parseJSON(data);
					if(data.success=='1'){
						$('.modal').modal('close');
						setTimeout(function(){
							$("#signupSteps").modal('open');
							stepChange('signup-step-1');
						},1000);
					}
					if(data.success=='403'){
						window.location.replace(PageUrls.Home);
					}
				},
				error: function (e,x,t) {
					checkConnection(e);
					console.log("Something went wrong.");
				},
				complete: function () {

				}
			});
	});

	$('.carousel.carousel-slider').carousel({fullWidth: true});

	$("body").on("change", "#countries", function(){
		var countryCode='';

		if($(this).val()!=''){
			$("#phone_code").val($(this).val());
			countryCode='+'+$(this).val();
		}
		$("#countryCode").text(countryCode);
	});
	$("input[type=\"tel\"]").mask(phnMask);
	$("body").on("click", "#continuePhnBtn", function(e){
		err=0;
		form = $("form#phnFrm");
		if($("#phone_code").val()==''){
			err=1;
			$("#phone-error").html("Please select country!");
		}else{
			if($.trim($("#confirm_phone_number").val())==''){
				err=1;
				$("#phone-error").html("Please enter phone number!");
			}else{
				if($("#confirm_phone_number").val().length < 12){
					err=1;
					$("#phone-error").html("Please enter correct phone number!");
				}
			}
		}
		if(err==0){
			$.ajax({
				url: UserUrls.SendOTP,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					$("#loader").hide();
					var data = $.parseJSON(data);
					if(data.success!='403'){
						if(data.success=='1'){
							$(".steps-heading").hide();
							$(".phoneConfirmDiv").removeClass('hide');
							$("#phoneEnterDiv").addClass('hide');
							$("#otp-error").html('');
							$(".otp").val('-');
							$('input[name="otp1"]').focus();
							$("#signup-step-1-heading2").show();
						}else{
							$("#phone-error").html(data.msg);
						}
					}else{
						window.location.replace(PageUrls.Home);
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		}
		e.preventDefault();
	});
	$("body").on("click", "#checkOtpBtn", function(){
		form = $("form#checkOtpFrm");
		$("#otp-error").html('');
		err=0;
		for(i=1;i<=6;i++){
			if($('input[name="otp'+i+'"]').val()==''){
				err=1;
			}
		}
		//if(err==0){
			$.ajax({
				url: UserUrls.CheckOTP,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					$("#loader").hide();
					var data = $.parseJSON(data);
					if(data.success=='1'){
						$("#otp-error").html('');
						stepChange('signup-step-2');
					}
					if(data.success=='0'){
						 $("#otp-error").html(data.msg);
					}
					if(data.success=='403'){
						 window.location.replace(PageUrls.Home);
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		//}
	});

	$("body").on("click", "#resendEmailBtn", function(){
		form = $("form#resendEmailFrm");
		err=0;
		validateRequiredField();
		validateEmail("verifyEmail");
		$("#emailVerifiedMsgDiv").html('');
		if(err==0){
			$.ajax({
				url: UserUrls.ResendMail,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					$("#loader").hide();
					var data = $.parseJSON(data);
					$(".errorEmailDiv").addClass('hide');
					$(".emailVerifiedMsgDiv").html('');
					if(data.success=='403'){
						window.location.replace(PageUrls.Home);
					}else{
						msg=data.msg;
						if(data.success=='1' || data.success=='2'){
							$(".errorEmailDiv").removeClass('hide');
							$(".emailVerifiedMsgDiv").html(msg);
						}else{
							error($('input[name="verifyEmail"]'));
						}
					}
				},
			});
		}
	});
	$("ul.tabs li a").click(function (e) {
		e.preventDefault();
		return false;
	});
	$("body").on("click", ".uploadPhotoStep", function(){
		$('.modal').modal('close');
		setTimeout(function(){
			$("#signupSteps").modal('open');
			stepChange('signup-step-3');
		},1000);
	});
	$("body").on("click", "#emailVerificationDoneBtn", function(){
		form = $("form#resendEmailFrm");
		err=0;
		validateRequiredField();
		validateEmail("verifyEmail");
		if(err==0){
			$.ajax({
				url: UserUrls.checkEmailVerificationDone,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					$("#loader").hide();
					var data = $.parseJSON(data);
					$(".errorEmailDiv").addClass('hide');
					$(".emailVerifiedMsgDiv").html('');
					msg=data.msg;
					if(data.success=='403'){
						window.location.replace(PageUrls.Home);
					}else{
						if(data.success=='1' || data.success=='2'){
							stepChange('signup-step-3');
						}else{
							$(".errorEmailDiv").removeClass('hide');
							$(".emailVerifiedMsgDiv").html(msg);
						}
					}
				},
			});
		}
	});
	$("body").on("submit", "#loginFrm", function(e){
		err=0;
		form = $("form#loginFrm");
		validateRequiredField();
		validateEmail("email");
		validatePassword("password",'login');
		if(err==0){
			$.ajax({
				url: UserUrls.Login,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data) {
					var data = $.parseJSON(data);
					if($.trim(data.success)=='1'){
						window.location.replace(PageUrls.Home);
                      	// if(loginRedirect==''){
                      	// 	location.reload();
                      	// }else{
                      	// 	window.location.replace(PageUrls.Home);
                      	// }
					}else{
						$("#loginErrMsg").html(data.msg);
						$("#loader").hide()
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		}
		e.preventDefault();
	});
	$("body").on("click", "#mayBeLater", function(){
		$('.modal').modal('close');
		$.ajax({
			url: UserUrls.UpdateCompleteStatus,
			type: 'POST',
			async:false,
			beforeSend: function () {
				$("#loader").show();
			},
			success: function (data) {
				var data = $.parseJSON(data);
				if($.trim(data.success)=='1'){
					setTimeout(function(){
						$("#signupSuccess").modal('open');
					},1000);
				}
				$("#loader").hide();
			},
			error: function (e,x,t) {
				$("#loader").hide();
				ajax_error(e);
			},
			complete: function () {

			}
		});
	});
	$("body").on("click", ".exploreGenie, .vendorMembershipPlan, .venueList, .planEvent", function () {
		var type = $(this).attr('data-title');
		if (type == 'vendorMembershipPlan') {
			registerationComplete(type);
		} else if (type == 'exploreGenie') {
			registerationComplete(type);
		} else if (type == 'planEvent') {
			registerationComplete(type);
		} else if (type == 'venueList') {
			registerationComplete(type);
		}
	});
	$("body").on("keypress", ".decimalValue", function (e) {
		var charCode = (e.which) ? e.which : e.keyCode;
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
				 // Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
				 // Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
						 // let it happen, don't do anything
						 return;
		}
		var $this = $(this);
		if ((e.which != 46 || $this.val().indexOf('.') != -1) &&
			 ((e.which < 48 || e.which > 57) &&
			 (e.which != 0 && e.which != 8))) {
					 e.preventDefault();
		}
		var text = $(this).val();
		if ((e.which == 46) && (text.indexOf('.') == -1)) {
				setTimeout(function() {
						if ($this.val().substring($this.val().indexOf('.')).length > 3) {
								$this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
						}
				}, 1);
		}
		if ((text.indexOf('.') != -1) &&
				(text.substring(text.indexOf('.')).length > 2) &&
				(e.which != 0 && e.which != 8) &&
				($(this)[0].selectionStart >= text.length - 2)) {
						e.preventDefault();
		}
		return true;
	});

	// for 2 number of decimal allowed
	$("body").on("keypress", ".decimalCl", function (event) {
        var mask = new RegExp('^[0-9.]*$');
        if (!event.charCode)
            return true;
        if (event.charCode == 46 && this.value.indexOf('.') != -1 )
            return false;

       	if ((this.value.indexOf('.') != -1) &&
			(this.value.substring(this.value.indexOf('.')).length > 2) &&
			(event.which != 0 && event.which != 8) &&
			($(this)[0].selectionStart >= this.value.length - 2)) {
			event.preventDefault();
		}

        var part1 = this.value.substring(0, this.selectionStart);
        var part2 = this.value.substring(this.selectionEnd, this.value.length);
        if (!mask.test(part1 + String.fromCharCode(event.charCode) + part2))
        	return false;
    });

	$("#ui-datepicker-div").hide();

	$("body").on("click", ".contactusBtn", function(e){
		err=0;
		form = $("form#contactusFrm");
		validateRequiredField();
		validateEmail("email");
		validateMessageContactus("message");
		if(err==0){
		 $("#loader").show();
		 	$.ajax({
				url: UserUrls.Contactus,
				type: 'POST',
				data: form.serialize(),
				async:false,
				beforeSend: function () {
					$("#loader").show();
				},
				success: function (data,status,xhr) {
					var data = jQuery.parseJSON(data);
					$("#loader").hide();
					if(data.success =='1'){
						$("#confirmPopup").modal('open');
					}else{
						$("#contactusErrMsg").html(data.msg);
					}
				},
				error: function (e,x,t) {
					$("#loader").hide();
					ajax_error(e);
				},
				complete: function () {

				}
			});
		}
		e.preventDefault();
	});
	// Multiselect
	$(document).on('focus', 'input[type=text]', function () {
    	$('.multiple-select-dropdown').find('input').addClass('filled-in');
  	});

  	$('.material-select').material_select();

    $('.multiple-select-dropdown').find('input').addClass('filled-in');
});
/*navigation*/
$(window).scroll(function() {
	var scroll = $(window).scrollTop();
	if (scroll >= 50) {
			$(".navbar-fixed").addClass("navbar-black");
	} else {
			$(".navbar-fixed").removeClass("navbar-black");
	}
});