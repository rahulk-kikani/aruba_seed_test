var seedApp = angular.module('seedApp',[]);

seedApp.controller('oceanController', function($scope, $http, $rootScope){
	console.log(123);
});

seedApp.run(function($rootScope, $location, $http) {

	$rootScope.api_url = "http://localhost/seedtest/api/v1";

	$rootScope.students = [];
	$rootScope.books = [];

	$rootScope.tabs = [
		{
			'id': 'ocean',
			'title': 'Ocean',
			'icon': 'fa-th'
		},
		{
			'id': 'student',
			'title': 'Student',
			'icon': 'fa-laptop'
		},
		{
			'id': 'boat',
			'title': 'Boat',
			'icon': 'fa-dashboard'
		}
		,
		{
			'id': 'book',
			'title': 'Book',
			'icon': 'fa-book'
		}
	];
	$rootScope.active_tab_index = 0;

	//get all the students
	$http({
		method: 'GET',
		url: $rootScope.api_url+'/student/all'
	})
	.success(function(data){
		$rootScope.students = angular.copy(data);
		return data;
	})
	.error(function(data, status){
		alert(data.message);
		return data;
	});

	//get all the books
	$http({
		method: 'GET',
		url: $rootScope.api_url+'/book/all'
	})
	.success(function(data){
		$rootScope.books = angular.copy(data);
		return data;
	})
	.error(function(data, status){
		alert(data.message);
		return data;
	});

	//get all the boat details
	$http({
		method: 'GET',
		url: $rootScope.api_url+'/boat/all'
	})
	.success(function(data){
		$rootScope.boats = angular.copy(data);
		return data;
	})
	.error(function(data, status){
		alert(data.message);
		return data;
	});

	$rootScope.add_boat_to_ocean = function(){
		angular.element('[ng-controller=oceanController]').add_boat_to_ocean();
	};
});

seedApp.controller('oceanController', function($scope, $http, $rootScope){

	$scope.add_boat_to_ocean = function(){
		alert('hi');
	};

});

seedApp.controller('studentController', function($scope, $http, $rootScope){
	var newstudent = {
		first_name: '',
		last_name: '',
		has_skipair: false
	};

	$scope.newstudent = angular.copy(newstudent);

	$scope.save_student = function(){
		$scope.newstudent.has_skipair = $scope.newstudent.has_skipair == true ? 1 : 0;
		$http({
			method: 'POST',
			url: $rootScope.api_url+'/student/profile',
			data: $.param($scope.newstudent),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		})
		.success(function(data){
			$rootScope.students.push(data.data);
			$scope.reset();
			return data;
		})
		.error(function(data, status){
			console.log(data);
			return data;
		});
	};

	$scope.reset = function () {
		$scope.newstudent = angular.copy(newstudent);
	};
});

seedApp.controller('bookController', function($scope, $http, $rootScope){
	var newbook = {
		name: '',
		url_on_amazon: ''
	};

	$scope.newbook = angular.copy(newbook);

	$scope.save_book = function(){
		$http({
			method: 'POST',
			url: $rootScope.api_url+'/book/detail',
			data: $.param($scope.newbook),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		})
		.success(function(data){
			$rootScope.books.push(data.data);
			$scope.reset();
			return data;
		})
		.error(function(data, status){
			console.log(data);
			return data;
		});
	};

	$scope.reset = function () {
		$scope.newbook = angular.copy(newbook);
	};
});

seedApp.controller('boatController', function($scope, $http, $filter, $rootScope){
	$scope.boatColors = [ 'BLUE', 'NAVY_BLUE', 'GREEN', 'RED', 'PURPLE'];

	var newboat = {
		name: '',
		price: '',
		color: $scope.boatColors[0]
	};

	$scope.newboat = angular.copy(newboat);
	$scope.currentBoat = {};

	$scope.updateAvailableBook = function(){
		$scope.filteredBooks = [];
		$scope.filteredBooks = $filter('filter')($rootScope.books, function(value){
			var book_avai = true;
			angular.forEach($scope.boatBooks, function(value2, key2){
				if(value2.id_book == value.id){
					book_avai = false;
				}
			});
			return book_avai;
		});
	};

	$scope.reset = function () {
		$scope.newboat = angular.copy(newboat);
	};

	$scope.get_books_on_boat = function(id_boat){
		$scope.boatBooks = [];
		$scope.currentBoat.id_boat = id_boat;
		$http({
			method: 'GET',
			url: $rootScope.api_url+'/boat/'+id_boat+'/book'
		})
		.success(function(data){
			if(data.status){
				$scope.boatBooks = angular.copy(data.data);
			} else {
				//alert(data.message);
			}
			$scope.updateAvailableBook();
			if($scope.filteredBooks.length > 0)
				$scope.currentBoat.id_book = $scope.filteredBooks[0].id;
			$('#boatBooksModal').modal('show');
			return data;
		})
		.error(function(data, status){
			return data;
		});
	};

	$scope.save_boat = function(){
		$http({
			method: 'POST',
			url: $rootScope.api_url+'/boat/detail',
			data: $.param($scope.newboat),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		})
		.success(function(data){
			$rootScope.boats.push(data.data);
			$scope.reset();
			return data;
		})
		.error(function(data, status){
			console.log(data);
			return data;
		});
	};

	$scope.add_new_book_to_boat = function(){
		var newBook = {
			id_boat: $scope.currentBoat.id_boat,
			id_book: $scope.currentBoat.id_book
		};
		$http({
			method: 'POST',
			url: $rootScope.api_url+'/boat/book',
			data: $.param(newBook),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		})
		.success(function(data){
			$scope.get_books_on_boat($scope.currentBoat.id_boat);
			return data;
		})
		.error(function(data, status){
			return data;
		});
	};
});