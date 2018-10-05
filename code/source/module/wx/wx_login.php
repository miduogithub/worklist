<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forum_viewthread.php 35494 2015-08-06 09:31:59Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('NOROBOT', TRUE);

if(!empty($_G['uid'])) {
	//dheader("Location: wx.php?mod=wxuser2dzuser");
}

if(!empty($_POST)) {

	$username = $_GET['username'];
	loaducenter();
	$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."members WHERE username='$username'");//status=1 说明已授权
	while ($value = DB::fetch($query)) {

		$memberinfo = $value;
	}

	$tmpvar = md5(md5($_GET['password']).$memberinfo['salt']);
	
	if($tmpvar == $memberinfo['password']) {
		
		include_once libfile('function/work');
		settbcard_login_status($memberinfo['uid']);
		dheader("Location: wx.php?mod=wxuser2dzuser");
	} else {
		showmessage_work("帐号或密码错误，请返回重新登录");
	}
}



include template('diy:work/pc/work_wx_login');


?>