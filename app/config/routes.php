<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

$route['default_controller'] 	= "site/main";
$route['admin'] 				= "admin/dashboard";
$route['404_override'] 			= '';

/* Rotas personalizadas para o site padrão. */
$route['posts'] 				= 'site/main/posts';
$route['posts/(:any)'] 			= 'site/main/posts/$1';
$route['post/(:any)'] 			= 'site/main/post/$1';
$route['search']				= 'site/main/search';
$route['videos'] 				= 'site/main/videos';
$route['video/(:any)'] 			= 'site/main/video/$1';
$route['newsletter'] 			= 'site/main/newsletter';
$route['contato'] 				= 'site/main/contato';

/* End of file routes.php */
/* Location: ./application/config/routes.php */