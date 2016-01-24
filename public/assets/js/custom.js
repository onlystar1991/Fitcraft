//document.getElementById("uploadBtn").onchange = function () {
//    document.getElementById("uploadFile").value = this.value;
//};

$.modalOpen = function(url,title, option){
    $('#ajaxModal').find('.modal-title').html(title);
    $('#ajaxModal').find('.modal-body').html('Loading...');
    $('#ajaxModal').modal('show');
    $.get(url,function(response){
        $('#ajaxModal').find('.modal-body').html(response.html);
    },'JSON')

}
/*
$(document).on('click','.btn-account-edit',function(){
    var $this = $(this);
    var field = $(this).attr('data-field');
    $('input[name="field['+field+']"]').removeAttr('disabled');
    $('select[name="field['+field+']"]').removeAttr('disabled');
    $this.removeClass('btn-account-edit btn-grey').addClass('btn-account-save btn-green').text('Save');
});
$(document).on('click','.btn-account-save',function(){
    var $this = $(this);
    var field = $(this).attr('data-field');

    var p = { field:field,value: $('input[name="field['+field+']"]').val()};
    $.post('/users/save-account',p,function(response){
        if ( response.success == true ) {
            $this.removeClass('btn-account-save btn-green').addClass(' btn-account-edit btn-grey').text('Edit');
            $('input[name="field['+field+']"]').attr('disabled','disabled');
            $('select[name="field['+field+']"]').attr('disabled','disabled');
            return true;
        }

        console.log(response.message);

    },'JSON');

});
*/


$(document).on('click','.show_description i',function(){
   $(this).toggleClass('arrow__up');
   $(this).parent().parent().find('.objectives__info').toggle();

});
$(document).on('click','.ride_description i',function(){
   $(this).toggleClass('arrow__up');
   $(this).parent().parent().toggleClass('highlight_green');
   $(this).parent().parent().find('.ride_info').toggle();
});

$(document).on('click','.feeed_visible',function(){
   $(this).find('.icon__arrow').toggleClass('arrow__up');
   $(this).parent().find('.feeed_hidden').toggle();
}); 

$(document).on('click','.feed_user_show_details',function(){
   $(this).toggleClass('arrow__up');
   console.log($(this).parent());
   $(this).parent().siblings('.recent_feeed_user_info').toggle();
});
$(document).on('click','.ride_search_advanced_label',function(){
   $(this).find('i').toggleClass('arrow__up');

   $('.ride_search_advanced_container').toggle();
});
$(document).on('click','.ridedetails_info_show',function(){
   $(this).toggleClass('arrow__up');

    $(this).parent().parent().parent().siblings('.ridesearch_details').toggle();
    $(this).parents('.search_rides_res').toggleClass('opened_ride_det');
});

//$(document).on('click','.check-all',function(){
//    var checkboxes = $('.table-files').find(':checkbox:not(:disabled)');
//    if($(this).is(':checked')) {
//        checkboxes.prop('checked', true);
//        checkboxes.attr('checked', true);
//    } else {
//        checkboxes.prop('checked', false);
//        checkboxes.attr('checked', false);
//    }
//});

$(document).on('click','.tab-upload',function(){
    $('.tab-upload').removeClass('active');
    $(this).addClass('active');
    var tab = $(this).attr('data-select-tab');
    $('.upload_tab_item').hide();
    $('#'+tab).show();
});



/*
$(document).on('change','#uploadFileInput' , function(){
    $('.form_upload_files').ajaxSubmit({
        target:   '#targetLayer',
        url: "/upload/file",
        beforeSubmit: function() {
            $(".progress-bar").height('0%');
        },
        uploadProgress: function (event, position, total, percentComplete){
            $(".progress-bar").height(percentComplete + '%');
        },
        success:function (){
            alert('222');
            //$(".progress-bar").height('0%');
            var tmpl = $('#tmpl-upload-file').html();
            console.log(tmpl);
            //
            //var compiledTmpl = _.template(tmpl, { 'item':item});
            //$('.members_in_canada_container').append(compiledTmpl);

        },
        resetForm: true
    });
    return false;
});
*/
$(document).on('click','.btn-upload-file-action',function(){
   var p = $('.form-upload-files-list').serialize();
    $.post('/upload/processing',p,function(){

    });
    getProgress();
})

//Start receiving progress
function getProgress(){
    var p = $('.form-upload-files-list').serialize();
    $.get('/upload/progress_json/',p,function(response){
        $(".progress-bar").height(response + '%');
        if ( response < 100 ) {
                getProgress();
        }
    });
}



