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
$route['default_controller'] = 'Auth';
$route['404_override'] = '';

$route['auth/(.+)'] = "Auth/$1";

$route['forgot_password'] = "Auth/forgot_password";
$route['do_login'] = "Auth/do_login";
$route['recover_password/(:any)'] = "Auth/recover_password/$1";
$route['dashboard'] = "Auth/dashboard";
$route['totalbilled'] 				= "Auth/paidorders";
$route['totalbilled/(:any)'] 		= "Auth/paidorders/$1";
$route['totalbilled/(:any)/(:any)'] = "Auth/paidorders/$1/$2";
$route['totalbilled/(:any)/(:any)/(:any)'] = "Auth/paidorders/$1/$2/$3";
$route['totalbilled/(:any)/(:any)/(:any)/(:any)'] = "Auth/paidorders/$1/$2/$3/$4";
$route['totalbilled/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Auth/paidorders/$1/$2/$3/$4/$5";
$route['totalbilled/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)'] = "Auth/paidorders/$1/$2/$3/$4/$5/$6";
$route['agenda_schedule'] 			= "Auth/agenda_schedule";

//added for convert csv button
$route['convertToCsv'] 			= "Auth/convertToCsv";

$route['agenda_schedule/(:any)'] 	= "Auth/agenda_schedule/$1";
$route['agenda_schedule/(:any)/(:any)'] 	= "Auth/agenda_schedule/$1/$2";

$route['admin'] = "Admin";
$route['admin/(.+)'] = "Admin/$1";
$route['profile'] = "Admin/users/profile";
$route['settings'] 					= "Admin/users/update_settings";

$route['app'] = "App";
$route['app/(.+)'] = "App/$1";

$route['register_teachers/(.+)'] = "App/Home/register_teachers/$1";
$route['register_coordinator/(.+)'] = "App/Home/register_coordinator/$1";
$route['report'] 					= "Report";
$route['report/(.+)'] 				= "Report/$1";
#$route['notification'] = "Notification";
#$route['notification/(.+)'] = "Notification/$1";

#$route['api/login/(.+)'] = "Bar/api/Login/$1";
#$route['api/shipment/(.+)'] = "Bar/api/Shipment/$1";

$route['report'] = "Report";
$route['report/(.+)'] = "Report/$1";

$route['translate_uri_dashes'] = FALSE;
