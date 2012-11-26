<?php 
/*
 * Bootstrapping. Setting up and loading the core.
 *
 * @package LydigaCore
 *
 */

//Autoloading of class declarations
function autoload($aClassName) {
	$classFile = "/src/{$aClassName}/{$aClassName}.php";
	$file1 = LYDIGAMVC_INSTALL_PATH . $classFile;
	$file2 = LYDIGAMVC_SITE_PATH . $classFile;

	if (is_file($file1)) {
		require_once($file1);
	} elseif (is_file($file2)) {
		require_once($file2);
	} else {
		echo $file1.'\n'.$file2.'\n';
		throw new Exception("$aClassName not found.");
	}
}
spl_autoload_register('autoload');

/*
 * Helper, wrap htmlentities with correct character encoding
 */
function htmlent($str, $flags = ENT_COMPAT) {
	return htmlentities($str, $flags, CLydiga::GetInstance()->config['character_encoding']);
}

?>