<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//Student
$route['api/v(:num)/student/profile/(:num)'] = 'api/v$1/student/profile/id/$2';
$route['api/v(:num)/student/all'] = 'api/v$1/student/all';
$route['api/v(:num)/student/profile/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/student/profile/id/$2/format/$3$4';

//Book
$route['api/v(:num)/book/(:num)'] = 'api/v$1/book/detail/id/$2';
$route['api/v(:num)/book/all'] = 'api/v$1/book/all';
$route['api/v(:num)/book/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/book/detail/id/$2/format/$3$4';

//Boats
$route['api/v(:num)/boat/detail/(:num)'] = 'api/v$1/boat/detail/id/$2';
$route['api/v(:num)/boat/all'] = 'api/v$1/boat/all';
$route['api/v(:num)/boat/allocean'] = 'api/v$1/boat/ocean_boat';
$route['api/v(:num)/boat/detail/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/boat/detail/id/$2/format/$3$4';

$route['api/v(:num)/boat/book'] = 'api/v$1/boat/book';
$route['api/v(:num)/boat/(:num)/book'] = 'api/v$1/boat/book/id/$2';
$route['api/v(:num)/boat/(:num)/book/(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/boat/book/id/$2/format/$3$4';

$route['api/v(:num)/boat/add/student'] = 'api/v$1/boat/student_on_boat';
$route['api/v(:num)/boat/add/student/(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/boat/student_on_boat/format/$4$5';

$route['api/v(:num)/boat/(:num)/student/(:num)'] = 'api/v$1/boat/student_on_boat/id_boat/$2/id_student/$3';
$route['api/v(:num)/boat/(:num)/student/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/boat/student_on_boat/id/$2$3/format/$4$5';

$route['api/v(:num)/boat/student/(:num)'] = 'api/v$1/boat/student/id/$2';
$route['api/v(:num)/boat/student/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/boat/student/id/$2/format/$3$4';

$route['api/v(:num)/boat/skipair/(:num)'] = 'api/v$1/boat/skipair/id/$2';
$route['api/v(:num)/boat/skipair/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/boat/skipair/id/$2/format/$3$4';

$route['api/v(:num)/example/users/(:num)'] = 'api/v$1/example/users/id/$2'; // Example 4
$route['api/v(:num)/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/v$1/example/users/id/$2/format/$3$4'; // Example 8