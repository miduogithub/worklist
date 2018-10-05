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

$price = $_GET['price'];
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


//检测类型是否项目支出
if(strpos($_GET['project_typeid'], ",") == true) {//包含 ， 则是项目支出，

	$project_typeid_arr = explode(",",$_GET['project_typeid']);

	$project_typeid = $project_typeid_arr[0];
	$work_project_projectid = $project_typeid_arr[1];

	//获取该项目资料
	$work_project_query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE projectid='$work_project_projectid'");
	$work_project_data = DB::fetch($work_project_query);
	$work_project_projectname = $work_project_data['projectname'];
	
} else {//不包含则是正常支出

	$project_typeid = $_GET['project_typeid'];
}



$query = DB::query("SELECT * FROM ".DB::table('work_financial_project_mission')." WHERE missionid='$missionid'");
while ($value = DB::fetch($query)) {
	
	$missioninfo = $value; 
}

if($action == 'add') {

	



	if(empty($projectid)) {
		showmessage("所属项目不能为空");
	}

	

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
		'Projectprice' => $price,
		'work_project_projectid' => $work_project_projectid,
		'work_project_projectname' => $work_project_projectname,
	);
	DB::insert('work_financial_project_mission', $data);


	if($_G['adminid'] == '1') {

		dheader("Location: work.php?mod=financial&view=mission&projectid=".$projectid."&vieworder=alleditor");
							
	} else {
		
		dheader("Location: work.php?mod=financial&view=mission&projectid=".$projectid."");
	}
	//dheader("Location: work.php?mod=financial&view=mission");

} elseif($action == 'edit') {

	if($missioninfo['status'] == '1') {
		showmessage("抱歉，该任务已经完成，您无权修改");
	}

	if(empty($projectid)) {
		showmessage("所属项目不能为空");
	}


	if(empty($project_typeid)) {
		showmessage("任务类型不能为空");
	}

	$missionname = $_GET['missionname'];

	if(empty($missionname)) {
		showmessage("任务名称不能为空");
	}

	$newpost['projectid'] = $projectid;
	$newpost['projecttypeid'] = $project_typeid;
	$newpost['editor'] = $editor;
	$newpost['editorid'] = $editorid;
	$newpost['missionname'] = $missionname;
	$newpost['missionstarttimeline'] = $missionstarttimeline;
	$newpost['Projectprice'] = $price;

	if(!empty($work_project_projectid) && !empty($work_project_projectname) ) {
		$newpost['work_project_projectid'] = $work_project_projectid;
		$newpost['work_project_projectname'] = $work_project_projectname;
	}

	DB::update('work_financial_project_mission', $newpost, "missionid='$missionid'");


	dheader("Location: work.php?mod=financial&view=mission&projectid=".$projectid."&vieworder=alleditor");
	//dheader("Location: ".dreferer()."");
} elseif($action == 'delete') {

	if($missioninfo['status'] == '1') {
		showmessage("抱歉，该任务已经完成，您无权删除");
	}

	DB::delete('work_financial_project_mission', "missionid='$missionid'");
	dheader("Location: ".dreferer()."");

} elseif($action == 'finish') {

		if(empty($missionid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '1';

		DB::update('work_financial_project_mission', $newthreadinfo, "missionid='$missionid'");

		$editorid = $_GET['editorid'];

		if(!empty($editorid)) {

			dheader("Location: work.php?mod=financial&view=mission&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=financial&view=mission");
		}


} elseif($action == 'unfinish') {

		if(empty($missionid)) {

			showmessage('选择的任务不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '0';

		DB::update('work_financial_project_mission', $newthreadinfo, "missionid='$missionid'");

		$editorid = $_GET['editorid'];

		if(!empty($editorid)) {

			dheader("Location: work.php?mod=financial&view=mission&editorid=".$editorid."");

		} else {

			dheader("Location: work.php?mod=financial&view=mission");
		}


}  


?>