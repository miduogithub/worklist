<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_shop.php 34523 2014-7-24 2014-05-15 18:55:29Z miduo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('DISCUZ_CORE_FUNCTION', true);




function setcache_indexslide($tid, $newindexslide_array){


	$cachepath = DISCUZ_ROOT.'/data/setcache/gaopingxingjing/indexslide/';
	Mk_Folder($cachepath);//建立目录
	$cachefile = DISCUZ_ROOT.'./data/setcache/gaopingxingjing/indexslide/indexslide_array.php';
	$cachedata="<?php \n ".' $indexslide_array = '.var_export($newindexslide_array,true)." \n ?>";
	file_put_contents($cachefile, $cachedata);		
}




function setcache_project_favicon_1($editorid, $newindexslide_array,$count){


	$newarr = array();

	$newarr['list'] = $newindexslide_array;
	$newarr['count'] = $count;
	$cachepath = DISCUZ_ROOT.'/data/setcache/worklist/project/favicon_1/';
	Mk_Folder($cachepath);//建立目录
	$cachefile = DISCUZ_ROOT.'./data/setcache/worklist/project/favicon_1/project_favicon_1_'.$editorid.'_array.php';
	$cachedata="<?php \n ".' $indexslide_array = '.var_export($newarr,true)." \n ?>";
	file_put_contents($cachefile, $cachedata);		
}

?>