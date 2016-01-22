	$(document).ready(function() {
		// $.validator.setDefaults({ ignore: [] });
		
		$(document).on('keypress','.form-input',function(e){
		    if(e.which == 13) {		      
		        return false;
		    }
		});

		$(document).on('keypress','.input-athlete-register',function(e){
		    if(e.which == 13) {
		        return false;
		    }
		});		

		/*-----------------------------------------------------------------------------------*/
		/*    SIGNUP FORM
		/*-----------------------------------------------------------------------------------*/
	    $('.form-wizard-register').bootstrapValidator({
	        message: 'This value is not valid',
	        feedbackIcons: {
	            valid: 'glyphicon glyphicon-ok',
	            invalid: 'glyphicon glyphicon-remove',
	            validating: 'glyphicon glyphicon-refresh'
	        },
	        fields: {
	            name: {
	                validators: {
	                    notEmpty: {
	                        message: 'The first name is required and cannot be empty'
	                    }
	                }
	            }
	        },
	        submitButtons: 'button[type="text"]'
	    });

		// var $validator= $('.form-wizard-register').bootstrapValidator({
		//     fields: {
		//         name: {
		//             validators: {
		//                 notEmpty: {
		//                     message: 'The field is required'
		//                 }             
		//             }
		//         }
		//     }    
		// });
			$('.register-modal__btn-next').on('click', function() {
				// $('.form-wizard-register').bootstrapValidator();
			});
	  	$('.register-container').bootstrapWizard({
	  		'tabClass': 'nav nav-pills',
	  		'onNext': function(tab, navigation, index) {

 				var $validator=$('.form-wizard-register').bootstrapValidator('validate');
   				// var $valid = $(".form-wizard-register").valid();	  			
	  			if(!$validator) {
	  				$validator.focusInvalid();
	  				alert('zg');
	  				return false;
	  			} 
 				var $current = index + 1; 
 				// step h1
 				if($current == 2) {
 					$('.step-name').html('STEP 1: ACCOUNT INFO');
 					$('.header-steps').removeClass('header-steps--step3');
 					$('.progress-step1').hide();
 					$('.progress-step2').show();
 					$('.progress-step3').hide();
 				} else if($current == 3) { 
 					$('.header-steps').addClass('header-steps--step3');
					// $('.bx-wrapper .bx-viewport').css("height","326"); 									
					// $('.bx-wrapper .bx-viewport .bxslider li').css("width","200"); 	
 					$('.step-name').html('STEP 3: NAME AND PLAYER CARD');
 					$('.progress-step1').hide();
 					$('.progress-step2').hide();
 					$('.progress-step3').show();

 					$('.wizard .next').hide();
 					$('.wizard .finish').show();
 				} else {
 					$('.header-steps').removeClass('header-steps--step3');
 					$('.progress-step1').hide();
 					$('.progress-step2').show();
 					$('.progress-step3').hide();

 					$('.step-name').html('STEP 2: ATHLETE INFO');	

 				}	
	  		}
	  	});

		
	});