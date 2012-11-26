<?php
/*
 * Holding an instance of CLydiga to enable the use of $this in subclasses
 *
 * @package LydigaCore
 *
 */

class CObject {
	public $config;
	public $request;
	public $data;

	protected function __construct() {
		$ly = CLydiga::GetInstance();
		$this->config = &$ly->config;
		$this->request = &$ly->request;
		$this->data = &$ly->data;
	}
}