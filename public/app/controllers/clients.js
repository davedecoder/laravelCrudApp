
app.controller('clientsController', ['$scope', '$http', 'API_URL', function($scope, $http, API_URL){
	
	$scope.selected_state = {};
	$scope.nationalities = [];	
	$scope.state = "";
  	$scope.format = 'yyyy/MM/dd';
  	$scope.modalState = "";
  	$scope.today = function() {
	    $scope.angularDatePicker = new Date();
    };
    $scope.today();

    $scope.dateOptions = {
	    dateDisabled: disabled,
	    formatYear: 'yy',
	    startingDay: 1
    };

    function disabled(data) {
	    var date = data.date,
	      mode = data.mode;
	    return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }

    $scope.popup1 = {
	    opened: false
	};

	$scope.open1 = function() {
	    $scope.popup1.opened = true;
    };


	//helper
	var myHelpers = {
		dateToFormatedString: function(date){
			var myDate = new Date(date);
			var dd = myDate.getDate();
			var mm = myDate.getMonth() + 1;
			var yyyy = myDate.getFullYear();

			if(dd<10){
			    dd='0'+dd;
			} 
			if(mm<10){
			    mm='0'+mm;
			} 
			var today = yyyy + '-' + mm + '-' + dd;
			return today;	
		},
		stringToDate: function(_date,_format,_delimiter) {
			var formatLowerCase = _format.toLowerCase();
			var formatItems = formatLowerCase.split(_delimiter);
			var dateItems = _date.split(_delimiter);
			var monthIndex = formatItems.indexOf("mm");
			var dayIndex = formatItems.indexOf("dd");
			var yearIndex = formatItems.indexOf("yyyy");
			var month = parseInt(dateItems[monthIndex]);		
			month -= 1;
			var formatedDate = new Date(dateItems[yearIndex], month, dateItems[dayIndex]);
			return formatedDate;
		},
		getStateByEstado: function(title){
			return _.find($scope.mexicanStates, function(entry){
				return entry.estado = title;
			});
		}

	};


	function successClientsRequest(response){
		$scope.clients = response.data.data;
		$scope.clients.forEach( function(element) {
			element.birth = new Date(element.birth);//myHelpers.stringToDate(element.birth, "yyyy-mm-dd", "-");
		});
	}

	function successStatesRequest(response){
		$scope.mexicanStates = response.data.data;		
	}

	function errorClientsRequest(response){

	}

	function errorClientRequest(response){

	}

	//retrieve mexican states
		$http.get(API_URL + "states")
			.then(successStatesRequest, errorClientsRequest);

	$scope.setValues = function(){
		//retrieve clients
		$http.get(API_URL + "clients")
			.then(successClientsRequest, errorClientsRequest);	
	}


	$scope.setValues();

	//show modal form
	$scope.toggle = function(modalState, id){
		$scope.modalState = modalState;

		switch (modalState) {
			case 'add':
				$scope.form_title = "Add New Client";

				break;
			case 'edit':
				$scope.form_title = "Client Detail";
				$scope.id = id;
				$http.get(API_URL + 'clients/' + id)
					.then(function(response){
						
						$scope.client = response.data.data;	
						$scope.angularDatePicker = myHelpers.stringToDate(response.data.data.birth, "yyyy-mm-dd", "-");
						$scope.client.birth = myHelpers.dateToFormatedString($scope.angularDatePicker);	
						$scope.state = $scope.client.birth_state;												

					}, errorClientRequest);
				break;
			default:
				break;
		}

		$('#myModal').modal('show');
	};

	//save new record / update existing record
	$scope.save = function(modalState, id){
		
		var url = API_URL + "clients";

		//append client id to the URL if the form is in edit mode
		if(modalState === 'edit'){

			url += '/' + id;
		}
		$scope.client.birth_state = $scope.state;
		$scope.client.birth = myHelpers.dateToFormatedString($scope.angularDatePicker);	
		
		$http({
			method: 'POST',
			url: url,
			data: $.param($scope.client),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		}).then(function(response){
			$scope.client = {};
			$scope.state = "";
			if ($scope.form) $scope.form.$setPristine();
			$('#myModal').modal('hide');
			$scope.setValues();
		}, function(response){
			alert('This is embarassing. An error has occured. Please check the log for details');
		});
	};

	//delete record
	$scope.confirmDelete = function(id){
		var isConfirmDelete = confirm("Are you sure you want to delete this record");
		if(isConfirmDelete){
			$http({
				method: 'DELETE',
				url: API_URL + 'clients/' + id
			}).then(function(response){
				$scope.setValues();
			}, function(data){
				alert('unable to delete');
			});
		}else{
			return false;
		}
	}


}]);