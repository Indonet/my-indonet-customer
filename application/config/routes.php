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
$route['default_controller'] = 'auth';
$route['login'] = 'auth';
$route['submit-login'] = 'auth/check_login'; 
$route['redirect'] = 'welcome';
$route['generated_data'] = 'welcome/generated_data'; 
$route['check_generated_data'] = 'welcome/check_generated_data';
$route['account'] = 'dashboard/account';
$route['products-info'] = 'dashboard/product_info';
$route['transactions-info'] = 'dashboard/transaction_info'; 
$route['get_acc_list'] = 'dashboard/get_acc_list'; 
$route['change_login'] = 'dashboard/change_login';
$route['check_payment_inv'] = 'dashboard/check_payment_inv';
$route['create_inv_blesta'] = 'dashboard/create_inv_blesta'; 
$route['check_payment_blesta'] = 'dashboard/check_payment_blesta'; 
$route['check_current_pass'] = 'dashboard/check_current_pass';  
$route['billing-statement'] = 'dashboard/billing_statement';
$route['report'] = 'dashboard/report';
$route['payment_info'] = 'dashboard/payment_info';
$route['get-inv-view'] = 'dashboard/get_inv_view';
$route['new-password/(:any)'] = 'auth/register_new_password/$1';
$route['new-register'] = 'auth/register_new_user';
$route['usage-alibaba'] = 'dashboard/billing_usage_alicloud';
$route['get-list-usage-alibaba'] = 'dashboard/get_data_billing_usage_alicloud';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
