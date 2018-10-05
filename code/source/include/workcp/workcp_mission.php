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


$query = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE missionid='$missionid'");
while ($value = DB::fetch($query)) {
	
	$missioninfo = $value; 
}

if($action == 'add') {


	if(empty($projectid)) {
		showmessage_work_sidebar("所属项目不能为空");
	}

	$project_typeid = $_GET['project_typeid'];

	if(empty($project_typeid)) {
		showmessage_work_sidebar("任务类型不能为空");
	}

	$missionname = $_GET['missionname'];

	if(empty($missionname)) {
		showmessage_work_sidebar("任务名称不能为空");
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
		'Projectprice' => $price,
	);
	DB::insert('work_project_mission', $data);

	$actionmod = '项目任务';
	$actionname = '增加';
	$actionmessage = $missionname;
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);	


	if($_G['adminid'] == '1') {

		dheader("Location: work.php?mod=project&view=mission&projectid=".$projectid."&vieworder=alleditor");

	} else {
		
		dheader("Location: work.php?mod=project&view=mission&projectid=".$projectid."");
	}
	//dheader("Location: work.php?mod=project&view=mission&editorid=".$editorid."");

} elseif($action == 'edit') {

	//$editorid = $_GET['editorid'];

	if($missioninfo['status'] == '1') {
		showmessage_work_sidebar("抱歉，该任务已经完成，您无权修改");
	}

	if(empty($projectid)) {
		showmessage_work_sidebar("所属项目不能为空");
	}

	$project_typeid = $_GET['project_typeid'];

	if(empty($project_typeid)) {
		showmessage_work_sidebar("任务类型不能为空");
	}

	$missionname = $_GET['missionname'];

	if(empty($missionname)) {
		showmessage_work_sidebar("任务名称不能为空");
	}

	$newpost['projectid'] = $projectid;
	$newpost['projecttypeid'] = $project_typeid;
	$newpost['editor'] = $editor;
	$newpost['editorid'] = $editorid;
	$newpost['missionname'] = $missionname;
	$newpost['missionstarttimeline'] = $missionstarttimeline;

	DB::update('work_project_mission', $newpost, "missionid='$missionid'");

	$actionmod = '项目任务';
	$actionname = '修改';
	$actionmessage = $missioninfo['missionname'];
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);	

	if($_G['adminid'] == '1') {

		dheader("Location: work.php?mod=project&view=mission&projectid=".$projectid."&vieworder=alleditor");

	} else {
		
		dheader("Location: work.php?mod=project&view=mission&projectid=".$projectid."");
	}

	//dheader("Location: work.php?mod=project&view=mission&editorid=".$editorid."");

	//dheader("Location: ".dreferer()."");
} elseif($action == 'delete') {

	if($missioninfo['status'] == '1') {
		showmessage_work_sidebar("抱歉，该任务已经完成，您无权删除");
	}

	DB::delete('work_project_mission', "missionid='$missionid'");

	$actionmod = '项目任务';
	$actionname = '删除';
	$actionmessage = $missioninfo['missionname'];
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);		

	dheader("Location: ".dreferer()."");

} elseif($action == 'finish') {

		if(empty($missionid)) {

			showmessage_work_sidebar('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {


			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '1';

		DB::update('work_project_mission', $newthreadinfo, "missionid='$missionid'");

		$editorid = $_GET['editorid'];

		$actionmod = '项目任务';
		$actionname = '完成';
		$actionmessage = $missioninfo['missionname'];
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);		


		dheader("Location: ".dreferer()."");
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=project&view=mission&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=project&view=mission");
		}


} elseif($action == 'unfinish') {

		if(empty($missionid)) {

			showmessage_work_sidebar('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '0';

		DB::update('work_project_mission', $newthreadinfo, "missionid='$missionid'");

		$actionmod = '项目任务';
		$actionname = '未完成';
		$actionmessage = $missioninfo['missionname'];
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	



		$editorid = $_GET['editorid'];

		dheader("Location: ".dreferer()."");
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=project&view=mission&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=project&view=mission");
		}


} elseif($action == 'status2') {

		if(empty($missionid)) {

			showmessage_work_sidebar('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '2';

		DB::update('work_project_mission', $newthreadinfo, "missionid='$missionid'");
		$actionmod = '项目任务';
		$actionname = '未通过';
		$actionmessage = $missioninfo['missionname'];
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	



		$editorid = $_GET['editorid'];

		dheader("Location: ".dreferer()."");
		if(!empty($editorid)) {

			dheader("Location: work.php?mod=financial&view=mission&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=financial&view=mission");
		}


} elseif($action == 'pushworklist') {


		if(empty($projectid)) {
			showmessage_work("请选择日志所关联的项目");

		}

		$workid = $_GET['workid'];
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
		$actionmessage = $missionname;
		//任务日志
		insert_work_action_logs($actionname,$actionmod,$actionmessage);	


		dheader("Location: work.php?mod=project&view=mission&projectid=".$projectid."&vieworder=alleditor");

} elseif($action == 'delete_pushworklist') {

	$workid = $_GET['workid'];

	DB::delete('work_project_worklist', "workid='$workid' AND projectid='$projectid'");

	$actionmod = '项目日志';
	$actionname = '删除';
	$actionmessage = $missioninfo['missionname'];
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);		

	dheader("Location: ".dreferer()."");

}     





?>