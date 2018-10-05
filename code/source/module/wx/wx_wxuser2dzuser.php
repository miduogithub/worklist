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
$view = getgpc('view');
loaducenter();
$uid = $_G['uid'];


if(empty($_G['uid'])) {

	if(!empty($_GET['uid'])) {
		$loginuid = $_GET['workuserloginuid'];
		settbcard_login_status($loginuid);
		$uid = $loginuid;
	}

}

$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE uid='$uid'");
while ($value = DB::fetch($query)) {
	$weixinmemberinfo = $value;
	$weixinmemberinfo_uid = $value['uid']; 
}

if($view == 'WeChatauthorization') {


	if(!EMPTY($weixinmemberinfo_uid)) {
		dheader("Location: work.php?mod=wxuser2dzuser");
	} else {
		require_once libfile('function/isweixin');
		check_in_weixin();
		//miduo('微信已授权成功！');
	}
	
} else {


	if(!EMPTY($weixinmemberinfo_uid)) {
		dheader("Location: work.php?mod=wxuser2dzuser");
	} else {

		 
		include template('diy:work/pc/work_wx_login_wechat_authorized');
		exit;
		//miduo('<a href="wx.php?mod=wxuser2dzuser&view=WeChatauthorization">绑定微信号</a><br /><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}"> 退出</a>');
	}
	
}


?>