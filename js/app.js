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
	$scope.editQuestion = function(id,full_questiontext,option_a,option_b,option_c,option_d,option_e,filename){
	
		$scope.id	  = id;
		
		$scope.full_questiontext = full_questiontext;
		$scope.option_a 	 = option_a;
		
		$scope.option_b 	 = option_b;
		$scope.option_c 	 = option_c;
		$scope.option_d 	 = option_d;
		$scope.option_e 	 = option_e;
		$scope.filename		 = filename
		$scope.operation 	= "Update";
		
		/*reset form*/
		//important you declare your variables before assigning them
		$scope.wholeForm = {
				 full_questiontext: 	undefined,
				 option_a: 	undefined,
				 option_b: 	undefined,
				 option_c: 	undefined,
				 option_d: 	undefined,
				 option_e: 	undefined,
				 filename: 	undefined,
				 operation: 	undefined
				
				 
		}
		
		var questionForm = angular.copy($scope.wholeForm)

		  $scope.clearquestionForm = function() {
		    var formElement = document.getElementById('mform1');
		    var angularElement = angular.element(formElement)
		    angularElement.scope().clearquestionFields();
		    
		  }

		  $scope.clearquestionFields = function() {
		    $scope.wholeForm = angular.copy(questionForm);
		    $scope.questionForm.$setPristine();
		  }
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
	
	
});
