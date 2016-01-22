//Modal Account
app.controller('AccountModalCtrl',function($scope, $http, userService, $modalInstance,$timeout){

  $scope.disabled = {
    name:             true,
    email:            true,
    athelete_name:    true,
    username:         true,
    nickname:         true,
    password:         true,
    dob:              true,
    zip:              true,
    height:           true,
    weight:           true,
    heart_rate:       true,
    power:            true,
    gender:           true
  }


  $scope.imperial = {
      height_1: 'FT',
      height_2: 'INCH',
      weight:   'LBS'
  }

  $scope.metric = {
      height_1: 'M',
      height_2: 'CM',
      weight:   'KG'
  }

    $scope.units = {
        height_1 :  $scope.imperial.height_1,
        height_2 :  $scope.imperial.height_2,
        weight:     $scope.imperial.weight
    }

  $scope.showImperial = false;

    $scope.error = {
        email:      false,
        password:   false
    }

  // $scope.user = userDetailsService.get();
  userService.get().then(function(data) {
      $scope.user = data;
      // if ( $scope.user.units == 'imperial' ) {
      //     $scope.showImperial = true;
      // } else {
      //     $scope.showImperial = false;
      // }
      $scope.showImperial = true;
      $scope.setUnits();
  });



  $scope.change = function(field){
    $scope.disabled[field] = false;
  }

  $scope.save = function(field){

    if ( field == 'nickname' ) {     
      $('.profile__name--main').html($scope.user[field]);
    }

    if ( field == 'dob' ) { //if birth date  
      $('.profile__name--main').html($scope.user[field]);
    }

    if ( field == 'password' ) {
      
      if ( $scope.user.password != $scope.user.confirm_password) {
            // alert('p='+$scope.user.password+'conf='+$scope.user.confirm_password);

            console.log($scope.user);
            
            $scope.error[field] = 'The Password does not match.';
            return;
      } else if ( typeof $scope.user.password != "undefined" && $scope.user.password.length < 8 ) {
          $scope.error[field] = 'The Password must be at least 8 characters.';
          return;
      } else if (typeof $scope.user.password != "undefined" && $scope.user.password.indexOf(' ') >= 0) {
          $scope.error[field] = 'The Password contain white spaces.';
          return;
      } else if (typeof $scope.user.password == "undefined") {
          $scope.error[field] = 'The Password is empty.';
          return;
      } 
     

    }

    if (field == 'height') {
        $scope.unitsShow(true);

        if ( $scope.showImperial == true ) {
            $scope.showImperial = false;
        }else {
            $scope.showImperial = true;
        }

        $scope.setUnits();

        userService.save('height_ft', $scope.user.height_ft);
        userService.save('height_inc', $scope.user.height_inc);
        userService.save('height_m', $scope.user.height_m);
        userService.save('height_cm', $scope.user.height_cm);
        userService.save('units',$scope.showImperial);
        $scope.disabled[field]  = true;

        return false;
    }
      if (field == 'weight') {
          $scope.unitsShow(true);

          if ( $scope.showImperial == true ) {
              $scope.showImperial = false;
          }else {
              $scope.showImperial = true;
          }

          $scope.setUnits();

        userService.save('weight', $scope.user.weight);
        userService.save('weight_kg', $scope.user.weight_kg);
        userService.save('units',$scope.showImperial);
        $scope.disabled[field]  = true;
        return false;
    }
      
      
    userService.save(field, $scope.user[field]).then(function(response){
        if (response.status == 200) {
            $scope.disabled[field]  = true;
            $scope.error[field]     = false;
        } else {

        }
    },function(response){
        $scope.error[field] = response.data.message;
    });




  }

  $scope.setUnits = function() {
      if ( $scope.showImperial == true ) {
          $scope.units = {
              height_1 :  $scope.imperial.height_1,
              height_2 :  $scope.imperial.height_2,
              weight:     $scope.imperial.weight
          }
      }  else {
          $scope.units = {
              height_1 :  $scope.metric.height_1,
              height_2 :  $scope.metric.height_2,
              weight:     $scope.metric.weight
          }
      }
  }

  $scope.unitsShow = function(revert){

      $scope.user.weight    = parseInt($scope.user.weight);
      $scope.user.weight_kg = parseInt($scope.user.weight_kg);

    if ( revert == true ) {
        $scope.showImperial = $scope.showImperial == true ? false: true;
    }
    if ( $scope.showImperial == true ) {
        $scope.units = {
            height_1 :  $scope.imperial.height_1,
            height_2 :  $scope.imperial.height_2,
            weight:     $scope.imperial.weight
        }

        $scope.user.weight_kg_frac = $scope.user.weight_kg_frac ? $scope.user.weight_kg_frac : 0
        $scope.user.weight = ($scope.user.weight_kg + $scope.user.weight_kg_frac ) * 2.20462262185  ;
        console.log($scope.user.weight);
        $scope.user.weight_frac = frac($scope.user.weight);
        $scope.user.weight = parseInt($scope.user.weight);

       
        var cm  = parseInt($scope.user.height_m) * 100 + parseInt($scope.user.height_cm);
        console.log(cm);
        var inc = Math.round(cm *  0.393700787);
        var ft =  float2int(inc / 12);
        var inc= Math.round(frac(inc / 12) * 12);

        $scope.user.height_ft   = ft;
        $scope.user.height_inc  = inc;

         console.log('ft='+$scope.user.height_ft);

    }  else {
        $scope.units = {
            height_1 :  $scope.metric.height_1,
            height_2 :  $scope.metric.height_2,
            weight:     $scope.metric.weight
        }

        //$scope.user.user.height_ft =

        var cm = Math.round(($scope.user.height_ft * 12 / 0.393700787) + ($scope.user.height_inc / 0.393700787) );

        var m = parseInt(cm / 100);
        var cm = cm - ( m * 100 )

        $scope.user.height_m = m;
        $scope.user.height_cm = cm;

        $scope.user.weight_frac = $scope.user.weight_frac ? $scope.user.weight_frac : 0
        $scope.user.weight_kg      = ($scope.user.weight +$scope.user.weight_frac) * 0.45359237  ;
        $scope.user.weight_kg_frac = frac($scope.user.weight_kg);
        
        console.log('m='+$scope.user.height_m);

        $scope.user.weight_kg = parseInt($scope.user.weight_kg);
    }
  }


  $scope.close = function(){
    $modalInstance.close();
  }

    function float2int (value)
    {
        return value | 0;
    }

    function frac(f)
    {
        return f % 1;
    }


});

