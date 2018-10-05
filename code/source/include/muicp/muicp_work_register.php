<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: spacecp_class.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$ops = array('loglist');
$op = in_array($_GET['op'], $ops) ? $_GET['op'] : '';
$action = $_GET['action'];


$regInfodata = array();

//建立用户
$groupid = '24';//高平吧运营中心
$newusername = $_GET['username'];
$password = $_GET['password'];
$email = $_GET['email'];

if(!empty($newusername)) {
	$newuid = setnewuser($newusername, $groupid, $password, $email);
}

if(!empty($newuid)) {

	$regInfodata['reginfostate'] = '1';

} else {

		$regInfodata['reginfostate'] = '2';
}

echo json_encode($regInfodata);
EXIT;
//miduo($_GET,'noshow');

/*
//更新手机号
$newpost['mobile'] = $mobile;
DB::update('common_member_profile ', $newpost, "uid='$newuid'");

$return_flag = 'ok';
$arr = array(
	'flag'=>$return_flag,	
	'uid'=>$newuid,
);	

*/



?>