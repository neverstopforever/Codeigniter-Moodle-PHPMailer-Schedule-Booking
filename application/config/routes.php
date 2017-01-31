
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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = 'error404';

//blog start
$route['blog/list'] = 'blog/list_get';
$route['blog/write'] = 'blog/write';
$route['blog/delete/(:num)'] = 'blog/delete/$1';
$route['blog/create'] = 'blog/create';
$route['blog/(:any)'] = 'blog/view/$1';
//blog end

$route['translate_uri_dashes'] = FALSE;
$route['tasks/:num'] = "tasks/specific_task";
$route['dashboard'] = "home/dashboard";
$route['campus/dashboard'] = "campus/home/dashboard";

//leads config
$route['leads-config'] = "leadsConfig";

$route['campus/manage-resource'] = "campus/resource/index";

//campus teacher section
$route['campus/teacher-dashboard'] = "campus/teacherDashboard";
$route['campus/teacher-dashboard/index'] = "campus/teacherDashboard/index";
$route['campus/teacher-dashboard/get_messages'] = "campus/teacherDashboard/get_messages";
$route['campus/teacher-dashboard/get_events'] = "campus/teacherDashboard/get_events";

$route['campus/teacher-resource'] = "campus/teacherResource";
$route['campus/teacher-resource/index'] = "campus/teacherResource/index";
$route['campus/teacher-resource/resources'] = "campus/teacherResource/resources";
$route['campus/teacher-resource/templates'] = "campus/teacherResource/templates";
$route['campus/teacher-resource/groups'] = "campus/teacherResource/groups";

$route['campus/teacher-resource/delete_resource'] = "campus/teacherResource/delete_resource";
$route['campus/teacher-resource/edit_resource'] = "campus/teacherResource/edit_resource";

$route['campus/teacher-resource/add_template'] = "campus/teacherResource/add_template";
$route['campus/teacher-resource/delete_template'] = "campus/teacherResource/delete_template";
$route['campus/teacher-resource/edit_template'] = "campus/teacherResource/edit_template";
$route['campus/teacher-resource/get_template_resource'] = "campus/teacherResource/get_template_resource";
$route['campus/teacher-resource/remove_template_resource'] = "campus/teacherResource/remove_template_resource";
$route['campus/teacher-resource/add_template_resource'] = "campus/teacherResource/add_template_resource";

$route['campus/teacher-resource/add_group'] = "campus/teacherResource/add_group";
$route['campus/teacher-resource/get_group_resource'] = "campus/teacherResource/get_group_resource";
$route['campus/teacher-resource/add_group_resource'] = "campus/teacherResource/add_group_resource";
$route['campus/teacher-resource/remove_group_resource'] = "campus/teacherResource/remove_group_resource";
$route['campus/teacher-resource/import_template'] = "campus/teacherResource/import_template";
$route['campus/teacher-resource/delete_group'] = "campus/teacherResource/delete_group";
$route['campus/teacher-resource/get_comment'] = "campus/teacherResource/get_comment";
$route['campus/teacher-resource/comment'] = "campus/teacherResource/comment";
$route['campus/teacher-resource/save_plan'] = "campus/teacherResource/save_plan";
$route['campus/teacher-resource/edit_group_title'] = "campus/teacherResource/edit_group_title";


//campus students section
$route['campus/student-dashboard'] = "campus/studentDashboard";
$route['campus/student-dashboard/index'] = "campus/studentDashboard/index";
$route['campus/student-dashboard/get_events'] = "campus/studentDashboard/get_events";
$route['campus/student-calendar'] = "campus/studentCalendar";
$route['campus/student-calendar/index'] = "campus/studentCalendar/index";
$route['campus/student-message'] = "campus/studentMessage";
$route['campus/student-message/index'] = "campus/studentMessage/index";
$route['campus/profile-settings'] = "campus/studentDashboard/settings";
$route['campus/profile-settings/index'] = "campus/studentDashboard/settings";
$route['campus/student-document'] = "campus/studentDocument";
$route['campus/student-document/index'] = "campus/studentDocument/index";
$route['campus/student-report'] = "campus/studentReport";
$route['campus/student-report/index'] = "campus/studentReport/index";

$route['campus/student-resource'] = "campus/studentResource";
$route['campus/student-resource/index'] = "campus/studentResource/index";
$route['campus/student-resource/my_courses'] = "campus/studentResource/my_courses";
$route['campus/student-resource/resources'] = "campus/studentResource/resources";
$route['campus/student-resource/resources/(:num)'] = 'campus/studentResource/resources/$1';
$route['campus/student-resource/comment'] = 'campus/studentResource/comment';

//$route['campus/student-resource/delete_resource'] = "campus/studentResource/delete_resource";
//$route['campus/student-resource/edit_resource'] = "campus/studentResource/edit_resource";

$route['campus/student-resource/get_comment'] = "campus/studentResource/get_comment";
$route['campus/student-resource/comment'] = "campus/studentResource/comment";
$route['campus/student-resource/save_plan'] = "campus/studentResource/save_plan";
$route['campus/student-account'] = "campus/studentAccount";
$route['campus/student-account/index'] = "campus/studentAccount/index";

$route['advancedSettings/custom_fields/editField/(:num)'] = "advancedSettings/editField/$1";


//
$route['subscription-plans'] = "user/account";
//api
//$route['api/contactos'] = 'api/contactos';
