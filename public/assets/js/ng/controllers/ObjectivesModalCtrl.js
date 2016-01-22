//Modal Objectives
app.controller('ObjectivesModalCtrl',function($scope, $http,$modalInstance,$timeout, userTooltipService){
  
  userTooltipService.getTooltip('exit_objectives_btn')==0?$scope.tooltip_shown=false:$scope.tooltip_shown=true;

  $scope.close = function(){
    $modalInstance.close();
  }

  $scope.exit_tutorial = function(){
	    userTooltipService.saveTooltip('exit_objectives_btn');
	    $scope.tooltip_shown=true;
	}


});