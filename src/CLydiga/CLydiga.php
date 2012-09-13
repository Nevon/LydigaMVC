<?php 
/*
 * Main class for LydigaMVC, holds everything.
 *
 * @package LydigaCore
 *
 */
class CLydiga implements ISingleton {
	private static $instance = null;

	/*
	 * Singleton. Get the instance of the latest created object 
	 * or create a new one.
	 *
	 * @return Clydiga The instance of this class.
	 */
	public static function GetInstance() {
		if (self::$instance === null) {
			self::$instance = new CLydiga();
		}
		return self::$instance;
	}

	protected function __construct() {
		//Include the site specific config file
		$ly = &$this; //TODO: Don't pass by reference
		require(LYDIGAMVC_SITE_PATH . '/config.php');
	}

	/*
	 * Frontcontroller. Check URL and route to controllers
	 */
	public function FrontControllerRoute() {		
		//Parse URL to get controller, method and parameters
		$this->request = new CRequest($this->config['url_type']);
		$this->request->Init($this->config['base_url']);

		$controller = $this->request->controller;
		$method = $this->request->method;
		$arguments = $this->request->arguments;
		
		//Is the controller enabled in config.php?
		$controllerExists = isset($this->config['controllers'][$controller]);
		$controllerEnabled = false;
		$className = false;
		$classExists = false;

		if ($controllerExists) {
			$controllerEnabled = ($this->config['controllers'][$controller]['enabled'] === true);
			$className = $this->config['controllers'][$controller]['class'];
			$classExists = class_exists($className);
		}

		//Check for callable method and call it
		if ($controllerExists && $controllerEnabled && $classExists) {
			$rc = new ReflectionClass($className);
			if ($rc->implementsInterface('IController')) {
				if ($rc->hasMethod($method)) {
					$controllerObj = $rc->newInstance();
					$methodObj = $rc->getMethod($method);
					$methodObj->invokeArgs($controllerObj, $arguments);
				} else {
					die("404. " . get_class() . ' error: Controller does not contain method: ' . $method);
				}
			} else {
				die("404. " . get_class() . " error: Controller does not implement interface IController.");
			}
		} else {
			header("HTTP/1.0 404 Page Not Found");
			die();
		}
	}

	/*
	 * Theme engine render. Renders the views using the selected theme.
	 */
	public function ThemeEngineRender() {
		//Get paths and settings for the theme
		$themeName = $this->config['theme']['name'];
		$themePath = LYDIGAMVC_INSTALL_PATH . "/themes/{$themeName}";
		$themeURL = $this->request->base_url . "themes/{$themeName}";

		//Add stylesheet path to the data array
		$this->data['stylesheet'] = "{$themeURL}/style.css";

		// Include the global functions.php and the functions.php
		// that is part of the theme.
		$ly = &$this;
		$functionsPath = "{$themePath}/functions.php";
		include LYDIGAMVC_INSTALL_PATH . '/themes/functions.php';
		if (is_file($functionsPath)) {
			include $functionsPath;
		}	

		// Extract $ly->data to own variables and hand over to the
		// template file.
		extract($this->data);
		include("{$themePath}/default.tpl.php");
	}
}
?>