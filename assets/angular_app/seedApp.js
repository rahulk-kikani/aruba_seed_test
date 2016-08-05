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
			'icon': 'fa-ship'
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
	$rootScope.load_students = function(){
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
	};

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
	$rootScope.load_boats = function(){
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
	};

	//get all ocean boat details
	$rootScope.load_oceanBoats = function(){
		$http({
			method: 'GET',
			url: $rootScope.api_url+'/boat/allocean'
		})
		.success(function(data){
			$rootScope.oceanBoats = angular.copy(data);
			return data;
		})
		.error(function(data, status){
			alert(data.message);
			return data;
		});
	};

	$rootScope.load_boats();
	$rootScope.load_students();
	$rootScope.load_oceanBoats();

	$rootScope.$on('update-student-details', function(event, args) {
		$rootScope.load_students();
	});

	$rootScope.$on('update-ocean-boat-details', function(event, args) {
		$rootScope.load_oceanBoats();
	});

});

seedApp.controller('oceanController', function($scope, $http, $filter, $rootScope){

	$scope.pre_relocate_student = function($id_student, $index){
		$scope.relocateStudent = {
			id_boat: '',
			id_student: $id_student
		};
		$scope.currentOceanBoat = angular.copy($scope.oceanBoats[$index]);
		$scope.filteredBoats = [];
		$filter('filter')($rootScope.oceanBoats, function(item){
			if(item.id == $scope.currentOceanBoat.id){
				return false;
			} else {
				$scope.filteredBoats.push({id:item.id, name:item.name});
				return true;
			}
		});
		if($scope.filteredBoats.length > 0)
			$scope.relocateStudent.id_boat = $scope.filteredBoats[0].id;

		$('#relocateStudentModal').modal('show');
	};

	$scope.edit_student = function($student_index, $index){
		$scope.currentBoat_index = $index;
		$scope.currentStudent_index = $student_index;
		$scope.currentStudent = angular.copy($rootScope.oceanBoats[$index].students[$student_index]);
		var newstudent = {
			first_name: $scope.currentStudent.first_name,
			last_name: $scope.currentStudent.last_name,
			id: $scope.currentStudent.id_student
		};
		$('#editStudentModal').modal('show');
		$scope.currentStudent = angular.copy(newstudent);
	};

	$scope.update_student = function(){
		$http({
			method: 'POST',
			url: $rootScope.api_url+'/student/profile',
			data: $.param($scope.currentStudent),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		})
		.success(function(data){
			$rootScope.oceanBoats[$scope.currentBoat_index].students[$scope.currentStudent_index].first_name = data.data.first_name;
			$rootScope.oceanBoats[$scope.currentBoat_index].students[$scope.currentStudent_index].last_name = data.data.last_name;
			$('#editStudentModal').modal('hide');
			$rootScope.$broadcast('update-student-details');
			$scope.reset();
			return data;
		})
		.error(function(data, status){
			console.log(data);
			return data;
		});
	};

	$scope.pre_add_student = function($index){
		$scope.addStudent = {
			id_boat: $index,
			id_student: ''
		};
		$scope.assignedStudent = [];
		angular.forEach($scope.oceanBoats, function(value, key){
			angular.forEach(value.students, function(value2, key2){
				$scope.assignedStudent.push(value2);
			});
		});

		$scope.filteredStudents = [];
		$scope.filteredStudents = $filter('filter')($rootScope.students, function(value){
			var student_avai = true;
			angular.forEach($scope.assignedStudent, function(value2, key2){
				if(value2.id_student == value.id){
					student_avai = false;
				}
			});
			return student_avai;
		});
		if($scope.filteredStudents.length > 0)
			$scope.addStudent.id_student = $scope.filteredStudents[0].id;

		$('#addStudentModal').modal('show');
	};

	$scope.add_student_to_board = function(){
		$http({
			method: 'POST',
			url: $rootScope.api_url+'/boat/add/student',
			data: $.param($scope.addStudent),
			headers: {'Content-Type' : 'application/x-www-form-urlencoded'}
		})
		.success(function(data){
			$('#addStudentModal').modal('hide');
			if(data.status){
				$rootScope.$broadcast('update-ocean-boat-details');	
			} else {
				alert(data.message);
			}
			$scope.reset();
			return 1;
		})
		.error(function(data, status){
			console.log(data);
			return 1;
		});
	};

	$scope.remove_student = function(id_student, id_boat){
		$http({
			method: 'DELETE',
			url: $rootScope.api_url+'/boat/'+id_boat+'/student/'+id_student
		})
		.success(function(data){
			$rootScope.$broadcast('update-ocean-boat-details');
			return 1;
		})
		.error(function(data, status){
			return 1;
		});
	};

	$scope.reset = function(){
		$scope.currentStudent = {};
		$scope.currentBoat = {};
		$scope.currentBoat_index = '';
		$scope.currentStudent_index = '';
		$scope.addStudent = {};
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
			$rootScope.$broadcast('update-ocean-boat-details');
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