jQuery(document).ready(function($){

	// Don't send the data twice

	var didSend = false;

	// Wait until email has been entered

	$( 'input#email_id' ).blur(function() {

		// Validate email
		var email = $('input#email_id').val();
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  		if( regex.test( email ) == true && didSend == false ) {

			var data = {
				'action'		: 'wpf_pre_submit',
				'user_email' 	: $('input#email_id').val(),
				'first_name' 	: $('input#first_name_id').val(),
				'last_name'		: $('input#last_name_id').val(),
				'phone' 		: $('input#phone_id').val(),
			}

			$.post(ajaxurl, data);

			didSend = true;

		}

	});

});