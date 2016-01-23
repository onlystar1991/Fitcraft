//Rankings Home page
app.controller('RankingsCtrl',function($scope, $http, $modal){


    $scope.search                     = {};
    $scope.perride                    = true;  
    $scope.days                       = {};  
    $scope.avg_max_with               = {};  
    $scope.search.days                = 'all';   
    $scope.ranking_days_label         = 'ALL TIME';   
    $scope.search.interval            = 'ride';   
    $scope.ranking_interval_label     = 'PER RIDE';   
    $scope.ranking_age_label          = 'ANY AGE'; 
    $scope.search.age                 = '';  
    $scope.ranking_gender_label       = 'ANY GENDER'; 
    $scope.search.gender              = '';

    $scope.ranking_avg_max_label      = 'AVG'; 
    $scope.search.avg_max             = 'total';

    $scope.ranking_avg_max_with_label = 'TOTAL TIME'; 
    $scope.search.avg_max_with        = 'time';
    // $scope.avg_max_with.speed      = true;
    // $scope.avg_max_with.time       = false;
    // $scope.avg_max_with.power      = true;
    // $scope.avg_max_with.distance   = false;
    // $scope.avg_max_with.cadence    = true;
    // $scope.avg_max_with.heart_rate = true;
    // $scope.avg_max_with.calories   = false;
    // $scope.perride                 = true;
    $scope.avg_max_with.speed      = false;
    $scope.avg_max_with.time       = false;
    $scope.avg_max_with.power      = false;
    $scope.avg_max_with.distance   = false;
    $scope.avg_max_with.cadence    = false;
    $scope.avg_max_with.heart_rate = false;
    $scope.avg_max_with.calories   = false;
    $scope.perride                 = false;



    $scope.ranking_zip_label          = 'EVERYWHERE'; 
    $scope.search.zip                 = ''; 
    $scope.ranking_level_label        = 'ANY LEVEL'; 
    $scope.search.level               = '';
    $scope.ranking_cat_label          = 'ANY CAT'; 
    $scope.search.cat                 = '';   
    $scope.ranking_weight_label       = 'ANY WEIGHT'; 
    $scope.search.weight              = '';  
    $scope.ranking_height_label       = 'ANY HEIGHT'; 
    $scope.search.height              = '';      
    $scope.search.name                = '';      
                
    $scope.selectFilter = function(val,label,field, stype) {

        $scope.search.avg_max=stype;

        if ( field == 'days' ) {
            $scope.ranking_days_label = label;         
            $scope.search.days        = val;         
        }
        if ( field == 'height' ) {
            $scope.ranking_height_label = label;    
            $scope.search.height        = val;      
        }
        if ( field == 'weight' ) {
            $scope.ranking_weight_label = label;    
            $scope.search.weight        = val;      
        }
        if ( field == 'interval' ) {
            $scope.ranking_interval_label = label;    
            $scope.search.interval        = val; 
            
            $scope.ranking_days_label = 'LAST 30 DAYS';
            $scope.search.days        = 30; 
            $scope.days.last1days     = false;
            $scope.days.last7days     = false;
            $scope.days.last30days    = false;
            $scope.days.last60days    = false;
            $scope.days.last90days    = false;
            $scope.days.last120days   = false;
            $scope.days.last180days   = false;
            $scope.days.last360days   = false;
            $scope.days.lastalldays   = false;

            if(val=='ride') {
                $scope.ranking_days_label = 'LAST 30 DAYS';
                $scope.search.days        = 30; 
                $scope.days.last1days     = false;
                $scope.days.last7days     = false;
                $scope.days.last30days    = false;
                $scope.days.last60days    = false;
                $scope.days.last90days    = false;
                $scope.days.last120days   = false;
                $scope.days.last180days   = false;
                $scope.days.last360days   = false;
                $scope.days.lastalldays   = false;
            }              
            if(val=='week') {
                $scope.ranking_days_label = 'LAST 7 DAYS';
                $scope.search.days         = 7; 
                $scope.days.last1days     = true;
                $scope.days.last7days     = false;
                $scope.days.last30days    = true;
                $scope.days.last60days    = true;
                $scope.days.last90days    = true;
                $scope.days.last120days   = true;
                $scope.days.last180days   = true;
                $scope.days.last360days   = true;
                $scope.days.lastalldays   = true;
            } 
            if(val=='month') {
                $scope.ranking_days_label = 'LAST 30 DAYS';
                $scope.search.days        = 30; 
                $scope.days.last1days     = true;
                $scope.days.last7days     = true;
                $scope.days.last30days    = false;
                $scope.days.last60days    = true;
                $scope.days.last90days    = true;
                $scope.days.last120days   = true;
                $scope.days.last180days   = true;
                $scope.days.last360days   = true;
                $scope.days.lastalldays   = true;
            } 
            if(val=='season') {
                $scope.ranking_days_label = 'LAST 60 DAYS';
                $scope.search.days        = 60; 
                $scope.days.last1days     = true;
                $scope.days.last7days     = true;
                $scope.days.last30days    = true;
                $scope.days.last60days    = false;
                $scope.days.last90days    = false;
                $scope.days.last120days   = false;
                $scope.days.last180days   = false;
                $scope.days.last360days   = false;
                $scope.days.lastalldays   = true;
            }            
        }
        if ( field == 'age' ) {
            $scope.ranking_age_label = label;    
            $scope.search.age        = val;      
        }
        if ( field == 'zip' ) {
            $scope.ranking_zip_label = label;    
            $scope.search.zip        = val;      
        }
        if ( field == 'level' ) {
            $scope.ranking_level_label = label;    
            $scope.search.level        = val;      
        }
        if ( field == 'cat' ) {
            $scope.ranking_cat_label = label;    
            $scope.search.cat        = val;      
        }          
        if ( field == 'gender' ) {
            $scope.ranking_gender_label = label;    
            $scope.search.gender        = val;      
        }        
        if ( field == 'avg_max' ) {
            $scope.ranking_avg_max_label = label;    
            $scope.search.avg_max        = val;
            if(val=='avg') {
                $scope.ranking_days_label = 'LAST 30 DAYS';
                $scope.search.days        = 30; 
                $scope.days.last1days     = false;
                $scope.days.last7days     = false;
                $scope.days.last30days    = false;
                $scope.days.last60days    = false;
                $scope.days.last90days    = false;
                $scope.days.last120days   = false;
                $scope.days.last180days   = false;
                $scope.days.last360days   = false;
                $scope.days.lastalldays   = false;
                $scope.perride            = false;
                
                $scope.ranking_avg_max_with_label = 'TIME'; 
                $scope.search.avg_max_with        = 'time';
                $scope.avg_max_with.speed      = false;
                $scope.avg_max_with.time       = false;
                $scope.avg_max_with.power      = false;
                $scope.avg_max_with.distance   = false;
                $scope.avg_max_with.cadence    = false;
                $scope.avg_max_with.heart_rate = false;
                $scope.avg_max_with.calories   = false;

            } else if(val=='total') {                
                $scope.ranking_avg_max_with_label = 'TIME'; 
                $scope.search.avg_max_with        = 'time';
                $scope.avg_max_with.speed      = true;
                $scope.avg_max_with.time       = false;
                $scope.avg_max_with.power      = true;
                $scope.avg_max_with.distance   = false;
                $scope.avg_max_with.cadence    = true;
                $scope.avg_max_with.heart_rate = true;
                $scope.avg_max_with.calories   = false;
                $scope.perride                 = true;
            } else {
                $scope.perride = true;

                $scope.ranking_avg_max_with_label = 'HEART RATE'; 
                $scope.search.avg_max_with        = 'heart_rate';
                $scope.avg_max_with.speed      = false;
                $scope.avg_max_with.time       = false;
                $scope.avg_max_with.power      = false;
                $scope.avg_max_with.distance   = false;
                $scope.avg_max_with.cadence    = false;
                $scope.avg_max_with.heart_rate = false;
                $scope.avg_max_with.calories   = false;
                $scope.perride                 = false;  

            }               
        }
        if ( field == 'avg_max_with' ) {
            $scope.ranking_avg_max_with_label = label;    
            $scope.search.avg_max_with        = val;      
        }
        $scope.getRankings();
    }

	$scope.rankings = {};    
    //get Rankings
    $scope.getRankings = function(){
        $http.post('/rankings',$scope.search).
            success(function(data, status, headers, config) {
                
               $scope.rankings = data;
            }).
            error(function(data, status, headers, config) {

            });
    }
    $scope.getRankings();

    //get getUserPSST
    $scope.user = {};
            // $scope.ranking_days_label = label;         
            // $scope.search.days        = val;    
    $scope.getUserPSST = function(id){
        var p = {id:id,days:$scope.search.days};
        $http.post('/rankings/psst',p).success(function(data, status, headers, config){
              $scope.user[id] = data;  
           // $scope.user[id].power_percent    = data.power_percent;
           // $scope.user[id].speed_percent    = data.speed_percent;
           // $scope.user[id].stamina_percent  = data.stamina_percent;
           // $scope.user[id].tenacity_percent = data.tenacity_percent;
        }).
        error(function(data, status, headers, config) {

        });
    }

    
    $scope.showDetails = function(id) {
        var modalInstance = $modal.open({
            templateUrl: '/public/assets/js/ng/views/modal/athelete_details.html',
            windowTemplateUrl : '/public/assets/js/ng/views/modal/base.html',
            controller: 'RideLibraryModalCtrl',
            size: 'dialog-large',
            resolve: {
                id:function(){
                    return id;
                }
            }
        });
    }    

});

