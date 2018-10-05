<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}


@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_TC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/function/func.php');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/template/touch/praise.htm');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/hook.class.php');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/install.php');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/praise.inc.php');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/more.inc.php');
$finish = TRUE;


?>
