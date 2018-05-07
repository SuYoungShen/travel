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
$route['attractions_place'] = 'travel/attractions_place';
$route['pingtung'] = 'travel/pingtung/';
$route['kaohsiung'] = 'travel/kaohsiung';
$route['kaohsiung/(:any)'] = 'travel/kaohsiung/$1';
$route['tainan'] = 'travel/tainan/';
$route['tainan/(:any)'] = function($place){
  if ($place == "attractions") {
    return "travel/tainan/".$place;
  }else if($place == "food"){
    return "travel/tainan/".$place;
  }
};

//新增 in 20180410
$route['chiayi'] = 'travel/chiayi';//嘉義縣
$route['chiayi/(:any)'] = 'travel/chiayi/$1';//嘉義縣
$route['chiayis'] = 'travel/chiayis';//嘉義市
$route['chiayis/(:any)'] = 'travel/chiayis/$1';//嘉義市
//新增 in 20180410

$route["alltaiwan"] = 'travel/alltaiwan';

$route["privacy"] = 'travel/privacy';//20180402隱私權

$route["send_mail"] = 'travel/send_mail';//20180329

$route["login"] = 'travel/login';//20180330
$route["logout"] = 'travel/logout';//20180330
$route["register"] = 'travel/register';//20180331
$route["forget"] = 'travel/forget';//20180331
$route["memberInfo"] = 'travel/memberInfo';//up memberInfo->memberInfoUp 20180404

$route['details/(:any)/(:any)/(:any)'] = 'travel/details/$1/$2/$3';
$route['AMessage'] = 'travel/AMessage';//20180325

$route['api/third_Fb_Login'] = 'api/third_Fb_Login';//20180402 FB用
$route['Att_and_Am'] = 'api/Att_and_Am';//20180406
$route['delete_Am'] = 'api/delete_Am';//20180406
$route['user_like'] = 'api/user_like';//add like 功能 in 20180407
$route['Att_and_UL'] = 'api/Att_and_UL';//add Att_and_UL 功能 in 20180409
$route['delete_UL'] = 'api/delete_UL';//add delete_UL 功能 in 20180409
$route['delete_place'] = 'api/delete_place';//add delete_place 功能 in 20180430

$route['test'] = 'travel/test';//20180331測試業面

$route['backstage'] = 'backstage/index';//20180416 add 後台
$route['do_place'] = 'backstage/do_place';//編輯、刪除地區用 in 20180506
$route['place'] = 'backstage/place';//20180424 add 地區頁面
$route['attractions'] = 'backstage/attractions';//20180424 add 景點資訊頁面
$route['food'] = 'backstage/food';//20180424 add 美食資訊頁面

$route['food_place'] = 'travel/food_place';

$route['default_controller'] = 'travel/';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
