<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] 	= 'home';
$route['blocked'] 				= 'auth/blocked';
$route['system_error'] 			= 'auth/system_error';
$route['not_found'] 			= 'auth/not_found';
$route['change_password'] 		= 'auth/change_password';


$route['404_override'] 			= 'auth/not_found';
$route['translate_uri_dashes'] 	= FALSE;

//* HMVC *//
$modules_path = APPPATH . 'modules/';
$modules = scandir($modules_path);
foreach ($modules as $module) {
	if ($module === '.' || $module === '..') continue;
	if (is_dir($modules_path) . '/' . $module) {
		$routes_path = $modules_path . $module . '/config/routes.php';
		if (file_exists($routes_path)) {
			require($routes_path);
		} else {
			continue;
		}
	}
}
