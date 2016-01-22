app.controller('UploadCompletedModalCtrl',function($scope, $http, $modalInstance, file){

    console.log(file);
    $scope.close = function(){
        $modalInstance.close();
        window.location.reload();
    }

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

});


