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
	$workurl = $_GET['workurl'];

	//$message = iconv('GBK', 'UTF-8', $_GET['message']);

	//$url = $_GET['url'];
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

	//转码
	//$message = iconv("UTF-8","gb2312",$message);

	$title = $message;

	$data = array(
		'title' => $title,	
		'message' => $message,
		'workurl' => $workurl,
		'editor' => $editor,
		'editorid' => $editorid,
		'dateline' => $dateline,
		'lastpostdateline' => $_G['timestamp'],
		'lastposter' => $_G['username'],
	);

	DB::insert('work_loglist', $data);



	$projectid = $_GET['projectid'];
	if(!EMPTY($projectid)) {


		$query = DB::query("SELECT * FROM ".DB::table('work_loglist')." WHERE message = '$message' ORDER BY dateline DESC LIMIT 1");
		$lastworklist = DB::fetch($query);

		$workid = $lastworklist['workid'];
		$query = DB::query("SELECT * FROM ".DB::table('work_project_worklist')." WHERE workid='$workid' AND projectid='$projectid'");
		$pwinfo = DB::fetch($query);

		if(!empty($pwinfo)) {
			showmessage_work("该日志已经关联过该项目了");
		}

		$data = array(
			'pwid' => NULL,
			'projectid' => $projectid,
			'workid' => $workid,
		);
		DB::insert('work_project_worklist', $data);

		$actionmod = '项目日志';
		$actionname = '增加';
		$actionmessage = $message;
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	


		dheader("Location: work.php?mod=project&view=mission&projectid=".$projectid."&vieworder=alleditor");

	}



	dheader("Location: ".dreferer()."");

	//showmessage('添加成功', dreferer(), array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));

} elseif($action == 'edit') {



	$newthreadinfo = array();

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}



	if($_GET['editback'] =='ture') {
		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	$message = $_GET['message'];
	$workurl = $_GET['workurl'];

	$changetime = $_GET['changetime'];

	if($changetime == '1') {
		$worklist_datetime_Hi = $_GET['worklist_datetime_Hi_new'];
		$worklist_datetime_Ymd = $_GET['worklist_datetime_Ymd'];
		$worklist_datetimeline_YmdHis_new = strtotime(''.$worklist_datetime_Ymd.' '.$worklist_datetime_Hi.':00');
		$newthreadinfo['dateline'] = $worklist_datetimeline_YmdHis_new;
	}
	

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
	$newthreadinfo['workurl'] = $workurl;
	$newthreadinfo['title'] = $message;
	
	$newthreadinfo['lastpostdateline'] = $_G['timestamp'];
	$newthreadinfo['lastposter'] = $_G['username'];



	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	dheader("Location: work.php?mod=worklist&dateline=".$dateline."");

	//showmessage('编辑成功', "work.php?mod=worklist&dateline=".$dateline."", array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));
} elseif($action == 'finish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '1';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	$editorid = $_GET['editorid'];

	$check = $_GET['check'];

	if($check == 'incomplete') {
		
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=worklist&check=incomplete&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=worklist&check=incomplete");
		}
		
	} else {

		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	//dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	//showmessage('该任务已标记完成！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'unfinish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '0';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");



	$editorid = $_GET['editorid'];

	$check = $_GET['check'];

	if($check == 'incomplete') {
		
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=worklist&check=incomplete&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=worklist&check=incomplete");
		}
		
	} else {

		dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	}

	
	//showmessage('该任务已标记未完成！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'delete') {



	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}

	$query = DB::query("SELECT * FROM ".DB::table('work_project_worklist')." WHERE workid='$workid'");
	$pwinfo = DB::fetch($query);

	if(!empty($pwinfo)) {

		showmessage_work('该日志关联有项目，无法删除，请取消关联的项目', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '-1';

	DB::update('work_loglist', $newthreadinfo, "workid='$workid'");

	//DB::delete('work_loglist', array('workid'=>$workid));
	
	dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	//showmessage('删除成功', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

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

	dheader("Location: work.php?mod=worklist&dateline=".$dateline."");
	//showmessage('提升成功！', 'work.php?mod=worklist&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'backtoday') {

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}
	dheader("Location: work.php?mod=worklist".$dateline."");


}

?>