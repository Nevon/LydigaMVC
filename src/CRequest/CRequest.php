<?php 
/*
 * Parse the request and identify controller, ethod an darguments.
 *
 * @package LydigaCore
 */

class CRequest {
	/*
	 * Initialize the object by parsing the current URL request.
	 */
	public function __construct($url_type = 0) {
		$this->clean_url = ($url_type === 1);
		$this->querystring_url = ($url_type === 2);
			
	}

	public function init($base_url = null) {
		$request_uri = $_SERVER['REQUEST_URI'];
		$script_name = $_SERVER['SCRIPT_NAME'];

		// Compare request URI and script name. As long as they match, leave the 
		// rest as current request.
		// TODO: Make this not weird
		$i = 0;
		$uri_length = min(strlen($request_uri), strlen($script_name));
		while ($i < $uri_length && $request_uri[$i] === $script_name[$i]) {
			$i++;
		}
		$request = trim(substr($request_uri, $i), '/');

		//Remove the ?-part of the query
		$query_pos = strpos($request, '?');
		if ($query_pos !== false) {
			$request = substr($request, 0, $query_pos);
		}

		//Check if request is empty and query string link is set
		if (empty($request) && isset($_GET['q'])) {
			$request = trim($_GET['q']);
		}
		$splits = explode('/', $request);

		//Set controller, method and arguments
		$controller = !empty($splits[0]) ? $splits[0] : 'index';
		$method = !empty($splits[1]) ? $splits[1] : 'index';
		$arguments = array_slice($splits, 2); //Remove controller and method

		// Prepare to create current_url and base_url
    	$current_url = $this->getCurrentUrl();
    	$parts = parse_url($current_url);
    	$base_url = !empty($base_url) ? $base_url : "{$parts['scheme']}://{$parts['host']}" . (isset($parts['port']) ? ":{$parts['port']}" : '') . rtrim(dirname($script_name), '/');

		//Store it
		$this->base_url = rtrim($base_url, '/') . '/';
		$this->current_url = $current_url;
		$this->request_uri = $request_uri;
		$this->script_name = $script_name;
		$this->splits = $splits;
		$this->controller = $controller;
		$this->method = $method;
		$this->arguments = $arguments;
	}

	public function getCurrentURL() {
		$url = (@$_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
		$url .= '://';
		$serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' : (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
		$url .= $_SERVER['SERVER_NAME'] . $serverPort . htmlspecialchars($_SERVER['REQUEST_URI']);
		return $url;
	}

	public function createURL($url = null) {
		$result = $this->base_url;
		if ($this->clean_url) {
			;
		} elseif ($this->querystring_url) {
			$result .= 'index.php?q=';
		} else {
			$result .= 'index.php/';
		}

		return $result . rtrim($url, '/');
	}
}
?>