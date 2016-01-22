//Statistics Home page
app.controller('StatisticsCtrl',function($scope, $http, userService){


	$scope.statistic = {};

    //get Statistics by Days
    $scope.getStatistics = function(filter,label) {
        $http.post('/statistics',{'filter':filter}).
            success(function(data, status, headers, config) {
               $scope.statistic = data;
               $scope.statistic_label  = label;
            }).
            error(function(data, status, headers, config) {

            });
    }

     $scope.getStatistics(30,'LAST 30 DAYS');


});