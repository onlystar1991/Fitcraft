//Modal Account
app.controller('ReportModalCtrl',function($scope, $http, userService, $modalInstance, $timeout, items){


  if(items){
    $scope.class_add='report_help_form report_help_form_bug';
    $scope.title='BUG REPORT';
    $scope.label_text='BUG DESCRIPTION';
    $scope.placeholder_text='Enter bug description here.';
  } else {
    $scope.class_add='report_help_form';
    $scope.title='HELP';
    $scope.label_text='HELP REQUEST';
    $scope.placeholder_text='Enter help request here.';
  }

  $('body').addClass('modal-dialog-wide');



  $scope.save = function(){

    var val=$('#feed_text').val();

    if(!val){
      alert('Message can\'t be empty!' );
      $('#feed_text').focus();
      return false;
    }

    var type='help';

    if(items){
      type='bug';      
    }

    $.ajax({
        url: '/help/',
        timeout: 10000,
        type: 'post',
        data: {text:val,type:type},
        success:    function(msg){

            $scope.close();

        },
        error:  function (XMLHttpRequest){

            alert('Server error, try again later.');
            $scope.close();
            
            return false;

        }
        // ajax end
    });

  }





  $scope.close = function(){
    $('body').removeClass('modal-dialog-wide');
    $modalInstance.close();
  }



});