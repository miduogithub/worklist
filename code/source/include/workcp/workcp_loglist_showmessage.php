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
$workid = $_GET['workid'];

if($_G['adminid'] != '1' && $_G['groupid'] != '24') {
	showmessage('您无权访问本页面', null, array(), array('showmsg' => true, 'login' => 1));
}
if($action == 'add') {

	$newthreadinfo = array();


	$message = $_GET['message'];
	$url = $_GET['url'];
	$editor = $_G['username'];
	$editorid = $_G['uid'];

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}
	
	if(empty($message)) {
		dheader("Location: ".dreferer()."");
	}

	$data = array(
		'message' => $message,
		'editor' => $editor,
		'editorid' => $editorid,
		'dateline' => $dateline,
	);

	DB::insert('work_loglist', $data);

	showmessage('添加成功', dreferer(), array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));

} elseif($action == 'edit') {



	$newthreadinfo = array();

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}



	if($_GET['editback'] =='ture') {
		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	$message = $_GET['message'];

	//$editor = $_G['username'];
	//$editorid = $_G['uid'];

	//$editor = '海鸟跟鱼';
	//$editorid = '87778';


	if(!empty($_GET['editor']) && !empty($_GET['editorid'])) {

		$editor = $_GET['editor'];
		$editorid = $_GET['editorid'];

		$newthreadinfo['editor'] = $editor;
		$newthreadinfo['editorid'] = $editorid;
	} 

	$newthreadinfo['message'] = $message;


	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	showmessage('编辑成功', "work.php?mod=worklist&dateline=".$dateline."", array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));
} elseif($action == 'finish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '1';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	showmessage('该任务已标记完成！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'unfinish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '0';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	showmessage('该任务已标记未完成！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'delete') {



	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	DB::delete('work_loglist', array('workid'=>$workid));
	showmessage('删除成功', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'pushtoday') {//推送到今天


	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		//$dateline = $_GET['dateline'];

	}

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}


	$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." WHERE workid = '$workid'");
	while($row = DB::fetch($query)) {
		$loginfo = $row;
	}

	$data = array(
		'message' => $loginfo['message'],
		'editor' => $loginfo['editor'],
		'dateline' => $dateline,
	);

	DB::insert('work_loglist', $data);

	showmessage('推送成功！', 'work.php?mod=worklist', array(), array('return' => true));

} elseif($action == 'pushtop') {//提升

	$newthreadinfo = array();

	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		//$dateline = $_GET['dateline'];

	}

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	} else {

		$dateline = $_G['timestamp'];
	}


	$newthreadinfo['dateline'] = $_G['timestamp'];

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	showmessage('提升成功！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'backtoday') {

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}
	dheader("Location: work.php?mod=worklist".$dateline."");


}

?>