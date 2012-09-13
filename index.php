<?php 
	//Bootstrap
	define('LYDIGAMVC_INSTALL_PATH', dirname(__FILE__));
	define('LYDIGAMVC_SITE_PATH', LYDIGAMVC_INSTALL_PATH . '/app');

	require(LYDIGAMVC_INSTALL_PATH . '/src/CLydiga/bootstrap.php');

	$ly = CLydiga::GetInstance();

	//Routing
	$ly->FrontControllerRoute();

	//Templating
	$ly->ThemeEngineRender();
?>