app.service('userTooltipService',function($http){
    var tooltips;
    return {
        setTooltips: function() {
            tooltips = globalTutorial;
            this.checkForPopup();
        },
        getTooltip: function(key){

            for (var k in tooltips) {
                if(k==key){
                    return tooltips[k];
                }
            }

        },
        refreshCount:0,
        saveTooltip: function(key) {

            var that=this;

            for (var k in tooltips) {
                if(k==key){
                    tooltips[k]=1;
                }
            }

            return $http.post('/tutorial/update', {lesson:key} ).
                success(function(data, status, headers, config){
                    if(key=='upload_ride_btn'||key=='browse_file__btn'||key=='upload_file_btn'||key=='upload_complete_next'){
                        that.refreshCount++;
                        if(that.refreshCount==4){
                            window.location.reload();
                        }
                    }
                }).
                error(function(data, status, headers, config){
                    alert('server error');
              });

        },
        checkForPopup: function(){

            var that=this;

          $('.border_tooltip_hightlight').removeClass('border_tooltip_hightlight');

            $('.site_tooltip').fadeOut(200);
            $('body').removeClass('faded');
            $('#AthProfileWrap').show();


            if(!tooltips.player_card_btn || !tooltips.choose_card_btn){ //player button

                if(!tooltips.player_card_btn){
                    
                    this.appendPopup(
                        $('#mainContainer'),
                        $('.edit_avatar .btn').eq(0),
                        $('<div class="site_tooltip tl"><div class="l"></div></div><div class="site_tooltip br"><div class="l"><div class="tooltip_message player_card_1"></div></div></div>')
                        );

                }

            } else if(!tooltips.upload_ride_btn || !tooltips.upload_complete_next){ //upload

                if(!tooltips.upload_ride_btn){
                    
                this.appendPopup(
                    $('#mainContainer'),
                    $('.account__menu__li_upload a').eq(0),
                    $('<div class="site_tooltip tl"><div class="l"></div></div><div class="site_tooltip br"><div class="l"><div class="tooltip_message upload_card_1"></div></div></div>'),
                    true
                    );

                }

            } else if(!tooltips.activity_feed_next){ //activity feed
                this.appendPopup(
                    $('#mainContainer'),
                    $('.recent__activities').eq(0),
                    $('<div class="site_tooltip tl"><div class="l"><div class="tooltip_message activity_card_1"><span class="go_next" data-click="activity_feed_next"></span></div></div></div><div class="site_tooltip br"><div class="l"></div></div>'),
                    true
                    );
            } else if(!tooltips.athlete_profile_next){ //profile
                this.appendPopup(
                    $('#mainContainer'),
                    $('#AthProfileWrap'),
                    $('<div class="site_tooltip tl"><div class="l"><div class="tooltip_message ath_prof_card_1"></div></div></div><div class="site_tooltip br"><div class="l"><div class="tooltip_message ath_prof_card_2_hide"></div><div class="tooltip_message ath_prof_card_3"><span class="go_next" data-click="athlete_profile_next"></span></div></div></div>'),
                    true
                    );
            } else if(!tooltips.leaderboard_next){ //leaderboard
                $('#AthProfileWrap').hide();
                this.appendPopup(
                    $('#mainContainer'),
                    $('#users_rating_wrap'),
                    $('<div class="site_tooltip tl"><div class="l"><div class="tooltip_message leaderboard_card_1"></div></div></div><div class="site_tooltip br"><div class="l"><div class="tooltip_message leaderboard_card_2"></div><div class="tooltip_message leaderboard_card_3"><span class="go_next" data-click="leaderboard_next"></span></div></div></div>'),
                    true
                    );
            } else if(!tooltips.ride_library_btn){ //ride library button
                this.appendPopup(
                    $('#mainContainer'),
                    $('#achOpenBtn'),
                    $('<div class="site_tooltip tl"><div class="l"></div></div><div class="site_tooltip br"><div class="l"><div class="tooltip_message ach_card_2"></div></div></div>'),
                    true
                    );
            } else if(!tooltips.finish_tooltips_btn){ //finish
                this.appendPopup(
                    $('#mainContainer'),
                    $('#dd-help'),
                    $('<div class="site_tooltip tl"><div class="l"></div></div><div class="site_tooltip br"><div class="l"><div class="tooltip_message finish_card"><span class="go_next" data-click="finish_tooltips_btn"></span></div></div></div>')
                    );
            }

            //forget password
        $('body').off('click', '.go_next').on('click', '.go_next', function(event) {

            var data=$(this).attr('data-click');
            that.saveTooltip(data);
            that.checkForPopup();

        });

        },
        appendPopup: function(appender,button,context,border){

            $('body').addClass('faded');

            if(button){ //if button

              if(border){
                button.addClass('border_tooltip_hightlight');
              }

                context.appendTo(appender);

                var contentOffset=appender.offset(),
                    buttonOffset=button.offset(),
                    buttonHeight=button.outerHeight(),
                    buttonWidth=button.outerWidth(),
                    th=buttonOffset.top-contentOffset.top;
                    bt=th+buttonHeight,
                    lth=buttonOffset.left-contentOffset.left-5,
                    lbt=lth+buttonWidth+10;
                
                if(th<0){
                  appender.find('.tl').css({top:th+'px',height: '0'}).addClass('fade');
                } else {
                  appender.find('.tl').css('height',th+'px').addClass('fade');
                }
                
                appender.find('.br').css('top',bt+'px').addClass('fade');
                appender.find('.l').css('height',buttonHeight+'px');
                appender.find('.tl .l').css('width',lth+'px');
                appender.find('.br .l').css('left',lbt+'px');

            }
            

        }
    }
});