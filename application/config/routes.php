<?php

defined('BASEPATH') or exit('No direct script access allowed');

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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'dashboard';
$route['translate_uri_dashes'] = true;
$route['404_override'] = 'not_found';
$route['type'] = 'services/type';
$route['top-services'] = 'services/top-services';
$route['services/ongoing'] = 'user_services/ongoing';
$route['services/onhold'] = 'user_services/onhold';
$route['services/completed'] = 'user_services/completed';
$route['upload'] = 'document';
$route['pages'] = 'setting/pages';

$route['form-builder-form'] = 'form-builder/form-builder';
$route['form-data/data-view/(:any)'] = 'form-builder/data_view/$1';
$route['form-data/pdf/(:any)'] = 'form-builder/pdf/$1';

$route['calendar'] = 'calendar/eventdata';
$route['calendar/view/(:any)'] = 'calendar/eventdata/$1';
$route['service-users'] = 'subadmin/service_users';
$route['service-users/(:any)'] = 'subadmin/service_users/$1';
$route['payment'] = 'auth/payment';
$route['user-payment'] = 'payment';
$route['payment_handler'] = 'auth/payment_handler';
$route['payment_cancel'] = 'auth/payment_cancel';