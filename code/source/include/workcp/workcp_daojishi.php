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

	$starttime_ymd= $_GET['starttime_ymd'];
	$starttime_his = $_GET['starttime_his'];
	$endtime_ymd = $_GET['endtime_ymd'];
	$endtime_his = $_GET['endtime_his'];



	$starttimedateline = strtotime(''.$starttime_ymd.' '.$starttime_his.'');
	$endtimedateline = strtotime(''.$endtime_ymd.' '.$endtime_his.'');



	//$message = iconv('GBK', 'UTF-8', $_GET['message']);

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

	//转码
	//$message = iconv("UTF-8","gb2312",$message);

	$title = $message;

	$data = array(
		'title' => $title,	
		'message' => $message,
		'editor' => $editor,
		'editorid' => $editorid,
		'dateline' => $dateline,
		'lastpostdateline' => $_G['timestamp'],
		'lastposter' => $_G['username'],
		'starttimedateline' => $starttimedateline,
		'endtimedateline' => $endtimedateline
	);

	DB::insert('work_daojishi', $data);

	dheader("Location: ".dreferer()."");

	//showmessage('添加成功', dreferer(), array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));

} elseif($action == 'edit') {



	$newthreadinfo = array();

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}



	if($_GET['editback'] =='ture') {
		dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");
	}

	$message = $_GET['message'];

	$starttime_ymd= $_GET['starttime_ymd'];
	$starttime_his = $_GET['starttime_his'];
	$endtime_ymd = $_GET['endtime_ymd'];
	$endtime_his = $_GET['endtime_his'];

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
	$newthreadinfo['title'] = $message;
	
	$newthreadinfo['lastpostdateline'] = $_G['timestamp'];
	$newthreadinfo['lastposter'] = $_G['username'];

	

	DB::update('work_daojishi', $newthreadinfo, "workid='$workid'");

	dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");

	//showmessage('编辑成功', "work.php?mod=daojishi&dateline=".$dateline."", array('fuid' => $followuid, 'type' => 0, 'special' => $special, 'from' => !empty($_GET['from']) ? $_GET['from'] : 'list'), array('closetime' => '2', 'showmsg' => '1'));
} elseif($action == 'finish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '1';

	DB::update('work_daojishi', $newthreadinfo, "workid='$workid'");

	$editorid = $_GET['editorid'];

	$check = $_GET['check'];

	if($check == 'incomplete') {
		
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=daojishi&check=incomplete&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=daojishi&check=incomplete");
		}
		
	} else {

		dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");
	}

	//dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");
	//showmessage('该任务已标记完成！', 'work.php?mod=daojishi&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'unfinish') {



	if(empty($workid)) {

		showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '0';

	DB::update('work_daojishi', $newthreadinfo, "workid='$workid'");



	$editorid = $_GET['editorid'];

	$check = $_GET['check'];

	if($check == 'incomplete') {
		
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=daojishi&check=incomplete&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=daojishi&check=incomplete");
		}
		
	} else {

		dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");
	}

	
	//showmessage('该任务已标记未完成！', 'work.php?mod=daojishi&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'delete') {



	if(empty($workid)) {

		showmessage('选择帖子不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}


	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['status'] = '-1';

	DB::update('work_daojishi', $newthreadinfo, "workid='$workid'");

	//DB::delete('work_daojishi', array('workid'=>$workid));
	
	dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");
	//showmessage('删除成功', 'work.php?mod=daojishi&dateline='.$dateline.'', array(), array('return' => true));

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


	$query = DB::query("SELECT * FROM ".DB::table('work_daojishi')." WHERE workid = '$workid'");
	while($row = DB::fetch($query)) {
		$loginfo = $row;
	}

	$data = array(
		'message' => $loginfo['message'],
		'editor' => $loginfo['editor'],
		'dateline' => $dateline,
	);

	DB::insert('work_daojishi', $data);

	showmessage('推送成功！', 'work.php?mod=daojishi', array(), array('return' => true));

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

	DB::update('work_daojishi', $newthreadinfo, "workid='$workid'");

	dheader("Location: work.php?mod=daojishi&dateline=".$dateline."");
	//showmessage('提升成功！', 'work.php?mod=daojishi&dateline='.$dateline.'', array(), array('return' => true));

} elseif($action == 'backtoday') {

	if(!empty($_GET['submitdateline'])) {

		$dateline = $_GET['submitdateline'];

	}
	dheader("Location: work.php?mod=daojishi".$dateline."");


}

?>