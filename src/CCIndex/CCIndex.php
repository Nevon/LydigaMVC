<?php 
/*
 * Standard controller layout.
 *
 * @package LydigaCore
 */

class CCIndex implements IController {
	// Implementing interface IController. All controllers must have an 
	// index action.
	public function Index() {
		global $ly;
		$ly->data['title'] = "The Index Controller";
		$ly->data['header'] = 'Detta är en header';
		$ly->data['footer'] = 'Detta är en footer';
		$ly->data['main'] = 'Här finns trams.';
	}
}
?>