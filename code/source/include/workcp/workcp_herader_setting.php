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
$op = in_array($_GET['op'], $ops) ? $_GET['op'] : '';
$action = $_GET['action'];
$uid = $_G['uid'];

if($action == 'opendclosed_sidebar') {
	
	$query = DB::query("SELECT * FROM ".DB::table('work_setting')." WHERE uid='$uid'");
	$settinginfo = DB::fetch($query);
	if(empty($settinginfo)) {

		$data = array(
			'uid' => $uid,
			'headersidebar_status' => '0',
		);

		DB::insert('work_setting', $data);

	} else {


		

		if($settinginfo['headersidebar_status'] == '0') {
			$newthreadinfo['headersidebar_status'] = '1';
		} else {
				$newthreadinfo['headersidebar_status'] = '0';
		}
		DB::update('work_setting', $newthreadinfo, "uid='$uid'");

		$arr = array(
			'flag'=>$newthreadinfo['headersidebar_status'],	
		);		

		echo json_encode($arr);
		EXIT;
	}

}


	

?>