$(function () {
	// body...
	'use strict';
	var usererror = true,
		emailerror = true,
		phoneerror = true,
		massageerror = true;
	$('.username').blur(function(){
		if ($(this).val().length < 4) {
			$(this).css('border','1px solid #f00');
			$(this).parent().find('.custum-alert').fadeIn(200);

			usererror = true;
		}else{
			$(this).css('border','1px solid #080');
			$(this).parent().find('.custum-alert').fadeOut(200);
	
			usererror = false;
		}
	});
	$('.email').blur(function(){
	if ($(this).val().length < 4) {
		$(this).css('border','1px solid #f00');
		$(this).parent().find('.custum-alert').fadeIn(200);
		emailerror = true;
	}else{
		$(this).css('border','1px solid #080');
		$(this).parent().find('.custum-alert').fadeOut(200);

		emailerror = false;
	}
});
	$('.phone').blur(function(){
	if ($(this).val().length < 11) {
		$(this).css('border','1px solid #f00');
		$(this).parent().find('.custum-alert').fadeIn(200);
		phoneerror = true;
	}else{
		$(this).css('border','1px solid #080');
		$(this).parent().find('.custum-alert').fadeOut(200);

		phoneerror = false;
	}
});
	$('.massage').blur(function(){
	if ($(this).val().length < 10) {
		$(this).css('border','1px solid #f00');
		$(this).parent().find('.custum-alert').fadeIn(200);
		massageerror = true;
	}else{
		$(this).css('border','1px solid #080');
		$(this).parent().find('.custum-alert').fadeOut(200);

		massageerror = false;
	}
});
	//sibmit Form Validation
	$('.contact-form').submit(function(e){
		if (usererror === true || emailerror === true || phoneerror === true || massageerror === true ) {
			e.preventDefault();
			$('.username , .email , .phone , .massage').blur();

		}	});
});