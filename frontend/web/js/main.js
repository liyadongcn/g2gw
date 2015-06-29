
//Popup the signup modal

function signup(value){	
	//$('#signupModal').modal('hide');
	$('#signupModal').modal('show')
		.find('#modalSignupContent')
		.load(value);	
}