<?php 
/*
 * Controller for development and testing purposes.
 * 
 * @package LydigaCore
 */

class CCDeveloper implements IController {
	public function Index() {
		$this->menu();
	}

	public function links() {
		$this->menu();

		$ly = CLydiga::GetInstance();

		$url = 'developer/links';
		$current = $ly->request->createURL($url);

		$ly->request->clean_url = false;
		$ly->request->querystring_url = false;
		$default = $ly->request->createURL($url);

		$ly->request->clean_url = true;
		$clean = $ly->request->createURL($url);

		$ly->request->clean_url = false;
		$ly->request->querystring_url = true;
		$querystring = $ly->request->createURL($url);

		$ly->data['main'] .= <<<EOD
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

	private function menu() {
		$ly = CLydiga::GetInstance();
		$menu = array('developer', 'developer/index', 'developer/links');

		$html = null;
		foreach ($menu as $item) {
			$html .= '<li><a href="'. $ly->request->createURL($item) .'">'. $item .'</a></li>';
		}

		$ly->data['header'] = 'The Developer Controller';
		$ly->data['main'] = <<<EOD
<h1>The Developer Controller</h1>
<p>This is what you can do for now.</p>
<ul>
$html
</ul>
EOD;
	}
}
?>