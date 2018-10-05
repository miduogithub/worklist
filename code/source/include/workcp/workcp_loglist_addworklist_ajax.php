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


$worklistdata = array();


$getarr = array (
  'mod' => 'muicp',
  'ac' => 'work_addworklist',
  'appid' => 'HBuilder',
  'imei' => '868015020283528,868015020373758',
  'p' => 'a',
  'md' => 'HUAWEI GRA-CL10',
  'app_version' => '8.8.7',
  'plus_version' => '1.9.9.39230',
  'os' => '5.0.1',
  'net' => '6',
  'content' => '整理电业局项目。',
  'contact' => '',
  'score' => '0',
  'workid' => '3456',
);

//$editorid = $_GET['editorid'];
$workid = $_GET['workid'];
//$workmessage = $_GET['content'];
$dateline = $_G['timestamp'];

	$editorid = $_G['uid'];
	$workmessage = $_GET['message'];
	$workurl = $_GET['workurl'];

$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid = '$editorid'");
$userinfo = DB::fetch($query);
$editor = $userinfo['username'];

if($action == 'add') {

	$title = $workmessage;



	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}
	
	$data = array(
		'title' => $title,
		'message' => $workmessage,
		'workurl' => $workurl,
		'editor' => $editor,
		'editorid' => $editorid,
		'dateline' => $dateline,
		'lastpostdateline' => $_G['timestamp'],
		'lastposter' => $_G['username'],
	);

	DB::insert('work_loglist', $data);




	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')."  WHERE editorid='$editorid' ORDER BY lastpostdateline DESC LIMIT 1");
	$newworklist = DB::fetch($query);

	$newworkid = $newworklist['workid'];


	if(!empty($newworkid)) {

		$newworkdata['newworkid'] = $newworkid;

	} else {

		$newworkdata['newworkid'] = '0';
	}

	echo json_encode($newworkdata);
	EXIT;


} elseif($action == 'edit') {

	$newthreadinfo['message'] = $workmessage;

	$newthreadinfo['title'] = $workmessage;
	$newthreadinfo['lastpostdateline'] = $_G['timestamp'];
	$newthreadinfo['lastposter'] = $_G['username'];

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

} elseif($action == 'deleteworklist') {


	$newthreadinfo['status'] = '-1';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	//DB::delete('work_loglist', array('workid'=>$workid));

}

/*

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
*/
EXIT;




?>