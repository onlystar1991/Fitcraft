var app = angular.module('appBike', [
                                    'ui.bootstrap',
                                    'perfect_scrollbar',
                                    'wiz.validation',
                                    'ngMask',
                                    'ngDragDrop',
                                    ], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});



//userService;
app.service('userService',function($http){
    var user = {};

    return {
      get: function () {
        return $http.get('/users/current').then(function(result) {

            var spliter=result.data.user.dob.split('/');

            result.data.user.birth_day=spliter[1];
            result.data.user.birth_month=spliter[0];
            result.data.user.birth_year=spliter[2];

              return result.data.user;
        });
      },
      save:function(field, value){
          return $http.post('/users/save', {field:field, value:value} ).
                success(function(data, status, headers, config){
                    return status;
                }).
                error(function(data, status, headers, config){
                   return data;
              });
      },
        setStatistics: function(statistics) {
            //profile.statistics = statistics
        },
        getStatistics: function(filter,label) {
            return $http.post('/statistics',{'filter':filter}).then(function(result) {
                return {
                    data: result.data,
                    label: label
                }
            });
        }
    }
});


app.service('userLevelService',function(){
    var user = {
        level:         '',
        progressLevel: ''
    };
    return {
        getLevel: function(){
            return user.level;
        },
        setLevel: function(level) {
            user.level = level;
        },
        getProgressLevel: function(){
            return user.progressLevel;
        },
        setProgressLevel: function(progress) {
            user.progressLevel = progress;
        }
    }
});




app.controller('LevelCtrl',function($scope, userLevelService){

    $scope.$watch('level',function(){
        userLevelService.setLevel($scope.level);
        $scope.$watch(
            function () {return userLevelService.getLevel(); },
            function (newValue, oldValue) {
                if (newValue !== oldValue) $scope.level = newValue;
                $scope.level = userLevelService.getLevel();
            });


    });

    $scope.$watch('progress',function(){
        userLevelService.setProgressLevel($scope.progress);
        $scope.$watch(
            function () {return userLevelService.getProgressLevel(); },
            function (newValue, oldValue) {
                if (newValue !== oldValue) $scope.progress = newValue;
                $scope.progress = userLevelService.getProgressLevel();
            });

    });

});


app.service('profileService',function() {
    var profile = {
        level: '',
        avatar: '',
        statistics: {}
    }

    return {
        getLevel: function () {
            return profile.level;
        },
        setAvatar: function (avatar) {
            profile.avatar = avatar;
        },
        getAvatar: function () {
            return profile.avatar;
        },
        setStatistics: function(statistics) {
            profile.statistics = statistics
        },
        getStatistics: function() {
            return profile.statistics;
        }

    }
});
app.controller('ProfileCtrl',function($scope, profileService ) {
    $scope.$watch('avatar',function(){
        profileService.setAvatar($scope.avatar);
        $scope.$watch(
            function () {return profileService.getAvatar(); },
            function (newValue, oldValue) {
                if (newValue !== oldValue) $scope.avatar = newValue;
                $scope.avatar = profileService.getAvatar();
            });
    });
});

//test
/*
app.controller('oneCtrl', function($scope, $timeout, $filter) {
    $scope.filterIt = function() {
        return $filter('orderBy')($scope.list2, 'title');
    };

    $scope.list1 = [];
    $scope.list2 = [
        { 'title': 'Item 3', 'drag': true },
        { 'title': 'Item 2', 'drag': true },
        { 'title': 'Item 1', 'drag': true },
        { 'title': 'Item 4', 'drag': true }
    ];

    angular.forEach($scope.list2, function(val, key) {
        $scope.list1.push({});
    });
});*/

app.controller('oneCtrl', function($scope, $timeout, $http) {
    /*
    $http.get('/public/assets/js/ng/dummy/trophy.json').
        then(function(response){
            $scope.list4 = response.data.collection;
            //$scope.list5 = response.data.user;
        })

    $scope.list5 = [{}, {}, {}, {}, {}, {}, {}, {}, {}];
    */
    $scope.list5 = [{}, {}, {}, {}, {}, {}, {}, {}, {}];
    $scope.list1 = [];
    angular.forEach($scope.images, function(val, key) {
        $scope.list1.push({});
    });

    $http.get('/public/assets/js/ng/dummy/trophy.json').
        then(function(response){
            $scope.list2 = response.data.collection;
            //$scope.list5 = response.data.user;
        })
    //$scope.list2 = [
    //    { 'title': 'Item 1', 'drag': true },
    //    { 'title': 'Item 2', 'drag': true },
    //    { 'title': 'Item 3', 'drag': true },
    //    { 'title': 'Item 4', 'drag': true }
    //];

    $scope.startCallback = function(event, ui, title) {
        console.log('You started draggin: ' + title.title);
        $scope.draggedTitle = title.title;
    };

    $scope.stopCallback = function(event, ui) {
        console.log('Why did you stop draggin me?');
    };

    $scope.dragCallback = function(event, ui) {
        console.log('hey, look I`m flying');
    };

    $scope.dropCallback = function(event, ui) {
        console.log('hey, you dumped me :-(' , $scope.draggedTitle);
    };

    $scope.overCallback = function(event, ui) {
        console.log('Look, I`m over you');
    };

    $scope.outCallback = function(event, ui) {
        console.log('I`m not, hehe');
    };
});

app.controller('oneCtrl1', function($scope, $timeout, $http) {

    $http.get('/public/assets/js/ng/dummy/trophy.json').
        then(function(response){
            $scope.list4 = response.data.collection;
            console.log($scope.list4);
            //$scope.list5 = response.data.user;
        })

    $scope.list5 = [
        { "id":101, "name":"Player Card 1", "rating":3, "icon":"icon__33", "source": "ACHIEVEMENT" },
        { "id":102, "name":"Player Card 2", "rating":3, "icon":"icon__32", "source": "ACHIEVEMENT" },
        { "id":103, "name":"Player Card 3", "rating":3, "icon":"icon__34", "source": "ACHIEVEMENT" },
        {},
        {},
        {},
        {},

    ];

});


app.directive('myDatepicker', function () {
    return {
        require : 'ngModel',
        link : function (scope, element, attrs, ngModelCtrl) {
            $(function(){
                element.datepicker({
                    format: 'mm/dd/yyyy'
                }).on('changeDate', function(ev) {
                    ngModelCtrl.$setViewValue(yyyymmdd(new Date(ev.date)));
                    scope.$apply();
                    $(this).datepicker('hide');
                });
            });
        }
    }
});

function yyyymmdd(dateIn) {
    var yyyy = dateIn.getFullYear();
    var mm = dateIn.getMonth()+1; // getMonth() is zero-based
    var dd  = dateIn.getDate();
    return mm +'/'+ dd + '/'+ yyyy;
}


