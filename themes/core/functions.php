<?php 
/*
 * Print debug information from the framework.
 */
function get_debug() {
	$ly = CLydiga::GetInstance();

	if ($ly->config['debug'] === false) {
		return;
	}

	$html = "<h2>Debug information</h2><hr><p>The content of the config array:</p><pre>".htmlentities(print_r($ly->config, true))."</pre>";
	$html .= "<h2>Debug information</h2><hr><p>The content of the data array:</p><pre>".htmlentities(print_r($ly->data, true))."</pre>";
	$html .= "<h2>Debug information</h2><hr><p>The content of the request array:</p><pre>".htmlentities(print_r($ly->request, true))."</pre>";
	return $html;
}
?>