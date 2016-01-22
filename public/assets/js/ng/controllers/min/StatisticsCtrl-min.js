//Statistics Home page
app.controller('StatisticsCtrl',function($scope, $http, userService,userTooltipService){


	$scope.statistic = {};

    //get Statistics by Days
    $scope.getStatistics = function(filter,label) {
        $http.post('/statistics',{'filter':filter}).
            success(function(data, status, headers, config) {
               $scope.statistic = data;
               $scope.statistic_label  = label;

               userTooltipService.setTooltips(
                    {
                        player_card_btn:0,
                        choose_card_btn:0,
                        upload_ride_btn:0,
                        browse_file__btn:0,
                        upload_file_btn:0,
                        upload_complete_next:0,
                        activity_feed_next:0,
                        athlete_profile_next:0,
                        leaderboard_next:0,
                        ride_library_btn:0,
                        ride_library_next:0,
                        finish_tooltips_btn:0,
                        exit_achievements_btn:0,
                        exit_objectives_btn:0,
                        exit_gear_btn:0
                    });

               
            }).
            error(function(data, status, headers, config) {

            });
    }

     $scope.getStatistics(30,'LAST 30 DAYS');


});

