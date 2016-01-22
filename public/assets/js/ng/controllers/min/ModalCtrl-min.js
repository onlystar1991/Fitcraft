app.controller('ModalCtrl',function($scope, $modal, $http){

    $scope.upload = function(){
        $http.get('/strava/index').then(function(response){
            var modalInstance = $modal.open({
                templateUrl: '/assets/js/ng/views/modal/upload.html',
                controller: 'UploadModalCtrl',
                resolve: {
                    stravaLogin: function(){
                        return response.data;
                    }
                }
            });
        });
    }

    $scope.account = function() {
      var modalInstance = $modal.open({
          templateUrl: '/assets/js/ng/views/modal/account.html',
          controller: 'AccountModalCtrl',
            resolve: {
            }
        });
    }

    $scope.report = function(bug) {

      var modalInstance = $modal.open({
          templateUrl: '/assets/js/ng/views/modal/report.html',
          controller: 'ReportModalCtrl',
            resolve: {
                items: function () {
                    return bug;
                  }
            }
        });
    }

    $scope.objectives = function() {
      var modalInstance = $modal.open({
          templateUrl: '/assets/js/ng/views/modal/objectives.html',
          windowTemplateUrl : '/assets/js/ng/views/modal/base.html',
          controller: 'ObjectivesModalCtrl',
          size: 'dialog-large',
            resolve: {
            }
        });
    }


    $scope.achievements = function() {
        $http.get('/achievements/categories').
            then(function(response){
                var modalInstance = $modal.open({
                    templateUrl: '/assets/js/ng/views/modal/achievements.html',
                    windowTemplateUrl : '/assets/js/ng/views/modal/base.html',
                    controller: 'AchievementsModalCtrl',
                    size: 'dialog-large',
                    resolve: {
                        categories: function(){
                            return response.data
                        }
                    }
                });
            });
    }

    $scope.ridelibrary = function() {
      var modalInstance = $modal.open({
          templateUrl: '/assets/js/ng/views/modal/ridelibrary.html',
          windowTemplateUrl : '/assets/js/ng/views/modal/base.html',
          controller: 'RideLibraryModalCtrl',
          size: 'dialog-large modal-dialog-large__ride',
            resolve: {
                id:function(){
                    return 0;
                }
            }
        });
    }



    $scope.avatar = function() {

        $http.get('/cards').
            then(function(response){
                var modalInstance = $modal.open({
                    templateUrl: '/assets/js/ng/views/modal/avatar.html',
                    controller: 'AvatarModalCtrl',
                    resolve: {
                        listCards: function() {
                            return response.data.cards;
                        },
                        card: function() {
                            return response.data.card;
                        }
                    }
                });

            });


    }



    $scope.trophy = function(){
        $http.get('/awards').
            then(function(response){

                var modalInstance = $modal.open({
                    templateUrl: '/assets/js/ng/views/modal/trophy_case.html',
                    controller: 'TrophyCaseModalCtrl',
                    resolve: {
                        trophy: function() {
                            return response.data
                        }
                    }
                });
            });

    }

});

app.controller('UsersCtrl',function($scope, $modal){
    $scope.showDetails = function(id) {
        var modalInstance = $modal.open({
            templateUrl: '/assets/js/ng/views/modal/athelete_details.html',
            windowTemplateUrl : '/assets/js/ng/views/modal/base.html',
            controller: 'AtheleteModalCtrl',
            size: 'dialog-large',
            resolve: {
            }
        });
    }
})

app.controller('TrophyCaseModalCtrl',function($scope, $modal, $modalInstance, trophy){


    $scope.startCallback = function(event, ui, title) {
        console.log('You started draggin: ' + title.title);
        $scope.draggedTitle = title.title;
    };

    $scope.dropCallback = function(event, ui) {
        console.log('hey, you dumped me :-(');
    };

    $scope.outCallback = function(event, ui) {
        console.log('I`m not, hehe');
    };

    $scope.collectionTrophies = trophy.awards;
    // console.log($scope.collectionTrophies);
    $scope.favoriteTrophies = [
        {},
        {},
        {},
        {},
        {},
        {},
    ]
    $scope.topTrophies = [
        {},
        {},
        {},
    ]

    $scope.detailsTrophies = function(id){

        angular.forEach($scope.collectionTrophies, function(val, key){
            if ( val.id == id ) {
                $scope.selected = val;
                return true;
            }
        });

    }





    $scope.cardDetails = function(id) {
        console.log(listCards[id]);
        $scope.selected = listCards[id];
    }
    $scope.close = function(){
        $modalInstance.close();
    }

})
app.controller('AtheleteModalCtrl',function($scope, $http, userService, $modalInstance){

  $scope.disabled = {
      nickname: true
  }

  userService.get().then(function(data) {
      $scope.user = data;
  });


  $scope.change = function(field){
    $scope.disabled[field] = false;
  }

  $scope.save = function(field){

    if ( field == 'nickname' ) {
      userService.save('nickname',$scope.user[field]);
    }

    $scope.disabled[field] = true;


    console.log($scope.user);
  }

  $scope.close = function(){
      $modalInstance.close();
  }



});









