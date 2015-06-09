<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

$route['default_controller']            = 'site/main';
$route['admin'] 			= 'admin/dashboard';
$route['admin'] 			= 'admin/dashboard';
$route['admin/login']			= 'admin/dashboard/login';
$route['admin/logout']			= 'admin/dashboard/logout';
$route['admin/repass']			= 'admin/dashboard/password_recover';
$route['admin/repass/(:any)']           = 'admin/dashboard/password_recover/$1';
$route['404_override'] 			= '';

/* Rotas personalizadas para o site padrão. */
$route['posts'] 			= 'site/main/posts';
$route['posts/(:any)'] 			= 'site/main/posts/$1';
$route['post/(:any)'] 			= 'site/main/post/$1';
$route['eventos']			= 'site/main/eventos';
$route['search']			= 'site/main/search';
$route['albuns'] 			= 'site/main/albuns';
$route['album/(:any)'] 			= 'site/main/album/$1';
$route['foto/(:any)'] 			= 'site/main/foto/$1';
$route['videos'] 			= 'site/main/videos';
$route['video/(:any)'] 			= 'site/main/video/$1';
$route['newsletter'] 			= 'site/main/newsletter';
$route['contato'] 			= 'site/main/contato';
$route['rss']                           = 'site/main/rss';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
