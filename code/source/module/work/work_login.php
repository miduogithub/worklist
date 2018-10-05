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

if(!empty($_G['uid'])) {
	$important_count = get_important_count();
	if($important_count > '0') {
		dheader("Location: work.php?mod=index_qk");
	} else {
		dheader("Location: work.php?mod=worklist");
	}
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

		settbcard_login_status($memberinfo['uid']);
		$important_count = get_important_count();
		if($important_count > '0') {
			dheader("Location: work.php?mod=index_qk");
		} else {
			dheader("Location: work.php?mod=worklist");
		}
		
	} else {
		showmessage("帐号或密码错误，请返回重新登录");
	}
}



if(checkMobile() == true && $_G['cookie']['mobile'] != 'no') {//$_G['cookie']['mobile'] 手机切换电脑版会种入cookie 所以增加判断条件

	include template('diy:work/pc/work_login');
	//include template('forum/post_work');
	//include template('diy:work/mobile/work_loglist');

} else{
	//include template('diy:work/pc/work_loglist');
	include template('diy:work/pc/work_login_niubi_login_ajax');
	

}




?>