<?php 
/*
 * Site configuration.
 *
 */

//Error reporting
error_reporting(-1);
ini_set('display_errors', 1);

//Debug output
$ly->config['debug'] = true;

//Session name
$ly->config['session_name'] = preg_replace('/[:\.\/-_]/', '', $_SERVER['SERVER_NAME']);

//Timezone
$ly->config['timezone'] = 'Europe/Stockholm';

//Character encoding
$ly->config['character_encoding'] = 'UTF-8';

//Language
$ly->config['language'] = 'en';

/*
 * Define the controllers, their classname and enable/disable them.
 *
 * The array-key is matched against the URL, for example:
 * the URL 'developer/dump' would instantiate the controller with the key
 * 'developer', which is CDeveloper and call the method 'dump' in that class.
 * This process is managed in:
 * $ly->FrontControllerRoute();
 * which is called in the routing phase in index.php.
 */
$ly->config['controllers'] = array(
	'index'			=> 	array(
							'enabled' => true,
							'class' => 'CCIndex'
						),
	'developer'		=>	array(
							'enabled' => true,
							'class' => 'CCDeveloper'
						)
);

//Theme settings
$ly->config['theme'] = array(
	'name' 			=>	'core'
);

//Set a base_url to use another than the default calculated
$ly->config['base_url'] = null;

/*What type of URLs should be used?
 *
 * default 			= 0 	=> index.php/controller/method/arg1/arg2
 * clean 			= 1		=> controller/method/arg1/arg2
 * querystring 		= 2		=> index.php?q=controller/method/arg1/arg2
 */
$ly->config['url_type'] = 1;
?>