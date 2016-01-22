app.controller('UploadCompletedModalCtrl',function($scope, $http, $modalInstance, file, userTooltipService){

    $scope.close = function(){
        $modalInstance.close();
        window.location.reload();
    }

    userTooltipService.getTooltip('browse_file__btn')==0?$scope.tooltip_shown=false:$scope.tooltip_shown=true;

    $scope.rideDetails = function(id)
    {

        $http.post('/ride/details', {id:file,feed:true} ).
            success(function(data, status, headers, config){

                data.lap.avg_speed=Math.round(data.lap.avg_speed);
                $scope.ride = data;
            }).
            error(function(data, status, headers, config) {
            });
    }

    $scope.rideDetails(file);

    $scope.exit_tutorial = function(){

            userTooltipService.saveTooltip('upload_ride_btn');
            userTooltipService.saveTooltip('browse_file__btn');
            userTooltipService.saveTooltip('upload_file_btn');
            userTooltipService.saveTooltip('upload_complete_next');
            $scope.tooltip_shown=true;
        
    }

});
