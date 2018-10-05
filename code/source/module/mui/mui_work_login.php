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

$loginInfo = array();
$loginInfo['username'] = $_GET['username'];
$loginInfo['password'] = $_GET['password'];


/*
$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE username = '$loginInfo[username]'");
while($value = DB::fetch($query)) {
		$member = $value;
}
*/

loaducenter();
$query = DB::query("SELECT * FROM ".UC_DBTABLEPRE."members WHERE username='$loginInfo[username]'");//status=1 说明已授权
while ($value = DB::fetch($query)) {

	$memberinfo = $value;
}

$tmpvar = md5(md5($_GET['password']).$memberinfo['salt']);

if($tmpvar == $memberinfo['password']) {

	$memberinfo['loginstate'] = '1';
} else {
	$memberinfo['loginstate'] = '2';
}

$mui_app_login_memberinfo = array();
$mui_app_login_memberinfo['mui_app_login_memberinfo'] = $memberinfo;

echo json_encode($mui_app_login_memberinfo);
EXIT;




?>
