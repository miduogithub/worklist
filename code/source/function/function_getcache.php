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




function getcache_indexslide() {


	$cachefile = DISCUZ_ROOT.'./data/setcache/gaopingxingjing/indexslide/indexslide_array.php';
	@include $cachefile;

	return $indexslide_array;


}


function getcache_project_favicon_1($editorid){

	$cachefile = DISCUZ_ROOT.'./data/setcache/worklist/project/favicon_1/project_favicon_1_'.$editorid.'_array.php';
	@include $cachefile;

	return $indexslide_array;	
}

?>