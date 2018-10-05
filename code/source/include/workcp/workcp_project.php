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
$projectid = $_GET['projectid'];

$Organizationid = $_GET['Organizationid'];
$projectname = $_GET['projectname'];
$price = $_GET['price'];
$status =  $_GET['status'];

$projectstarttime = getgpc('projectstarttime');
$projectstarttimeline = strtotime($projectstarttime);

$projectendtime = getgpc('projectendtime');
$projectendtimeline = strtotime($projectendtime);

if(empty($projectstarttime)) {

	$projectstarttimeline = $_G['timestamp'];
}


if($action == 'add') {

	$data = array(
		'projectid' => NULL,
		'Organizationid' => $Organizationid,
		'projectname' => $projectname,
		'status' => '0',
		'Projectprice' => $price,
		'projectstarttimeline' => $projectstarttimeline,
		'projectendtimeline' => $projectendtimeline,

	);
	DB::insert('work_project', $data);

	$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE 1 ORDER BY projectid DESC LIMIT 1");
	$project = DB::fetch($query);
	dheader("Location: work.php?mod=project&view=mission&projectid=".$project['projectid']."");

} elseif($action == 'edit') {

	$newpost['Organizationid'] = $Organizationid;
	$newpost['projectname'] = $projectname;
	$newpost['Projectprice'] = $price;
	
	$newpost['projectstarttimeline'] = $projectstarttimeline;
	$newpost['projectendtimeline'] = $projectendtimeline;

	$newpost['status'] = $status;

	DB::update('work_project ', $newpost, "projectid='$projectid'");

	if(!empty($_GET['project_editorid'])) {
		
		set_project_addfollow($projectid,$_GET['project_editorid']);
	}

	dheader("Location: ".dreferer()."");
} elseif($action == 'delete') {


	$query = DB::query("SELECT * FROM ".DB::table('work_project_mission')." WHERE projectid='$projectid'");
	while ($value = DB::fetch($query)) {
		
		$missionlist[] = $value; 
	}

	if(!empty($missionlist)) {
		showmessage_work_sidebar("该项目下有未删除的任务，无法删除");
	}

	DB::delete('work_project', "projectid='$projectid'");
	dheader("Location: ".dreferer()."");
} elseif($action == 'finish1') {

		if(empty($projectid)) {

			showmessage_work_sidebar('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '1';

		DB::update('work_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");


} elseif($action == 'finish9') {

		if(empty($projectid)) {

			showmessage_work_sidebar('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '9';

		DB::update('work_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");


} elseif($action == 'finish99') {

		if(empty($projectid)) {

			showmessage_work_sidebar('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '99';

		DB::update('work_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");


}  elseif($action == 'unfinish') {

		if(empty($projectid)) {

			showmessage_work_sidebar('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '0';

		DB::update('work_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");


} elseif($action == 'favicon0') {

		if(empty($projectid)) {

			showmessage_work_sidebar('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['favicon'] = '0';

		DB::update('work_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");


} elseif($action == 'favicon1') {

		if(empty($projectid)) {

			showmessage_work_sidebar('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['favicon'] = '1';

		DB::update('work_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");

} elseif($action == 'deletefollow') {

	$followuid = $_GET['followuid'];
	DB::delete('work_project_follow', "projectid='$projectid' AND uid='$followuid'");
	dheader("Location: ".dreferer()."");
} elseif($action == 'RefreshProjectEndTimeLine') {

	if(empty($projectid)) {

		showmessage_work_sidebar('您选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
	}

	if($_G['adminid'] != '1') {

		showmessage_work_sidebar('对不起，您无权进行此操作，请点击返回！');
	}

	if(!empty($_GET['dateline'])) {

		$dateline = $_GET['dateline'];

	}

	$newthreadinfo['projectendtimeline'] = $_G['timestamp'];

	DB::update('work_project', $newthreadinfo, "projectid='$projectid'");
	$actionmod = '项目';
	$actionname = '更新项目结束时间';
	$actionmessage = "ProjectId：".$missionid;
	//任务日志
	insert_work_action_logs($actionname,$actionmod,$actionmessage);	


	dheader("Location: ".dreferer()."");
} 





?>