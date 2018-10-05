<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!isset($_G['cache']['plugin'])){
	loadcache('plugin');
}

@extract($_G['cache']['plugin']['v2_wap_02']);

?>