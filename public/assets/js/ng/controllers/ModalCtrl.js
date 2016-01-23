app.controller('ModalCtrl',function($scope, $modal, $http, userTooltipService){

    $scope.upload = function(){
        $('body').append('<div id="popupLoader"><span></span></div>');
        $http.get('/strava/index').then(function(response){
            var modalInstance = $modal.open({
                templateUrl: '/public/assets/js/ng/views/modal/upload.html',
                controller: 'UploadModalCtrl',
                resolve: {
                    stravaLogin: function(){
                        return response.data;
                    }
                }
            });
            modalInstance.opened.then(function() {$('#popupLoader').remove();});
        });
    }

    $scope.account = function() {

      $('body').append('<div id="popupLoader"><span></span></div>');
      var modalInstance = $modal.open({
          templateUrl: '/public/assets/js/ng/views/modal/account.html',
          controller: 'AccountModalCtrl',
            resolve: {
            }
        });
      modalInstance.opened.then(function() {$('#popupLoader').remove();});
    }

    $scope.report = function(bug) {

      $('body').append('<div id="popupLoader"><span></span></div>');
      var modalInstance = $modal.open({
          templateUrl: '/public/assets/js/ng/views/modal/report.html',
          controller: 'ReportModalCtrl',
            resolve: {
                items: function () {
                    return bug;
                  }
            }
        });
      modalInstance.opened.then(function() {$('#popupLoader').remove();});
    }

    $scope.objectives = function() {

      $('body').append('<div id="popupLoader"><span></span></div>');
      var modalInstance = $modal.open({
          templateUrl: '/public/assets/js/ng/views/modal/objectives.html',
          windowTemplateUrl : '/public/assets/js/ng/views/modal/base.html',
          controller: 'ObjectivesModalCtrl',
          size: 'dialog-large',
            resolve: {
            }
        });
      modalInstance.opened.then(function() {$('#popupLoader').remove();});
    }


    $scope.achievements = function() {

        $('body').append('<div id="popupLoader"><span></span></div>');
        $http.get('/achievements/categories').
            then(function(response){
                var modalInstance = $modal.open({
                    templateUrl: '/public/assets/js/ng/views/modal/achievements.html',
                    windowTemplateUrl : '/public/assets/js/ng/views/modal/base.html',
                    controller: 'AchievementsModalCtrl',
                    size: 'dialog-large',
                    resolve: {
                        categories: function(){
                            return response.data
                        }
                    }
                });
                modalInstance.opened.then(function() {$('#popupLoader').remove();});
            });
    }

    $scope.ridelibrary = function() {

      $('body').append('<div id="popupLoader"><span></span></div>');
      var modalInstance = $modal.open({
          templateUrl: '/public/assets/js/ng/views/modal/ridelibrary.html',
          windowTemplateUrl : '/public/assets/js/ng/views/modal/base.html',
          controller: 'RideLibraryModalCtrl',
          size: 'dialog-large modal-dialog-large__ride',
            resolve: {
                id:function(){
                    return 0;
                }
            }
        });
      modalInstance.opened.then(function() {$('#popupLoader').remove();});

      modalInstance.result.then(function () {}, function () {
                  userTooltipService.checkForPopup();
                });
    }



    $scope.avatar = function() {

        $('body').append('<div id="popupLoader"><span></span></div>');
        $http.get('/cards').
            then(function(response){
                var modalInstance = $modal.open({
                    templateUrl: '/public/assets/js/ng/views/modal/avatar.html',
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

                modalInstance.opened.then(function() {$('#popupLoader').remove();});

                modalInstance.result.then(function () {}, function () {
                  userTooltipService.checkForPopup();
                });

                userTooltipService.checkForPopup();

            });


    }



    $scope.trophy = function(){

        $('body').append('<div id="popupLoader"><span></span></div>');
        $http.get('/awards').
            then(function(response){
                var modalInstance = $modal.open({
                    templateUrl: '/public/assets/js/ng/views/modal/trophy_case.html',
                    controller: 'TrophyCaseModalCtrl',
                    resolve: {
                        trophy: function() {
                            return response.data
                        }
                    }
                });

                modalInstance.opened.then(function() {$('#popupLoader').remove();});
            });

    }

});

app.controller('UsersCtrl',function($scope, $modal){

    $scope.showDetails = function(id) {
        
        $('body').append('<div id="popupLoader"><span></span></div>');
        var modalInstance = $modal.open({
            templateUrl: '/public/assets/js/ng/views/modal/athelete_details.html',
            windowTemplateUrl : '/public/assets/js/ng/views/modal/base.html',
            controller: 'AtheleteModalCtrl',
            size: 'dialog-large',
            resolve: {
            }
        });
        modalInstance.opened.then(function() {$('#popupLoader').remove();});
    }
})

app.controller('TrophyCaseModalCtrl',function($scope, $modal, $modalInstance, trophy, userTooltipService){

    userTooltipService.getTooltip('exit_gear_btn')==0?$scope.tooltip_shown=false:$scope.tooltip_shown=true;

    $scope.exit_tutorial = function(){
        userTooltipService.saveTooltip('exit_gear_btn');
        $scope.tooltip_shown=true;
    }


    $scope.dropCallback = function(event, ui) {
        
        var dataArray=[],
            aside_tr_list=$('#aside_awards>div');

        //each in top
        angular.forEach($scope.topTrophies, function(val, key){

            if ( val.id ) { //if exists
                dataArray.push({
                    id: val.id,
                    order: key,
                    top:1
                });
                aside_tr_list.eq(key).find('img').attr('src','/uploads/icons/'+val.icon);
            } else { //if empty
                aside_tr_list.eq(key).find('img').attr('src','assets/img/icon-empty.png');
            }

        });
        //each in fav
        angular.forEach($scope.favoriteTrophies, function(val, key){ 

            if ( val.id ) { //if exists
                dataArray.push({
                    id: val.id,
                    order: key+3,
                    top:1
                });
                aside_tr_list.eq(key+3).find('img').attr('src','/uploads/icons/'+val.icon);
            } else { //if empty
                aside_tr_list.eq(key+3).find('img').attr('src','assets/img/icon-empty.png');
            }

        });

        //each in other
        angular.forEach($scope.collectionTrophies, function(val, key){ 
            if ( val.id ) {
                dataArray.push({
                    id: val.id,
                    order: key+9,
                    top:0
                });
            }
        });
        //save order
        $.ajax({
          type: "PUT",
          url: "/awards",
          data: {order: dataArray}
        });

    };

    $scope.collectionTrophies = trophy.awards;

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

    //set favourites and top
    angular.forEach($scope.collectionTrophies, function(val, key){
        if ( val.top == 1 ) {
            var order=val.order;

            if(order<3){ //if top
                $scope.topTrophies[order]=val;
            } else { //if favs
                $scope.favoriteTrophies[order-3]=val;
            }
            $scope.collectionTrophies[key]={};
        }
    });

    $scope.detailsTrophies = function(id){

        //find in regular
        angular.forEach($scope.collectionTrophies, function(val, key){
            if ( val.id == id ) {
                $scope.selected = val;
                return true;
            }
        });

        //find in top
        angular.forEach($scope.topTrophies, function(val, key){
            if ( val.id == id ) {
                $scope.selected = val;
                return true;
            }
        });

        //find in favs
        angular.forEach($scope.favoriteTrophies, function(val, key){
            if ( val.id == id ) {
                $scope.selected = val;
                return true;
            }
        });

    }


    if(!$scope.tooltip_shown){
        $scope.selected = $scope.collectionTrophies[0];
    }


    $scope.cardDetails = function(id) {
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


  }

  $scope.close = function(){
      $modalInstance.close();
  }



});







