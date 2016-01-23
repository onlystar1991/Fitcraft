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

		var $validator = $(".form-wizard-register").validate({

		  rules: {
		    email: {
		      required: true,
		      email: true
		      ,remote:{
                      url: '/public/auth/check-email',
                      type: "post",
                      async: false,
                      data:
                      {
                          email: function()
                          {
                              return $('.form-wizard-register :input[name="email"]').val();
                          }
                      }
               }
		    },
		    name: {
		      required: true,
		      minlength:6
		    },
		    athlete_name: {
		      required: true,
		      minlength: 2,
		      maxlength: 12,
		      remote:{
                      url: '/public/auth/check-nickname',
                      type: "post",
                      async: false,
                      data:
                      {
                          nickname: function()
                          {
                              return $('.form-wizard-register :input[name="athlete_name"]').val();
                          }
                      }                  
               }		      
		    }
			,password: {
		      required: true,
		      minlength:8
		    },
		    confirm_password: {
		      equalTo: ".register-password"
		    },
		    gender: {
		      required: true
		    },
		    ft: {
		      required: true
		    }
		    ,inch: {
		      required: true
		    }
		    ,lbs: {
		      required: true
		    }
		    ,body_fat: {
		      required: true
		    }
		    ,day: {
		      required: true
		    }
		    ,month: {
		      required: true
		    }
		    ,day: {
		      required: true
		    }
		    ,year: {
		      required: true
		    }		    		    
		  },
		  messages:
          {
          	 ft: { required: "is required"}, 
          	 inch: { required: "is required"}, 
          	 lbs: { required: "is required"}, 
          	 body_fat: { required: "is required"}, 
          	 day: { required: "is required"}, 
          	 month: { required: "is required"}, 
          	 year: { required: "is required"},
             email:
             {
                required: "Please enter your email address.",
                email: "Please enter a valid email address .",
                remote: jQuery.validator.format("{0} is already taken.")
             }, 
             athlete_name:
             {
                required: "Please enter your athlete name.",
                remote: jQuery.validator.format("{0} is already taken.")
             }                         
          }
         ,errorPlacement: function(error, element) {    
             // console.log(element.is("select"));
             if(element.is("select"))   
             {    
                error.insertAfter(element.parent(".form-input"));
             }                                   
             else  {
             	$('.register-modal__btn-available').hide();
             	error.insertAfter(element);                                                
             }
         }

		});
	  	$('.register-container').bootstrapWizard({
	  		'tabClass': 'nav nav-pills',
	  		'onNext': function(tab, navigation, index) {
	  			var $valid = $(".form-wizard-register").valid();
	  			if(!$valid) {
	  				$validator.focusInvalid();
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

		$('.register-container .btn-select-step3').click(function() {
				var $valid = $(".form-wizard-register").valid();
	  			if(!$valid) {
	  				$validator.focusInvalid();
	  				return false;
	  			} else {	  				
	  				// . 	
	  			    // jQuery("#go_reg").submit(); 			
	  				jQuery('.form-wizard-register').submit();	  				 
	  				return true;
	  			}
		});
		
	});

