//Modal ACHIEVEMENTS
app.controller('AchievementsModalCtrl',function($scope, $http,$modalInstance,$timeout,categories,userTooltipService){
  
    $scope.categories = categories;
    //get tooltip data
    userTooltipService.getTooltip('exit_achievements_btn')==0?$scope.tooltip_shown=false:$scope.tooltip_shown=true;

    $scope.close = function(){
        $modalInstance.close();
    }

    $scope.exit_tutorial = function(){
        userTooltipService.saveTooltip('exit_achievements_btn');
        $scope.tooltip_shown=true;
    }

    $scope.getAchievements = function(id){
        $http.get('/achievements/'+id).
            success(function(data, status, headers, config) {
                $scope.achievements = data.achievements;
                $scope.statistic    = data.statistic;
                $scope.Math = window.Math;
            }).
            error(function(data, status, headers, config) {

            });
    }

    $scope.getAchievements(0);

    $scope.getDetailsCategory = function(id)
    {
        $scope.getAchievements(id);
    }

});