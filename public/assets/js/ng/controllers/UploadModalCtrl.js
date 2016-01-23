app.controller('UploadModalCtrl',function($scope, $http, $modalInstance, $modal, stravaLogin, userLevelService, userService, userTooltipService){

    $('.toolt_hide').remove();

    //get tooltip data
    userTooltipService.getTooltip('browse_file__btn')==0?$scope.tooltip_shown_1=false:$scope.tooltip_shown_1=true;
    $scope.tooltip_shown_2=true;

    var spinner = '<div class="spinner"> <div class="rect1"></div> <div class="rect2"></div> <div class="rect3"></div> <div class="rect4"></div> <div class="rect5"></div> </div>';

    $scope.close = function(){
        $modalInstance.close();
    }

    $scope.disabled = { upload:false, title:true, upload:true }

    $scope.level = '';
    $scope.user = {};
    $scope.error = {};
    $scope.file = {};

    $scope.stravaLogin = stravaLogin;

    $scope.tabs = {divice: false, file:   true, strava: false}

    ////click to tab section
    //$scope.setTab = function(type) {
    //    angular.forEach($scope.tabs,function(value, key) {
    //        $scope.tabs[key] = false;
    //    })
    //    $scope.tabs[type] = true;
    //}

    $scope.change = function(){
        $scope.original_title = $scope.title;
        $scope.disabled.title = false;
    }

    $scope.save = function() {
        $scope.disabled.title = true;
    }


    $scope.$watch($scope.files,function(){
        $('#uploadFileInput').fileupload({
            send:function(e, data) {
                $('.btn-upload-processing').prop('disabled',true);
                $('.fileUpload').attr('disabled','disabled');
                $('.btn-upload-processing').html(spinner);
            },
            done: function(e, data){

                $scope.$apply(function() {
                    $scope.file.id      = data.result.id;
                    $scope.file.title   = data.result.title;
                    $scope.file.date    = data.result.date;
                    $scope.file.time    = data.result.time;
                    $('.btn-upload-processing').prop('disabled',false);

                    if(!$scope.tooltip_shown_1){
                        $scope.tooltip_shown_1=true;
                        $scope.tooltip_shown_2=false;
                    }
                    // $('.fileUpload').removeAttr('disabled');

                });

                $('.btn-upload-processing').html('UPLOAD');

            },
            error: function (e, data) {
                var error = jQuery.parseJSON(e.responseText);
                $('.btn-upload-processing').prop('disabled',true);
                alert(error.message);
                $('.btn-upload-processing').html('UPLOAD');
                $('.fileUpload').removeAttr('disabled');

            }
        });
    });



    $scope.formData     = {}; //files
    $scope.stravaData   = {}; //strava activities

    //Processing
    $scope.processing = function(){

        var p = {
            id:     $scope.file.id,
            title:  $scope.file.title,
            date:   $scope.file.date,
            indoor: $scope.file.indoor,
            time:   $scope.file.time
        };

        // return false;
        $scope.disabled.upload = true;
        $('.fileUpload').attr('disabled','disabled');
        $('.btn-upload-processing').html(spinner).attr('disabled','disabled');

        $http.post('/upload/processing', p ).
            success(function(data, status, headers, config){
                $scope.level    = data.user.level;
                $scope.user_progress = data.user.progress;

                $scope.$watch('level', function () {
                    userLevelService.setLevel($scope.level);
                });

                $scope.$watch('progress', function () {
                    userLevelService.setProgressLevel($scope.user_progress);
                });

                $scope.disabled.upload = false;

                $('.btn-upload-processing').prop('disabled',true);
                $('.fileUpload').removeAttr('disabled');

                /*Close current modal*/
                $scope.close();
                /*Open Modal Upload Completed*/
                $scope.openUploadCompleted();
                /*reset file*/
                //$scope.file = {};
            }).
            error(function(data, status, headers, config) {

                $scope.error.message = data.message;
                $scope.disabled.upload = false;
                $('.fileUpload').removeAttr('disabled');

                $('.btn-upload-processing').html('UPLOAD');
            });
        $scope.progress();
    }

    //show progress
    $scope.progress = function(){

        var p = {id:$scope.file.id};

        $http.post('/upload/progress_json/',p).
            success(function(data, status, headers, config){

                if ( $scope.error.message == '' || $scope.error.message === undefined  ) {
                    $(".progress-bar").height(data + '%');
                    if ( data < 100 ) {
                        $scope.progress();
                    } else {
                        $scope.formData = {};
                        //$(".progress-bar").height('0%');
                        $('.btn-upload-processing').html('SUCCESS');
                    }
                }
            }).
            error(function(data, status, headers, config) {

            });
    }


    $scope.openUploadCompleted = function() {
        modalInstance = $modal.open({
            templateUrl: '/public/assets/js/ng/views/modal/upload_completed.html',
            controller: 'UploadCompletedModalCtrl',
            resolve: {
                file: function(){
                    return $scope.file.id
                    // return 1;
                }
            }
        });

        modalInstance.result.then(function () {}, function () {
                  window.location.reload();
                });

    }

    // $scope.openUploadCompleted();






});
