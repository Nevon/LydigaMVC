<?php 
/*
 * Controller for development and testing purposes.
 * 
 * @package LydigaCore
 */

class CCDeveloper extends CObject implements IController {
	public function __construct() {
		parent::__construct();
	}

	public function DisplayObject() {
		$this->Menu();

		$this->data['main'] .= '<h2>Dumping content of CDeveloper</h2>';
		$this->data['main'] .= '<p>Here is the content of the controller, including properties from CObject, which holds access to common resources in CLydiga.</p>';
		$this->data['main'] .= '<pre>'.htmlent(print_r($this, true)).'</pre>';
		
	}

	public function Index() {
		$this->menu();
	}

	public function Links() {
		$this->menu();

		$url = 'developer/links';
		$current = $this->request->createURL($url);

		$this->request->clean_url = false;
		$this->request->querystring_url = false;
		$default = $this->request->createURL($url);

		$this->request->clean_url = true;
		$clean = $this->request->createURL($url);

		$this->request->clean_url = false;
		$this->request->querystring_url = true;
		$querystring = $this->request->createURL($url);

		$this->data['main'] .= <<<EOD
<h2>CRequest::createURL()</h2>
<p>Here is a list of URLs created using the above method with various settings. All links should lead to this same page.</p>
<ul>
<li><a href='$current'>This is the current setting</a></li>
<li><a href='$default'>This is the default setting</a></li>
<li><a href='$clean'>This is the clean setting</a></li>
<li><a href='$querystring'>This is the querystring setting</a></li>
</ul>
EOD;
	}

	private function Menu() {
		$menu = array('developer', 'developer/index', 'developer/links');

		$html = null;
		foreach ($menu as $item) {
			$html .= '<li><a href="'. $this->request->createURL($item) .'">'. $item .'</a></li>';
		}

		$this->data['header'] = 'The Developer Controller';
		$this->data['main'] = <<<EOD
<h1>The Developer Controller</h1>
<p>This is what you can do for now.</p>
<ul>
$html
</ul>
EOD;
	}
}
?>