<?php

defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? NULL : define('SITE_ROOT', DS.'Applications'.DS.'MAMP'.DS.'htdocs'.DS.'contechnical'.DS.'circuit_tester');
defined('LIB_PATH') ? NULL : define('LIB_PATH', SITE_ROOT.DS.'includes');

require_once(LIB_PATH.DS.'config.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.S.'functions.php');
?>