jQuery(document).ready(function ($) {
    'use strict';

    $('.scroll-pane').jScrollPane({ autoReinitialise: true });

    $('.modal').on('shown.bs.modal', function (e) {
        $('.scroll-pane-moz').jScrollPane();

    });

    $( window ).resize(function() {
        $('.scroll-pane').jScrollPane({autoReinitialise: true });
    });

    // $('.dropdown-custom').jScrollPane({autoReinitialise: true })
    $('.jspHorizontalBar').remove();

    // CENTERED MODALS
    // phase one - store every dialog's height
    $('.modal').each(function () {
        var t = $(this),
            d = t.find('.modal-dialog'),
            fadeClass = (t.is('.fade') ? 'fade' : '');
        // render dialog
        t.removeClass('fade')
            .addClass('invisible')
            .css('display', 'block');
        // read and store dialog height
        d.data('height', d.height());
        // hide dialog again
        t.css('display', '')
            .removeClass('invisible')
            .addClass(fadeClass);
    });
    // phase two - set margin-top on every dialog show
    $('.modal').on('show.bs.modal', function () {
        //var t = $(this),
        //    d = t.find('.modal-dialog'),
        //    dh = d.data('height'),
        //    w = $(window).width(),
        //    h = $(window).height();
        //// if it is desktop & dialog is lower than viewport
        //// (set your own values)
        //if (w > 380 && (dh + 60) < h) {
        //    d.css('margin-top', Math.round(0.96 * (h - dh) / 2));
        //} else {
        //    d.css('margin-top', '');
        //}


    });

        //$('#rideSetupModal').modal();
        //$('#rideLibraryModal').modal();
        //$('#achievementsModal').modal();

});


$(document).on('click','.objectives_li--achievements > a',function(){
    $('.objectives_li--achievements a').removeClass('active');
    $('ul.objectives_menu--submeniu').hide();
    $(this).addClass('active');
    $(this).siblings('ul').toggle();
    return false;
});

$(document).on('click','.objectives_li--achievements > ul > li a',function(){
    $('.objectives_li--achievements > ul > li a').removeClass('active');      
    $(this).addClass('active');
    return false;
});

$(function() {


    $(".content-wrapper").draggable({
        revertDuration: 10,
        helper: function(){
            var container = $('<div/>').attr('id', 'rankDrag');
            container.append($(this).clone());
            return container;
        },
        appendTo: '#trophies_current',
        start: function(e, ui) {
            $(this).hide();
            $('#rankDrag').width($('#stack-rank .content-wrapper').width());
        },
        stop: function(e, ui) {
            $(this).show();
            $(this).parents('.pipeline-holder').removeClass('holder-empty');
        },
        drag: function(e, ui) {
            $(this).parents('.pipeline-holder').addClass('holder-empty');
        }
    });

    $(".pipeline-holder" ).droppable({
        activeClass: "ui-holder-highlight",
        hoverClass: "u-holder-active",
        tolerance: "pointer",
        over: function( event, ui ) {
            rearrange($(this).attr('id'));
        },
        out: function( event, ui ) {
            resetPositions();
        },
        drop: function( event, ui ) {
            var dragid = ui.draggable.attr("id");
            var dropid = $(this).attr("id");
            var isEmpty = $(this).hasClass('holder-empty');
            var next = $(this).parents('.pipeline-rank-row').next().find('.pipeline-holder');
            var isNextEmpty = next.hasClass('holder-empty');

            if (isEmpty) {
                $(this).append(ui.draggable);
                $(this).removeClass('holder-empty');
                $(this).siblings('.remember-my-position-dropped').html(dragid);
                $('.pipeline-holder').each(function(){

                    var $icon = $(this).find('.icon');

                    if ( !$icon.hasClass('icon') ) {
                        if ( !$(this).hasClass('holder-empty') ) {
                            $(this).addClass('holder-empty');
                        }

                    }

                    var tid = $(this).attr('id');
                    var cid = $(this).siblings('.remember-my-position-hover').html();

                    if (tid == dropid) {
                        $(this).siblings('.remember-my-position-dropped').html(dragid);
                    } else {
                        if (cid) {
                            $(this).siblings('.remember-my-position-dropped').html(cid);
                        }
                        var hasContent = $(this).find('.content-wrapper').length;
                        if (hasContent) {
                            $(this).parents('.pipeline-holder').removeClass('holder-empty');
                        } else {
                            $(this).parents('.pipeline-holder').addClass('holder-empty');
                        }
                        $(this).siblings('.remember-my-position-hover').html('');
                    }


                });

            }
        }
    });


    $("#content-list" ).droppable({
        activeClass: "ui-content-list-highlight",
        hoverClass: "ui-content-list-active",
        tolerance: "pointer",
        drop: function( event, ui ) {
            $(this).append(ui.draggable);
            var draggedId = $(ui.draggable).attr('id');
            $('.pipeline-rank-row').each(function(){
                var oldPosition = $(this).find('.remember-my-position-dropped').html();
                if (draggedId == oldPosition) {
                    $(this).find('.remember-my-position-dropped').html('');
                }
            });
        }
    });

    function rearrange(dropid) {
        var emptyHolders = [];
        var isRanked = [];
        var cid = dropid.substring(14);
        var isEmpty = $('#'+dropid).hasClass('holder-empty');

        if(!isEmpty) {

            $('.pipeline-holder').each(function(){

                var $icon = $(this).find('.icon');

                if ( !$icon.hasClass('icon') ) {
                    if ( !$(this).hasClass('holder-empty') ) {
                        $(this).addClass('holder-empty');
                    }

                }

                if($(this).hasClass('holder-empty')){
                    var eid = $(this).attr('id');
                    emptyHolders.push(eid.substring(14));
                } else {
                    var tid = $(this).attr('id');
                    isRanked.push(tid.substring(14));
                }

            });
            var nextEmpty = null;
            var prevEmpty = null;

            for (var i = 0; i < emptyHolders.length; i++) {
                var currentEmpty = emptyHolders[i];
                if (currentEmpty > cid) {
                    nextEmpty = currentEmpty;
                    i = emptyHolders.length;
                } else {
                    prevEmpty = parseInt(currentEmpty);
                }
            }

            if (nextEmpty != null) {
                var moveMe = nextEmpty -1;
                console.log('---> You are over slot number ' + cid + '. The next empty slot is '+nextEmpty+'.');

                for (var i = moveMe; i >= cid; i--) {

                    var nextcount = i + 1;
                    console.log('I moved the contents of slot '+ i +' to slot '+ nextcount+ '.');
                    var me = $('#pipeline-rank-' + i);

                    var next = $('#pipeline-rank-' + i).parents('.pipeline-rank-row').next().find('.pipeline-holder');
                    var pid = $('#pipeline-rank-' + i).find('.content-wrapper').attr('id');

                    next.append($('#pipeline-rank-' + i).find('.content-wrapper'));
                    next.removeClass('holder-empty');
                    next.siblings('.remember-my-position-hover').html(pid);
                }
                $('#pipeline-rank-' + cid).addClass('holder-empty');
                console.log('');
            } else if (prevEmpty != null) {
                var moveMe = prevEmpty + 1;
                console.log(prevEmpty);
                console.log('---> You are over slot number ' + cid + '. The first previous empty slot is '+prevEmpty+'.');

                for (var i = moveMe; i <= cid; i++) {

                    var prevcount = i - 1;
                    console.log('I moved the contents of slot '+ i +' to slot '+ prevcount+ '.');
                    var me = $('#pipeline-rank-' + i);

                    var prev = $('#pipeline-rank-' + i).parents('.pipeline-rank-row').prev().find('.pipeline-holder');
                    var pid = $('#pipeline-rank-' + i).find('.content-wrapper').attr('id');

                    prev.append($('#pipeline-rank-' + i).find('.content-wrapper'));
                    prev.removeClass('holder-empty');
                    prev.siblings('.remember-my-position-hover').html(pid);
                }
                $('#pipeline-rank-' + cid).addClass('holder-empty');
                console.log('');
            }
        }


    }

    function resetPositions() {
        $('.pipeline-holder').each(function(){

            var $icon = $(this).find('.icon');

            if ( !$icon.hasClass('icon') ) {
                if ( !$(this).hasClass('holder-empty') ) {
                    $(this).addClass('holder-empty');
                }
            }

            var pid = $(this).siblings('.remember-my-position-dropped').html();

            if(pid) {
                $(this).append($('#'+pid));
                $(this).removeClass('holder-empty');
            } else {
                $(this).addClass('holder-empty');
            }

            $(this).siblings('.remember-my-position-hover').html('');

        });
    }


    toKg(550);

});

