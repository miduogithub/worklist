<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_post.php 33848 2013-08-21 06:24:53Z hypowang $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);

$view = getgpc('view');


if($view == 'about') {


	$message = '建设中……';
	include template('diy:work/pc/work_company_newadmin');

} elseif($view == 'organization') {
	


	include template('diy:work/pc/work_company_Organization');


} else {

	$message = '建设中……';
	include template('diy:work/pc/work_showmessage2_newadmin');
}



?>