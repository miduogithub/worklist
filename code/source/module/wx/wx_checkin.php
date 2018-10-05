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
//微信模板消息阅读状态更改
update_tmplmsg_logs_status_by_tmplmsgid();	

if(empty($_G['uid'])) {
	dheader("Location: wx.php?mod=login");
} else {
	$uid = $_G['uid'];
}


if(is_weixin() == false) {
	//showmessage_work("请使用微信进行签到！","","0");
}

include_once libfile('function/isweixin');

if(empty($_GET['weixinopenid'])) {

	get_weixin_userinfo();

} else {

	loaducenter();
	$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."weixin_member WHERE uid='$uid'");
	while ($value = DB::fetch($query)) {
		$checuidinfo = $value; 
	}

	if(empty($checuidinfo)) {
		showmessage_work("请先绑定微信再进行签到！","","0");
	}

	if($checuidinfo['openid'] != $_GET['weixinopenid']) {
		showmessage_work("请使用该微信帐号绑定过的discuz帐号进行签到！","","0");
	}
}


	

$ip_checkin_winfi = gethostbyname("1840p5t641.imwork.net");
$ip_checkin_weixin = $_G['clientip'];


//获取当前用户check记录
$query = DB::query("SELECT * FROM ".DB::table('work_wx_checkin_logs')." WHERE editorid='$uid' ORDER BY dateline DESC LIMIT 150");
while ($value = DB::fetch($query)) {
	$threadlist[] = $value; 
	
}

$checkinfoarr = get_this_checkaction($uid);
$thischeckaction = $checkinfoarr['thischeckaction'];
$thischeckaction_value = $checkinfoarr['thischeckaction_value'];


include template('diy:work/pc/work_wx_checkin');
?>