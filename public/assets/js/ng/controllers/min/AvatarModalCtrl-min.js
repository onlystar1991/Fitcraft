app.controller('AvatarModalCtrl',function($scope, $http, $modalInstance, listCards, card, profileService) {

    $scope.listCards    = listCards;
    $scope.card         = card;

    $scope.cardDetails = function(id) {

        console.log(listCards[id]);

        if(listCards[id]){
           $scope.selected = listCards[id];
            $scope.card  = '/uploads/icons/'+$scope.selected.path; 
        }
        
    }

    $scope.loadCard = function(){
        //$scope.card  = '/assets/img/cards/'+$scope.selected.path;
        $http.post('cards',{id:$scope.selected.id})
                .success(function(data, status, headers, config) {
                $scope.card_url = $scope.card
                }).
                error(function(data, status, headers, config) {

                });
    }

    $scope.$watch('card_url', function () {
        profileService.setAvatar($scope.card_url);
    });

    $scope.close = function(){
        $modalInstance.close();
    }

});


