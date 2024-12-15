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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['signup'] = 'SignupController/index';
$route['signup/submit'] = 'SignupController/submit';
$route['login'] = 'LoginController/index';
$route['login/submit'] = 'LoginController/submit';
$route['logout'] = 'LogoutController/index';  // Maps the logout URL to LogoutController


$route['dashboard'] = 'DashboardController/index';          // Dashboard route
$route['profile'] = 'ProfileController/view';                // Profile page route
$route['profile/edit'] = 'ProfileController/edit';
$route['profile/update'] = 'ProfileController/update';
       // Update Profile route
$route['profile/upload_photo'] = 'ProfileController/upload_photo'; // Photo upload
$route['profile/subscribe'] = 'ProfileController/subscribe'; // Subscription route

 // Handle subscription
// Upload profile photo
$route['photo/upload_file/(:num)'] = 'PhotoUploadController/upload_file/$1';

// $route['photo']='PhotoUploadController/upload_file'

// Interest routes (for sending, accepting, rejecting, blocking)
$route['interest'] = 'interestController/index'; // Load interests page

$route['interests/send'] = 'InterestController/send_interest'; // Send interest
$route['interests/load_incoming_interests'] = 'InterestController/load_incoming_interests';


$route['interests/accept/(:num)'] = 'InterestController/respond_interest/$1/accept'; // Accept interest (by ID)
$route['interests/reject/(:num)'] = 'InterestController/respond_interest/$1/reject'; // Reject interest (by ID)
$route['interests/block/(:num)'] = 'InterestController/respond_interest/$1/block';
$route['interests/respond/(:num)/(:any)'] = 'InterestController/respond_interest/$1/$2'; // Respond to an interest (accept/reject/block)


$route['dashboard'] = 'DashBoardController/index';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
