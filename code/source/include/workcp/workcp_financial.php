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
	DB::insert('work_financial_project', $data);

	dheader("Location: work.php?mod=financial&view=statistics&vieworder=onlyproject");
} elseif($action == 'edit') {

	$newpost['Organizationid'] = $Organizationid;
	$newpost['projectname'] = $projectname;
	$newpost['Projectprice'] = $price;

	$newpost['projectstarttimeline'] = $projectstarttimeline;

	$newpost['projectendtimeline'] = $projectendtimeline;

	$newpost['status'] = $status;
	DB::update('work_financial_project', $newpost, "projectid='$projectid'");

	dheader("Location: ".dreferer()."");
} elseif($action == 'delete') {

	$query = DB::query("SELECT * FROM ".DB::table('work_financial_project_mission')." WHERE projectid='$projectid'");
	while ($value = DB::fetch($query)) {
		
		$missionlist[] = $value; 
	}

	if(!empty($missionlist)) {
		showmessage("该项目下有未删除的任务，无法删除");
	}

	DB::delete('work_financial_project', "projectid='$projectid'");
	dheader("Location: ".dreferer()."");
} elseif($action == 'finish1') {

		if(empty($projectid)) {

			showmessage('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '1';

		DB::update('work_financial_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");
		//dheader("Location: work.php?mod=financial");


} elseif($action == 'finish9') {

		if(empty($projectid)) {

			showmessage('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '9';

		DB::update('work_financial_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");
		//dheader("Location: work.php?mod=financial");


} elseif($action == 'unfinish') {

		if(empty($projectid)) {

			showmessage('选择的项目不存在！', null, array(), array('showmsg' => true, 'login' => 1));
		}

		if($_G['adminid'] != '1') {

			showmessage('对不起，您无权进行此操作，请点击返回！');
		}

		if(!empty($_GET['dateline'])) {

			$dateline = $_GET['dateline'];

		}

		$newthreadinfo['status'] = '0';

		DB::update('work_financial_project', $newthreadinfo, "projectid='$projectid'");

		dheader("Location: ".dreferer()."");
		//dheader("Location: work.php?mod=financial");


} elseif($action == 'update_runningaccount') {

	$startcheckdateline = getgpc('startcheckdateline');
	$endcheckdateline = getgpc('endcheckdateline');

	DB::delete('work_financial_running_account', "runtimeline >= '$startcheckdateline' AND runtimeline <= '$endcheckdateline'");

	//获取客户列表
	$organizationlist = get_financial_organizationlist(0);
	//获取项目类型
	$typelist = get_financial_typelist('select');

	$query = DB::query("SELECT fm.*, fp.Organizationid, fp.projectstarttimeline, fp.projectendtimeline  FROM ".DB::table('work_financial_project_mission')." fm LEFT JOIN ".DB::table('work_financial_project')." fp ON fm.projectid = fp.projectid WHERE fp.projectstarttimeline >= $startcheckdateline AND fp.projectendtimeline <= $endcheckdateline AND fp.status='9' OR fp.status='1' ORDER BY fp.projectendtimeline ASC");
	while ($value = DB::fetch($query)) {


		$type = 'work_financial_project_mission';
		$typename = $typelist['ttypelist'][$value['projecttypeid']]['typename'];
		$runtypeid = $value['missionid'];


		if(!empty($value['work_project_projectname'])) {
			$runname = '【所属项目：'.$value['work_project_projectname'].'】- '.$value['missionname'];
		} else {
			$runname = $value['missionname'];
		}

		$editorid = $value['editorid'];
		$editor = $value['editor'];
		//$runtimeline = $value['projectstarttimeline'];
		$payout = $value['Projectprice'];


		$payer =$organizationlist[$value['Organizationid']]['Organizationname'];
		$runtimeline = $value['projectstarttimeline'];
		
		$data = array(
			'runid' => NULL,
			'type' => $type,
			'typename' => $typename,
			'runtypeid' => $runtypeid,
			'runname' => $runname,
			'editorid' => $editorid,
			'editor' => $editor,
			'runtimeline' => $runtimeline,
			'payout' => $payout,
			'payer' => $payer,

		);
		DB::insert('work_financial_running_account', $data);
	}




	//获取客户列表
	$organizationlist_project = get_organizationlist(0);

	$query = DB::query("SELECT * FROM ".DB::table('work_project')." WHERE status='9' OR status='1' AND projectstarttimeline >= $startcheckdateline AND projectendtimeline <= $endcheckdateline ORDER BY projectendtimeline ASC");
	while ($value = DB::fetch($query)) {

		$type = 'work_project';

		if($value['status'] == '1') {

			$typename = '应收账款';

		} elseif($value['status'] == '9') {

			$typename = '项目收入';
		}
		
		$runtypeid = $value['projectid'];
		$runname = $value['projectname'];
		$editorid = $value['editorid'];
		$editor = $value['editor'];
		$runtimeline = $value['projectendtimeline'];
		$income = $value['Projectprice'];
		$payer = $organizationlist_project[$value['Organizationid']]['Organizationname'];

		$data = array(
			'runid' => NULL,
			'type' => $type,
			'typename' => $typename,
			'runtypeid' => $runtypeid,
			'runname' => $runname,
			'editorid' => $editorid,
			'editor' => $editor,
			'runtimeline' => $runtimeline,
			'income' => $income,
			'payer' => $payer,

		);
		DB::insert('work_financial_running_account', $data);
	}



	dheader("Location: ".dreferer()."");


}  


?>