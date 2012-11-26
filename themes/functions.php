<?php 
/*
 * Helpers for theming. Available for all themes in their template files and 
 * functions.php. This file is included right before the themes' own functions.php
 */

//Creates a URL by prepending the base URL
function base_url($url) {
	return CLydiga::Instance()->request->base_url . trim($url, '/');
}

function current_url() {
	return CLydiga::Instance()->request->current_url;
}
?>