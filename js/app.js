var app = angular.module('myApp',[]);

app.controller('aikenctrl',function($scope, $http, $window){
	$scope.operation = "Insert";
        $scope.id ='';
	
	<!---insert question method --->
	$scope.insertdata = function(){
		$http.post("insert_question.php",	   		
		{'full_questiontext':$scope.full_questiontext,'option_a':$scope.option_a,'option_b':$scope.option_b,'option_c':$scope.option_c,
		'option_d':$scope.option_d,'option_e':$scope.option_e,'correct_answer':$scope.correct_answer,'operation':$scope.operation,'id': $scope.id,'filename':$scope.filename})
	.success(function(data,status,headers,config){
		console.log("Question added successfully");
		$scope.successMessage = "Question Added Successfully!";
		$scope.displayQuestion($scope.filename);
		/*clear form*/
		$scope.reset();
	});
	
	}
	<!---display question method --->
	$scope.displayQuestion = function(fileid){
		$http.get("get_questions.php",{params: {fileid: fileid}})
		.success(function(data){
			
			$scope.data = data
		})
	}
	
	<!---delete question method --->
	$scope.deleteQuestion = function(id,fileid){
		$http.post("delete_questions.php",{"id":id,"fileid":fileid})
		.success(function(){
			
			$scope.successMessage = "Question deleted Successfully!";
			$scope.displayQuestion(fileid);
		})
	}
	
	<!---edit question method --->
	$scope.editQuestion = function(id,full_questiontext,option_a,option_b,option_c,option_d,option_e,correct_answer,filename){
	
		$scope.id	  = id;
		
		$scope.full_questiontext = full_questiontext;
		$scope.option_a 	 = option_a;
		$scope.option_b 	 = option_b;
		$scope.option_c 	 = option_c;
		$scope.option_d 	 = option_d;
		$scope.option_e 	 = option_e;
		$scope.filename		 = filename;
		$scope.correct_answer = correct_answer;
		$scope.operation 	= "Update";

		/*display question*/
		$scope.displayQuestion(filename);
	
		
		
			
	
	}
	<!---on change view method --->
	$scope.change = function(viewfileid) {
       		//console.log($scope.viewfileid);
       	
       		$http.get("get_questions.php",{params: {fileid: $scope.viewfileid}})
		.success(function(data){
			
			$scope.data = data
		})
       		
      };
	  
	  <!---reset form--->
	  $scope.master ='';
	  $scope.reset = function() {
	  
        $scope.full_questiontext = angular.copy($scope.master);
		$scope.option_a = angular.copy($scope.master);
		$scope.option_b = angular.copy($scope.master);
		$scope.option_c = angular.copy($scope.master);
		$scope.option_d = angular.copy($scope.master);
		$scope.option_e = angular.copy($scope.master);
		$scope.filename = angular.copy($scope.master);
		$scope.correct_answer = angular.copy($scope.master);
		$scope.operation = angular.copy($scope.master);
      }
	  
	
	
});
