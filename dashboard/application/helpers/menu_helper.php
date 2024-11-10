<?php
if ( ! defined('BASEPATH')) exit('No direct access is allowed');

function activate_menu($controller_method)
{
	$ci = get_instance();

	$controller_method = explode('/', $controller_method);

	$class = $ci->router->fetch_class();
	$method = $ci->router->fetch_method();

	return ($class == $controller_method[0] && $method == $controller_method[1]) ? 'active' : '';
}