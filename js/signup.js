$(document).ready(function(){
	$('#signUpForm').validate({
		errorElement: "span",
		errorClass: "help-block",
		rules:{
			userFirstName:{
				required: true
			},
			userLastName:{
				required: true
			},	
			userEmail:{
				required: true
			},
			userPassword:{
				required: true
			},
			confirmPassword:{
				required: true
			},
			userBirthday:{
				required: true
			}
	   },
	   submitHandler: function (form) { // for demo
           alert('valid form submitted'); // for demo
           return true; // for demo
       },
       highlight: function(element) {

       	$(element).closest('.form-group').addClass('has-error').addClass('red-border');
       },
       unhighlight: function(element) {
       	$(element).closest('.form-group').removeClass('has-error').addClass('has-success').removeClass('red-border');
       }
   });
});	