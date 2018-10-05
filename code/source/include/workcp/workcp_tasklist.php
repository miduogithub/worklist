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

$ops = array('tiebavote');
$op = $_GET['op'];
$action = $_GET['action'];
$missionid = $_GET['missionid'];
$projectid = $_GET['projectid'];
$taskid =  $_GET['taskid'];

//$price = $_GET['price'];
$missionstarttime = getgpc('missionstarttime');
$missionstarttimeline = strtotime($missionstarttime);
if(empty($missionstarttime)) {
	$missionstarttimeline = $_G['timestamp'];
}

if(!empty($_GET['project_editorid'])) {

	$editorid = $_GET['project_editorid'];
	$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE uid='$editorid'");
	while ($value = DB::fetch($query)) {
		$member = $value; 
	}
	$editor = $member['username'];

} else {

	$editorid = $_G['uid'];
	$editor = $_G['username'];
}


$query = DB::query("SELECT * FROM ".DB::table('work_project_mission_tasklist')." WHERE taskid='$taskid'");
while ($value = DB::fetch($query)) {
	
	$taskinfo = $value; 
}

if($action == 'add') {


	if(empty($missionid)) {
		showmessage("所属任务不能为空");
	}

	$project_typeid = $_GET['project_typeid'];

	$taskname = $_GET['taskname'];
	$taskurl = $_GET['taskurl'];

	if(empty($taskname)) {
		showmessage("任务内容不能为空");
	}

	$data = array(
		'taskid' => NULL,
		'missionid' => $missionid,
		'taskname' => $taskname,
		'taskurl' => $taskurl,
		'editorid' => $editorid,
		'editor' => $editor,
		'dateline' => $missionstarttimeline,
		'status' => '0',
	);
	DB::insert('work_project_mission_tasklist', $data);

	$actionmod = '任务内容';
	$actionname = '增加';
	$actionmessage = $taskname;
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);	


	dheader("Location: ".dreferer()."");
	//dheader("Location: work.php?mod=taskbar&view=mission&projectid=".$projectid."&vieworder=alleditor");

} elseif($action == 'edit') {

	//$editorid = $_GET['editorid'];

	if($taskinfo['status'] == '1') {
		showmessage("抱歉，该任务已经完成，您无权修改");
	}

	if(empty($missionid)) {
		showmessage("所属任务不能为空");
	}

	$project_typeid = $_GET['project_typeid'];

	$taskname = $_GET['taskname'];
	$taskurl = $_GET['taskurl'];

	if(empty($taskname)) {
		showmessage("名称不能为空");
	}

	$newpost['taskname'] = $taskname;
	$newpost['taskurl'] = $taskurl;

	DB::update('work_project_mission_tasklist', $newpost, "taskid='$taskid'");

	$actionmod = '任务task';
	$actionname = '修改';
	$actionmessage = $taskinfo['missionname'];
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);	

	dheader("Location: work.php?mod=taskbar&view=mission&projectid=".$projectid."&vieworder=alleditor");
} elseif($action == 'delete') {

	if($taskinfo['status'] == '1') {
		//showmessage("抱歉，该任务已经完成，您无权删除");
	}

	DB::delete('work_project_mission_tasklist', "taskid='$taskid'");

	$actionmod = '任务内容';
	$actionname = '删除';
	$actionmessage = $taskinfo['taskname'];
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);		

	dheader("Location: ".dreferer()."");

} elseif($action == 'finish') {



		$newthreadinfo['status'] = '1';

		DB::update('work_project_mission_tasklist', $newthreadinfo, "taskid='$taskid'");

		$actionmod = '任务内容';
		$actionname = '完成';
		$actionmessage = $taskinfo['taskname'];
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);		
		dheader("Location: ".dreferer()."");



} elseif($action == 'unfinish') {


		$newthreadinfo['status'] = '0';

		DB::update('work_project_mission_tasklist', $newthreadinfo, "taskid='$taskid'");

		$actionmod = '任务内容';
		$actionname = '未完成';
		$actionmessage = $taskinfo['taskname'];
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);		
		dheader("Location: ".dreferer()."");



} elseif($action == 'pushtop') {



		$newthreadinfo['dateline'] = $_G['timestamp'];

		DB::update('work_project_mission_tasklist', $newthreadinfo, "taskid='$taskid'");
		$actionmod = '任务内容';
		$actionname = '顺序提升';
		$actionmessage = $taskinfo['missionname'];
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	



		dheader("Location: ".dreferer()."");

} elseif($action == 'addmission') {


		if(empty($projectid)) {
			showmessage("所属项目不能为空");
		}

		$project_typeid = $_GET['project_typeid'];

		if(empty($project_typeid)) {
			showmessage("任务类型不能为空");
		}

		$missionname = $_GET['missionname'];

		if(empty($missionname)) {
			showmessage("任务名称不能为空");
		}

		$data = array(
			'missionid' => NULL,
			'projectid' => $projectid,
			'projecttypeid' => $project_typeid,
			'missionname' => $missionname,
			'editorid' => $editorid,
			'editor' => $editor,
			'missionstarttimeline' => $missionstarttimeline,
			'status' => '0',
		);
		DB::insert('work_project_mission', $data);

		$actionmod = '项目任务';
		$actionname = '增加';
		$actionmessage = $missionname;
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	


		dheader("Location: ".dreferer()."");

} elseif($action == 'pushmissiontop') {

		if(empty($missionid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['missionstarttimeline'] = $_G['timestamp'];

		DB::update('work_project_mission', $newthreadinfo, "missionid='$missionid'");
		$actionmod = '项目任务';
		$actionname = '提优先级';
		$actionmessage = "MissionID：".$missionid;
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	


		dheader("Location: ".dreferer()."");


}         


?>