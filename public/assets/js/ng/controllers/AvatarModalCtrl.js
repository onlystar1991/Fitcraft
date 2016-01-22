app.controller('AvatarModalCtrl',function($scope, $http, $modalInstance, listCards, card, profileService, userTooltipService) {

    $scope.listCards    = listCards;
    $scope.card         = card;
    //get tooltip data
    userTooltipService.getTooltip('choose_card_btn')==0?$scope.tooltip_shown=false:$scope.tooltip_shown=true;

    var resultItem = $.grep(listCards, function(e){ return e.id == $scope.card; });

    $scope.selected = resultItem[0];
    if($scope.selected){
        $scope.card  = '/uploads/icons/'+$scope.selected.path; 
    }
    

    $scope.cardDetails = function(id) {

        $scope.selected = listCards[id];
        if(listCards[id].available==0){
           $scope.card  = '/uploads/icons/'+$scope.selected.path_grey; 
        } else {
           $scope.card  = '/uploads/icons/'+$scope.selected.path; 
        }
        
    }

    $scope.loadCard = function(){
        //$scope.card  = '/assets/img/cards/'+$scope.selected.path;
        $http.post('cards',{id:$scope.selected.id})
                .success(function(data, status, headers, config) {
                $scope.card_url_ic = $scope.selected.icon;
                $scope.card_url = $scope.card;
                }).
                error(function(data, status, headers, config) {

                });
    }

    $scope.$watch('card_url', function () {
        profileService.setAvatar($scope.card_url,$scope.card_url_ic);
    });

    $scope.close = function(){
        $modalInstance.close();
        userTooltipService.checkForPopup();
    }

    $scope.exit_tutorial = function(){

        if(userTooltipService.getTooltip('choose_card_btn')==0){
            userTooltipService.saveTooltip('player_card_btn');
            userTooltipService.saveTooltip('choose_card_btn');
            $scope.tooltip_shown=true;
        }
        
    }

});