// change WIGHT/HEIGHT FT->M 
function changeWH(){
    //imperial = FT/INCH/LBS
    //metric = M/COM/KG
    var type = $('.type_convertor').val();
    
    if(type == 'imperial') {
        // change to metric
        $('.type_convertor').val('metric');
        // FT TO M
        $('.reg-height-1-label').html('M');
        var height_ft  = $('.reg-height-1').val();
        var height_inc = $('.reg-height-2').val();        
        var cm = Math.round((height_ft * 12 / 0.393700787) + (height_inc / 0.393700787) );
        var m  = parseInt(cm / 100);        
        var cm = cm - ( m * 100 );       
        $('.reg-height-1').val(m);
    } else {
        // change to imperial
        $('.type_convertor').val('imperial');
        // var height_m  = $('.reg-height-1').val();
        // var height_cm = $('.reg-height-2').val();
        // var cm  = parseInt(height_m) * 100 + parseInt(height_cm);      
        // var inc = Math.round(cm *  0.393700787);
        // var ft =  float2int(inc / 12);
        // var inc= Math.round(frac(inc / 12) * 12);
        // M TO FT
        $('.reg-height-1-label').html('FT');
        // $('.reg-height-1').val(ft);
        $('.reg-height-1').val($('.reg-height-1-m').val());
       

    }
}

$(document).on('keypress','.input-athlete-name',function(){
    var nickname = $(this).val();
    $.post('/auth/check-nickname', {nickname: nickname}, function(data) {    

        if (data == 'true')
        {                          
           $('.register-modal__btn-available').hide();
                  
        } else {
           $('.register-modal__btn-available').show();
           // $('.athlete_name_erorr').show();
        }
    });
});

function toKg(isLbs){

    isKg = isLbs/2.2;
   // console.log(isKg.toFixed(1));
}

function toCm(isInch,cmField){

    isCm = isInch*2.54;
    document.forms.form1[cmField].value = isCm.toFixed(1);
}

/* reg weight/height */