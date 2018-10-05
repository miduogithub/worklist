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
if(empty($view)) {

	$view = 'index';

}
if(empty($_G['uid'])) {

	if(!empty($_GET['uid'])) {
		$loginuid = $_GET['uid'];
		settbcard_login_status($loginuid);

		$important_count = get_important_count();
		if($important_count > '0') {
			dheader("Location: work.php?mod=index_qk");
		} else {
			dheader("Location: work.php?mod=worklist");
		}
	} else {
		dheader("Location: work.php?mod=login");
		//showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
	}

}



$important_count = get_important_count();

/*
if($important_count > '0') {
	dheader("Location: work.php?mod=index_qk");
} else {
	dheader("Location: work.php?mod=worklist");
}
*/





include template('diy:wplus/pc/wplus_index');











?>