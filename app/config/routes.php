<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

$route['default_controller']    = 'main';
$route['admin'] 				= 'admin/dashboard';
$route['admin'] 				= 'admin/dashboard';
$route['admin/login']			= 'admin/dashboard/login';
$route['admin/logout']			= 'admin/dashboard/logout';
$route['admin/repass']			= 'admin/dashboard/password_recover';
$route['admin/repass/(:any)']   = 'admin/dashboard/password_recover/$1';
$route['404_override'] 			= '';

/* Rotas personalizadas para o site padrão. */
$route['posts'] 				= 'main/posts';
$route['posts/(:any)'] 			= 'main/posts/$1';
$route['post/(:any)'] 			= 'main/post/$1';
$route['eventos']				= 'main/events';
$route['search']				= 'main/search';
$route['albuns'] 				= 'main/albuns';
$route['album/(:any)'] 			= 'main/album/$1';
$route['foto/(:any)'] 			= 'main/foto/$1';
$route['videos'] 				= 'main/videos';
$route['video/(:any)'] 			= 'main/video/$1';
$route['newsletter'] 			= 'main/newsletter';
$route['contato'] 				= 'main/contato';
$route['rss']               	= 'main/rss';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
