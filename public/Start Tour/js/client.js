var site_GL;
$(document).ready(function(){

    site_GL = new GlobalActions();

});

var GlobalActions = function() {
    this.init();
};


/*initialize object*/
GlobalActions.prototype.init = function() {
    this.site.actions();
};

//logged out index form
GlobalActions.prototype.site = {

	actions: function(){

        var that=this;
        $('body').on('click', '.slider_wrapper .table span.btn_next', function(){     

        	var parent=$(this).parents('.active'),
        		next=parent.prev();

        	parent.removeClass('active');
        	next.addClass('active');

            return false;
        });
		
		var slWrapper=$('.slider_wrapper'),
			bdW=slWrapper.width(),
			bdH=slWrapper.height();

		$('#tableStyles').html('.slider_wrapper .table{width: '+bdW+'px;height: '+bdH+'px;}  .slider_wrapper .table img{max-width: '+bdW+'px;max-height: '+bdH+'px;}');

		$( window ).resize(function() {
			  var slWrapper=$('.slider_wrapper'),
				bdW=slWrapper.width(),
				bdH=slWrapper.height();

			$('#tableStyles').html('.slider_wrapper .table{width: '+bdW+'px;height: '+bdH+'px;}  .slider_wrapper .table img{max-width: '+bdW+'px;max-height: '+bdH+'px;}');
		});


    }
};
