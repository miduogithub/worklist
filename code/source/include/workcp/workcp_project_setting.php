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
$projectid = $_GET['projectid'];
$uid = $_G['uid'];
if($_GET['nomal'] == '0') {
	$projectid_nomal = '1';
} else {
	$projectid_nomal = '0';
}


if($action == 'opendclosed_projectfavicon') {
	
	$query = DB::query("SELECT * FROM ".DB::table('work_setting_project_status')." WHERE uid='$uid' AND projectid='$projectid'");
	$settinginfo = DB::fetch($query);
	if(empty($settinginfo)) {

		$data = array(
			'uid' => $uid,
			'projectid' => $projectid,
			'favicon_status' => $projectid_nomal,
		);

		DB::insert('work_setting_project_status', $data);

	} else {


		if($settinginfo['favicon_status'] == '0') {
			$newthreadinfo['favicon_status'] = '1';
		} else {
				$newthreadinfo['favicon_status'] = '0';
		}
		DB::update('work_setting_project_status', $newthreadinfo, "uid='$uid' AND projectid='$projectid'");

		$arr = array(
			'flag'=>$newthreadinfo['favicon_status'],	
		);		

		echo json_encode($arr);
		EXIT;
	}

}


	

?>