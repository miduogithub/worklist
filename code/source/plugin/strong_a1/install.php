<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/strong_a1/discuz_plugin_strong_a1_TC_UTF8.xml');
$finish = TRUE;


?>
