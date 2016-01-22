(function($) {
    $(function() {
        var jcarousel = $('.jcarousel');

        jcarousel
            .on('jcarousel:reload jcarousel:create', function () {
                var carousel = $(this),
                    width = carousel.innerWidth();

                if (width >= 600) {
                    width = width / 3;
                } else if (width >= 350) {
                    width = width / 2;
                }

                carousel.jcarousel('items').css('width', Math.ceil(width) + 'px');
            })                     
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev')               
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-control-prev').click(function() {
            var visible = $('.jcarousel').jcarousel('visible');
            // console.log(visible);
            $.each( visible, function( key, value ) {
              if(key == 1) {
                 $.each( value, function( subkey, subvalue ) {
                     if(subkey=='id') {
                         // console.log( key2 + ": " + subvalue);   
                         var card_id = subvalue;
                         $('.card_id').val(card_id);
                         $('.jcarousel li img').addClass('img-inactive');
                         $('.card_id_img_'+card_id).removeClass('img-inactive');
                         console.log(card_id);
                     }
                });                           
              }
            });           
        });

        $('.jcarousel-control-next').click(function() {
            var visible = $('.jcarousel').jcarousel('visible');
            // console.log(visible);
            $.each( visible, function( key, value ) {
              if(key == 1) {
                 $.each( value, function( subkey, subvalue ) {
                     if(subkey=='id') {
                         // console.log( key2 + ": " + subvalue);   
                         var card_id = subvalue;
                         $('.card_id').val(card_id);
                         $('.jcarousel li img').addClass('img-inactive');
                         $('.card_id_img_'+card_id).removeClass('img-inactive');
                         console.log(card_id);
                     }
                });                           
              }
            });           
        });
                            
       
    });
})(jQuery);
